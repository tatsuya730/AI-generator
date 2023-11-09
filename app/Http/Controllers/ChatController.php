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
        // 既存のセッションデータを取得するか、デフォルト値を設定します。
        $applicationText = session()->get('application_text', '');

        // 'application.create' ビューにデータを渡します。
        return view('application.create', ['applicationText' => $applicationText]);
    }

    public function generateApplication(Request $request)
    {
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

        // 結果を表示するビューにデータを渡す
        return view('application.create', ['applicationText' => $applicationText]);
    }
}
