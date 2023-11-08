<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenAI\Laravel\Facades\OpenAI;

class ChatController extends Controller
{
    public function chat(Request $request)
    {
        $inputText = $request->food;
        if ($inputText != null) {
            $responseText = $this->generateResponse($inputText);

            $messages = [
                ['title' => '食材', 'content' => $inputText],
                ['title' => 'レシピ', 'content' => $responseText]
            ];
            return view('chat.create', ['messages' => $messages]);
        }
        return view('chat.create');
    }

    public function generateResponse($inputText)
    {
        $result = OpenAI::completions()->create([
            'model' => 'gpt-3.5-turbo-instruct',
            'prompt' => '冷蔵庫にある食材を教えます。' . $inputText . '美味しいレシピを5文以内で教えてください。',
            'temperature' => 0.8,
            'max_tokens' => 150,
        ]);
        return $result['choices'][0]['text'];
    }
}
