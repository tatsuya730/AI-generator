<style>
.text-white {
    font-weight: bold; /* ここでテキストの太さを指定 */
}

/* "補助金を生成する" ボタンのスタイル */
.generate-subidy-btn {
    background-color: green; /* ボタンの背景色を緑に */
    font-weight: bold; /* ここでテキストの太さを指定 */
    color: white; /* テキストの色を白に */
    padding: 0.75rem 1.5rem; /* パディングを設定 */
    border-radius: 0.375rem; /* ボーダーの丸みを設定 */
    text-decoration: none; /* テキストの下線を消す */
    transition: background-color 0.2s; /* 背景色のトランジションを設定 */
}

.generate-subidy-btn:hover {
    background-color: darkgreen; /* ホバー時の背景色を濃い緑に */
}
</style>

<nav x-data="{ open: false }" class="bg-black border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('root') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-white" />
                    </a>
                </div>
            </div>

            <!-- 新しいリンクを追加 -->
            <div class="flex items-center ml-6">
                <a href="{{ route('learn.subsidy') }}" class="text-sm text-white hover:bg-gray-700 px-3 py-2 rounded-md transition ease-in-out duration-150">
                    補助金について知る
                </a>

                <!-- 新しい「価格」リンク -->
                <a href="{{ route('pricing') }}" class="text-sm text-white hover:bg-gray-700 px-3 py-2 rounded-md transition ease-in-out duration-150">
                    価格
                </a>
            </div>

            <!-- 非認証ユーザー向けのナビゲーションリンク -->
            <div class="flex items-center space-x-4">
                @guest
                    <a href="{{ route('login') }}" class="text-sm text-white hover:bg-gray-700 px-3 py-2 rounded-md transition ease-in-out duration-150">ログイン</a>
                    <a href="{{ route('register') }}" class="text-sm text-white hover:bg-gray-700 px-3 py-2 rounded-md transition ease-in-out duration-150">サインアップ</a>
                @else
                    <div class="flex items-center ml-6">
                    <!-- "補助金を生成する" ボタンを追加 -->
                    <a href="{{ route('application.form') }}" class="generate-subidy-btn">
                        補助金を生成する
                    </a>
                    </div>
                    <a href="{{ route('profile.edit') }}" class="text-sm text-white hover:bg-gray-700 px-3 py-2 rounded-md transition ease-in-out duration-150">プロフィール</a>
                    <a href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();"
                    class="text-sm text-white hover:bg-gray-700 px-3 py-2 rounded-md transition ease-in-out duration-150">ログアウト</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                        @csrf
                    </form>
                @endguest
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            @auth
                <div class="px-4">
                    <!-- 認証ユーザー情報のテキスト色を白に変更 -->
                    <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-300">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>

                    <!-- Authentication -->
                    <x-responsive-nav-link :href="route('posts.create')">
                        {{ __('Create Post') }}
                    </x-responsive-nav-link>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            @else
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800">guest</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('register')">
                        {{ __('Sign Up') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('login')">
                        {{ __('Log In') }}
                    </x-responsive-nav-link>
                </div>
            @endauth
        </div>
    </div>
</nav>
