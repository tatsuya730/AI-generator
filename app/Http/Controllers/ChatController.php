<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
            // ファイルを保存
            $path = $request->file('file')->storeAs('rules', '01_Customer_information_rules.txt');
            
            // ファイルアップロードの成功メッセージ
            return back()->with('status', 'ファイルが正常にアップロードされました。');
        }

        // ファイルがない場合のエラーメッセージ
        return back()->with('error', 'ファイルがアップロードされていません。');
    }

public function generateApplication(Request $request)
{
        // ファイルのアップロード処理を追加
        if ($request->hasFile('file')) {
            // ファイルを保存
            $path = $request->file('file')->store('rules', 'public');
            // 保存したファイルパスを使用するか、または後続の処理に変更が必要かもしれません。
        } else {
            // ファイルがアップロードされていない場合の処理をここに追加します。
            // 例: エラーメッセージをセッションに追加
            return back()->with('error', 'ファイルがアップロードされていません。');
        }

        // 共通ルールと顧客情報のテキストファイルを読み込む
        $commonRules = Storage::get('00_Common_rules.txt');
        $customerInformation = Storage::get('01_Customer_information_rules.txt');

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

            // 共通ルール、顧客情報、および現在の章のルールを組み合わせる
            $prompt = $commonRules . "\n" . $customerInformation . "\n" . $chapterContent;

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
        
        // 結果を表示するビューにリダイレクトしてデータを渡す（変更する部分）
        return redirect()->route('application.form')->with('application_text', $applicationText);
    }

}
