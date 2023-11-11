<section>
    <!-- コイン情報セクションの追加 -->
    <div class="mt-6 bg-white shadow sm:rounded-lg p-4">
        <h3 class="text-lg font-medium text-gray-900">{{ __('Coin Balance') }}</h3>
        <p class="mt-1 text-sm text-gray-600">
            {{ __('This is the number of coins you currently have in your account.') }}
        </p>
        <div class="mt-4">
            <p class="text-xl font-semibold">{{ $user->coins }} コイン</p>
        </div>
    </div>

    <!-- 既存のプロファイル更新フォームのコード -->
</section>
