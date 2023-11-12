<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // ここでDBファサードをインポートします
use Exception;

class PaymentController extends Controller
{
    /**
     * 決済フォーム表示
     */
    public function create(Request $request)
    {
        $amount = $request->amount;
        return view('payment.create', compact('amount'));
    }
    public function store(Request $request)
    {
        \Stripe\Stripe::setApiKey(config('stripe.stripe_secret_key'));

        DB::beginTransaction(); // トランザクションを開始するにはこの行を追加

        try {
            $user = $request->user(); // 現在のログインユーザー

            // StripeのChargeオブジェクトを作成して決済を実行
            $charge = \Stripe\Charge::create([
                'amount' => $request->amount,
                'currency' => 'jpy',
                'source' => $request->stripeToken,
                'description' => 'コインの購入',
            ]);

            if ($charge->paid) {
                // コインの計算ロジック（例えば、100円で1コインとする）
                $coinsToAdd = $request->amount / 100; // 1コインあたりの金額で割る
                $user->coins += $coinsToAdd; // コインを追加
                $user->save(); // ユーザー情報を保存
            }

            DB::commit(); // トランザクションをコミット
            return back()->with('status', '決済が完了しました！');
        } catch (Exception $e) {
            DB::rollBack(); // エラーが発生したらロールバック
            return back()->with('flash_alert', 'エラー: ' . $e->getMessage());
        }
    }
}
