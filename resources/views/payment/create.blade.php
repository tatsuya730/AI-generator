<x-app-layout>
    <div class="container" style="padding: 20px; max-width: 600px; margin: auto;">
        @if (session('flash_alert'))
            <div style="padding: 10px; background-color: #f8d7da; border: 1px solid #f5c2c7; margin-bottom: 20px; border-radius: 5px; color: #842029;">
                {{ session('flash_alert') }}
            </div>
        @elseif(session('status'))
            <div style="padding: 10px; background-color: #d1e7dd; border: 1px solid #badbcc; margin-bottom: 20px; border-radius: 5px; color: #0f5132;">
                {{ session('status') }}
            </div>
        @endif
        <div style="padding: 20px; border: 1px solid #ced4da; border-radius: 5px; background-color: #fff;">
            <div style="margin-bottom: 20px; font-weight: bold;">Stripe決済</div>
            <form id="card-form" action="{{ route('payment.store') }}" method="POST">
                @csrf
                <div style="margin-bottom: 20px;">
                    <label for="card_number" style="display: block; margin-bottom: 10px;">カード番号</label>
                    <div id="card-number" style="padding: 10px; border: 1px solid #ced4da; border-radius: 5px;"></div>
                </div>

                <div style="margin-bottom: 20px;">
                    <label for="card_expiry" style="display: block; margin-bottom: 10px;">有効期限</label>
                    <div id="card-expiry" style="padding: 10px; border: 1px solid #ced4da; border-radius: 5px;"></div>
                </div>

                <div style="margin-bottom: 20px;">
                    <label for="card-cvc" style="display: block; margin-bottom: 10px;">セキュリティコード</label>
                    <div id="card-cvc" style="padding: 10px; border: 1px solid #ced4da; border-radius: 5px;"></div>
                </div>

                <div id="card-errors" style="color: #fa755a;"></div>

                <button style="padding: 10px 20px; border: none; border-radius: 5px; background-color: #007bff; color: white; cursor: pointer; margin-top: 10px;">支払い</button>
            </form>
        </div>
    </div>
    <!-- Stripeのスクリプトと関連するJavaScriptは同じまま -->
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        // ここにあなたのJavaScriptコード
    </script>
</x-app-layout>
