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

        <!-- 申請書とファイルアップロードの統合フォーム -->
        <form action="{{ route('application.generate') }}" method="POST" enctype="multipart/form-data">
            @csrf <!-- CSRFトークンを追加 -->
            <div class="form-group">
                <label for="file">顧客情報ルールファイル:</label>
                <input type="file" class="form-control-file" id="file" name="file">
            </div>
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
