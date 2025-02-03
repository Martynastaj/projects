<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ route('dashboard') }}" class="text-indigo-700 font-bold text-2xl">
                    BooKrak
                </a>
            </div>

            <!-- Navigation Links -->
            <div class="hidden sm:flex sm:items-center sm:space-x-8">
                @auth
                    @if (Auth::user()->role === 'client')
                        <x-nav-link id="client-dashboard-button" :href="route('client.dashboard')" :active="request()->routeIs('client.dashboard')">
                            {{ __('Strona Klienta') }}
                        </x-nav-link>
                    @elseif (Auth::user()->role === 'provider')
                        <x-nav-link id="provider-dashboard-button" :href="route('provider.dashboard')" :active="request()->routeIs('provider.dashboard')">
                            {{ __('Strona Usługodawcy') }}
                        </x-nav-link>
                    @elseif (Auth::user()->role === 'admin')
                        <x-nav-link id="admin-dashboard-button" :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                            {{ __('Strona Admina') }}
                        </x-nav-link>
                        <x-nav-link id="admin-statistics-button" :href="route('admin.stat')" :active="request()->routeIs('admin.stat')">
                            {{ __('Statystyki') }}
                        </x-nav-link>
                    @endif
                @endauth

                @guest
                    <x-nav-link id="services-button" :href="route('services.index')" :active="request()->routeIs('services.index')">
                        {{ __('Usługi') }}
                    </x-nav-link>
                    <x-nav-link id="login-button" :href="route('login')" :active="request()->routeIs('login')">
                        {{ __('Zaloguj się') }}
                    </x-nav-link>
                    <x-nav-link id="register-button" :href="route('register')" :active="request()->routeIs('register')">
                        {{ __('Zarejestruj się') }}
                    </x-nav-link>
                @endguest
            </div>

            <!-- User Dropdown Menu -->
            @auth
                <div class="hidden sm:flex sm:items-center sm:space-x-4">
                    <x-dropdown id="user-menu-button" align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-gray-500 bg-white hover:text-gray-700">
                                <span>{{ Auth::user()->name }}</span>
                                <svg class="ms-2 h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link id="profile-button" :href="route('profile.edit')">
                                {{ __('Profil') }}
                            </x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link id="logout-button" :href="route('logout')"
                                                 onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Wyloguj się') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            @endauth
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="space-y-1">
            @auth
                <x-responsive-nav-link id="responsive-dashboard-button" :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
            @endauth
            @guest
                <x-responsive-nav-link id="responsive-services-button" :href="route('services.index')" :active="request()->routeIs('services.index')">
                    {{ __('Usługi') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link id="responsive-login-button" :href="route('login')" :active="request()->routeIs('login')">
                    {{ __('Zaloguj się') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link id="responsive-register-button" :href="route('register')" :active="request()->routeIs('register')">
                    {{ __('Zarejestruj się') }}
                </x-responsive-nav-link>
            @endguest
        </div>

        <!-- Responsive Settings Options -->
        @auth
            <div class="border-t border-gray-200 pt-4">
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link id="responsive-profile-button" :href="route('profile.edit')">
                        {{ __('Profil') }}
                    </x-responsive-nav-link>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link id="responsive-logout-button" :href="route('logout')"
                                               onclick="event.preventDefault(); this.closest('form').submit();">
                            {{ __('Wyloguj się') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @endauth
    </div>
</nav>
