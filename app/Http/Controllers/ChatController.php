<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use OpenAI\Laravel\Facades\OpenAI;

class ChatController extends Controller
{
    // 新しいメソッドをChatControllerに追加します。
    public function showApplicationForm()
    {
        // セッションからapplication_textを取得、なければデフォルトの空テキストを使用
        $applicationText = session('application_text', '');

        // 'application.create' ビューを表示する
        return view('application.create', ['applicationText' => $applicationText]);
    }

    public function uploadFile(Request $request)
    {
        // ファイルの存在確認
        if ($request->hasFile('file')) {
            // ファイルの内容を読み込む
            $fileContent = file_get_contents($request->file('file')->getRealPath());

            // ファイルの内容をセッションに保存
            session(['uploaded_file_content' => $fileContent]);

            // ファイルアップロードの成功メッセージ
            return back()->with('status', 'ファイルが正常にアップロードされました。');
        }

        // ファイルがない場合のエラーメッセージ
        return back()->with('error', 'ファイルがアップロードされていません。');
    }

    public function generateApplication(Request $request)
    {
        $user = Auth::user(); // 現在のユーザーを取得

        // ユーザーのコインが足りるかチェック
        if ($user->coins < 100) {
            // コインが不足している場合はエラーメッセージと共にリダイレクト
            return back()->with('error', 'コインが不足しています。');
        }

        // 共通ルールファイルを読み込む
        $commonRules = Storage::get('00_Common_rules.txt');

        // セッションからアップロードされたファイルの内容を取得
        $fileContent = session('uploaded_file_content', '');

        // 各章の追加ルールファイルを読み込む
        $chapters = [
            '02_Company_overview_rules.txt',
            '03_Needs_and_market_trend_rules.txt',
            '04_Strengths_rules.txt',
            '05_Management_policy_rules.txt',
        ];

        // 各章ごとに文章を生成
        $generatedTexts = [];

        foreach ($chapters as $index => $chapterFile) {
            $chapterContent = Storage::get($chapterFile);

            // 共通ルール、顧客情報ルール、および現在の章のルールを組み合わせる
            $prompt = $commonRules . "\n" . $fileContent . "\n" . $chapterContent;

            // APIに送信し、応答を取得
            $response = OpenAI::completions()->create([
                'model' => 'gpt-3.5-turbo-instruct',
                'prompt' => $prompt,
                'temperature' => 0.1,
                'max_tokens' => 50,
            ]);

            // 応答のテキストを配列に保存
            $generatedTexts["chapter" . ($index + 1)] = $response['choices'][0]['text'];
        }

        // 生成された各章のテキストを合体させる
        $applicationText = implode("\n\n", $generatedTexts);

        // 生成されたテキストをセッションに保存する
        session(['application_text' => $applicationText]);

        // ユーザーのコインを減らす
        $user->coins -= 100;
        $user->save(); // コインの変更をデータベースに保存

        // 結果を表示するビューにリダイレクトしてデータを渡す
        return redirect()->route('application.form')->with([
            'application_text' => $applicationText,
            'status' => '100コインを消費して、申請書が生成されました。'
        ]);
    }
}
