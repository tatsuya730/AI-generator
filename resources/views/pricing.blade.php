<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>価格ページ</title>
    <!-- BootstrapのCSSファイルへのリンクを挿入します -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">価格表</h1>
        <div class="row">
            <!-- ベーシックプラン -->
            <div class="col-md-4">
                <div class="card mb-4 shadow-sm">
                    <div class="card-header">
                        <h4 class="my-0 font-weight-normal">ベーシック</h4>
                    </div>
                    <div class="card-body">
                        <h1 class="card-title pricing-card-title">¥1,000 <small class="text-muted">/ 月</small></h1>
                        <ul class="list-unstyled mt-3 mb-4">
                            <li>10ユーザーまで</li>
                            <li>2 GBのストレージ</li>
                            <li>メールサポート</li>
                            <li>ヘルプセンターアクセス</li>
                        </ul>
                        <button type="button" class="btn btn-lg btn-block btn-outline-primary">サインアップ</button>
                    </div>
                </div>
            </div>
            <!-- プロプラン -->
            <div class="col-md-4">
                <div class="card mb-4 shadow-sm">
                    <div class="card-header">
                        <h4 class="my-0 font-weight-normal">プロ</h4>
                    </div>
                    <div class="card-body">
                        <h1 class="card-title pricing-card-title">¥2,000 <small class="text-muted">/ 月</small></h1>
                        <ul class="list-unstyled mt-3 mb-4">
                            <li>20ユーザーまで</li>
                            <li>10 GBのストレージ</li>
                            <li>優先メールサポート</li>
                            <li>ヘルプセンターアクセス</li>
                        </ul>
                        <button type="button" class="btn btn-lg btn-block btn-primary">開始</button>
                    </div>
                </div>
            </div>
            <!-- エンタープライズプラン -->
            <div class="col-md-4">
                <div class="card mb-4 shadow-sm">
                    <div class="card-header">
                        <h4 class="my-0 font-weight-normal">エンタープライズ</h4>
                    </div>
                    <div class="card-body">
                        <h1 class="card-title pricing-card-title">¥3,000 <small class="text-muted">/ 月</small></h1>
                        <ul class="list-unstyled mt-3 mb-4">
                            <li>50ユーザーまで</li>
                            <li>30 GBのストレージ</li>
                            <li>電話およびメールサポート</li>
                            <li>ヘルプセンターアクセス</li>
                        </ul>
                        <button type="button" class="btn btn-lg btn-block btn-primary">お問い合わせ</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- オプショナルのJavaScript -->
    <!-- 最初にjQuery、次にPopper.js、次にBootstrap JS -->
    <script src="{{ asset('js/jquery-3.5.1.slim.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
</body>
</html>
