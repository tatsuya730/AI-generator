<x-app-layout>
    <div class="container mt-4">

        <!-- コイン残高を表示するセクション -->
        <div class="coin-balance" style="margin-bottom: 20px;">
            <h2>現在のコイン残高: <span id="coin-balance">{{ Auth::user()->coins ?? 'Loading...' }}</span> コイン</h2>
        </div>

        <!-- ステータスメッセージ -->
        <div id="status-message" class="status-message" style="display: none; margin-bottom: 20px; padding: 10px; background-color: #ffdd57; border-radius: 5px; text-align: center;">現在文章を生成中...</div>

        @if (session('status'))
            <div class="alert" role="alert" style="background-color: #d4edda; color: #155724; padding: 10px; border-radius: 5px;">
                {{ session('status') }}
            </div>
        @endif

        <!-- ファイルアップロードフォーム -->
        <form id="file-upload-form" action="{{ route('file.upload') }}" method="POST" enctype="multipart/form-data" style="margin-bottom: 20px;">
            @csrf
            <label style="display: inline-block; padding: 6px 12px; cursor: pointer; background-color: #f8f9fa; border: 1px solid #ced4da; border-radius: 4px; margin-right: 8px;">
                ファイルを選択<input type="file" id="file-input" name="file" hidden required onchange="updateFileName()">
            </label>
            <span id="file-name">選択されていません</span>
            <button type="submit" class="upload-button">ファイルをアップロード</button>
        </form>

        <!-- 申請書の再生成ボタン -->
        <form id="application-form" action="{{ route('application.generate') }}" method="POST" style="margin-bottom: 20px;">
            @csrf
            <button type="submit" class="generate-button">新しい申請書を生成</button>
        </form>

        <hr>

        <!-- 申請書テキストの表示エリア -->
        <div class="text-display-area" style="background-color: #fff; border: 1px solid #ced4da; border-radius: 4px; padding: 15px; margin-bottom: 20px;">
            <pre>{{ $applicationText ?? '' }}</pre>
        </div>

        <hr>

        <!-- コピー用ボタン -->
        <button id="copyButton" class="copy-button">テキストをコピー</button>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        function updateFileName() {
            var input = document.getElementById('file-input');
            var fileName = input.files.length > 0 ? input.files[0].name : "選択されていません";
            document.getElementById('file-name').textContent = fileName;
        }

        document.getElementById('application-form').addEventListener('submit', function() {
            document.getElementById('status-message').style.display = 'block'; // 生成中メッセージを表示
        });

        document.getElementById('copyButton').addEventListener('click', function() {
            var text = document.querySelector('pre').innerText;
            var elem = document.createElement('textarea');
            document.body.appendChild(elem);
            elem.value = text;
            elem.select();
            document.execCommand('copy');
            document.body.removeChild(elem);
            alert('テキストがコピーされました');
        });
    </script>
</x-app-layout>

<style>
    .status-message {
        /* 生成中のステータスメッセージスタイル */
        background-color: #ffcc00;
        color: #333;
        text-align: center;
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 20px;
    }
    .upload-button, .generate-button, .copy-button {
        /* ボタン共通スタイル */
        padding: 6px 12px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-weight: bold;
        margin-left: 8px; /* ラベルとボタンの間隔を適切に */
    }
    .upload-button {
        background-color: #28a745;
        color: white;
    }
    .generate-button {
        background-color: #007bff;
        color: white;
    }
    .copy-button {
        background-color: #6c757d;
        color: white;
    }
    .text-display-area pre {
        /* テキスト表示エリアスタイル */
        margin-bottom: 0;
    }

    .text-display-area pre {
        /* テキスト表示エリアスタイル */
        margin-bottom: 0;
        max-height: 300px; /* 最大高さを設定 */
        overflow-y: auto; /* 垂直方向のオーバーフロー時にスクロールバーを表示 */
        white-space: pre-wrap; /* 折り返しを許可 */
        word-wrap: break-word; /* 単語の途中で折り返しを許可 */
    }

    /* コイン残高表示スタイル */
    .coin-balance h2 {
        font-size: 1rem;
        color: #4a5568; /* テキストの色 */
        padding: 10px;
        background-color: #e2e8f0; /* 背景色 */
        border-radius: 5px;
        text-align: center; /* テキストを中央揃え */
    }
</style>
