<nav x-data="{ open: false }" class="bg-red-600 text-white shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="header-container h-16">
            <!-- Left Side: LedgerMate App Name -->
            <div>
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
                    <!-- <svg class="w-2 h-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg> -->
                    <span class="text-xl font-bold tracking-tight">
                        LedgerMate
                    </span>
                    
                </a>
            </div>

            <!-- Center: Shop Name (only shows if $shop exists) -->
                <div class="shop-header">
                        <h1 class="shop-name">
                            @php
                                $currentShop = session('current_shop');
                                if ($currentShop && isset($currentShop->name)) {
                                    echo $currentShop->name;
                                }
                            @endphp
                        </h1>
                        @php
                            $currentShop = session('current_shop');
                        @endphp

                        @if($currentShop && isset($currentShop->category))
                            <div class="shop-category">
                                {{ $currentShop->category }}
                            </div>
                        @endif
                </div>

            <!-- Right Side: Profile Icon -->
            <div class="flex items-center" style="display: block; width: fit-content; margin-left: auto;">
                <!-- Desktop Profile Dropdown -->
                <div class="hidden sm:flex sm:items-center">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center p-2 border border-transparent text-sm leading-4 font-medium rounded-full text-white hover:bg-red-700 focus:outline-none transition ease-in-out duration-150">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="px-4 py-3 border-b border-gray-200">
                                <div class="font-medium text-base text-gray-900">{{ Auth::user()->name }}</div>
                                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                            </div>
                            
                            <x-dropdown-link :href="route('profile.edit')" class="text-gray-700 hover:text-gray-900 hover:bg-gray-100">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            @if(session('current_shop'))
                                <x-dropdown-link :href="route('shops.settings', session('current_shop'))" class="text-gray-700 hover:text-gray-900 hover:bg-gray-100">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    Shop Settings
                                </x-dropdown-link>
                            @endif

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();"
                                        class="text-red-600 hover:text-red-800 hover:bg-red-50">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                    </svg>
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>

                <!-- Mobile menu button -->
                <div class="flex items-center sm:hidden">
                    @if(isset($shop) && $shop instanceof \App\Models\Shop && $shop->user_id === Auth::id())
                        <div class="mr-4 text-sm truncate max-w-[120px]">
                            <div class="font-medium">{{ $shop->name }}</div>
                        </div>
                    @endif
                    
                    <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md hover:bg-red-700 focus:outline-none transition duration-150 ease-in-out">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-red-700">
        <div class="pt-2 pb-3 space-y-1">
            <!-- Dashboard Link -->
            <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-2 text-red-100 hover:text-white hover:bg-red-600">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                Dashboard
            </a>

            <!-- Current Shop Info -->
            @if(isset($shop) && $shop instanceof \App\Models\Shop && $shop->user_id === Auth::id())
                <div class="px-4 pt-3 pb-2 border-t border-red-600">
                    <div class="text-sm font-medium text-red-200">Current Shop</div>
                    <div class="text-lg font-semibold text-white mt-1">{{ $shop->name }}</div>
                    <div class="text-sm text-red-100">{{ ucfirst($shop->category) }}</div>
                </div>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-red-600">
            <div class="px-4">
                <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-red-200">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-2 text-red-100 hover:text-white hover:bg-red-600">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Profile
                </a>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}" 
                       onclick="event.preventDefault(); this.closest('form').submit();"
                       class="flex items-center px-4 py-2 text-red-100 hover:text-white hover:bg-red-600">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        Log Out
                    </a>
                </form>
            </div>
        </div>
    </div>
</nav>

<style>
    [x-cloak] { display: none !important; }

    .header-container{
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 12px;
        align-items: center;
    }
    
    .dropdown-content {
        background-color: white;
        border-radius: 0.5rem;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        border: 1px solid #e5e7eb;
        z-index: 50;
    }


    .shop-header{
        grid-column: 2/4;
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 12px;
    }

    .shop-name{
        font-size: 25px;
        font-weight: 600;
        color: #fff;
    }

    .shop-category{
        display: block;
        width: fit-content;
        padding: 2px 10px;
        background: white;
        color: #dc1616;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        border-radius: 30px;
    }
    
    
    .nav-link {
        padding: 0.5rem 1rem;
        font-weight: 500;
        color: #f3f4f6;
        border-radius: 0.375rem;
        transition: all 0.2s;
    }
    
    .nav-link:hover {
        color: white;
        background-color: rgba(255, 255, 255, 0.1);
    }
    
    .nav-link.active {
        color: white;
        background-color: rgba(255, 255, 255, 0.2);
    }
    
    .responsive-nav-link {
        display: flex;
        align-items: center;
        padding: 0.75rem 1rem;
        color: #f3f4f6;
        transition: all 0.2s;
    }
    
    .responsive-nav-link:hover {
        color: white;
        background-color: rgba(255, 255, 255, 0.1);
    }
    
    button:hover .group-hover\:text-red-200 {
        color: #fecaca;
    }
</style>