<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <!-- ビューポートの設定を行い、レスポンシブデザインに対応 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>申請書生成アプリケーション</title>
    <!-- Laravelのアセット関数を使用して、CSSファイルへのリンクを挿入 -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- preタグ内でのテキストの折り返しを有効にするためのスタイル -->
    <style>
        pre {
            white-space: pre-wrap;
            /* 改行と空白を保持しつつ、必要に応じて折り返しを行う */
            word-wrap: break-word;
            /* 長い単語が端に達した場合に折り返す */
            overflow-wrap: break-word;
            /* 長い単語が端に達した場合に折り返す */
        }
    </style>
</head>

<body>
    <div class="container mt-4">
        <h1>AI補助金ジェネレーター</h1>
        <!-- セッションメッセージがある場合は表示 -->
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <!-- ファイルアップロードフォーム -->
        <form action="{{ route('file.upload') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" name="file" required> <!-- この行を修正 -->
            <button type="submit" class="btn btn-success mt-3">ファイルをアップロード</button>
        </form>

        <!-- 申請書の再生成ボタン -->
        <form action="{{ route('application.generate') }}" method="POST">
            @csrf <!-- CSRFトークンを追加 -->
            <button type="submit" class="btn btn-primary mt-3">新しい申請書を生成</button>
        </form>

        <!-- 区切りの線を表示 -->
        <hr>

        <!-- 申請書テキストの表示エリア -->
        <div class="card">
            <div class="card-body">
                <!-- preタグを使用してフォーマットされたテキストを表示 -->
                <pre>{{ $applicationText }}</pre>
            </div>
        </div>

    </div>
    <!-- Laravelのアセット関数を使用して、JavaScriptバンドルへのリンクを挿入 -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>
