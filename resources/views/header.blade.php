<!-- resources/views/layouts/header.blade.php -->
<header class="bg-gray-100">
    <nav class="mx-auto flex max-w-7xl items-center justify-between p-6 lg:px-8" aria-label="Global">
        <div class="flex lg:flex-1">
            <a href="/" class="flex items-center">
                <img src="https://flowbite.com/docs/images/logo.svg" class="mr-3 h-6 sm:h-9" alt="Lede Tech Logo"/>
                <span class="self-center text-xl font-semibold whitespace-nowrap">Lede Tech</span>
            </a>
        </div>
        <div class="lg:flex lg:gap-x-12">
            @if (Route::has('login'))
                <div class="relative">
                    <nav class="-mx-3 flex flex-1 justify-end">
                        @guest
                            <a href="{{ route('login') }}" class="text-black bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-4 lg:px-5 py-2 lg:py-2.5 mr-2">
                                Log in
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="text-black bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-4 lg:px-5 py-2 lg:py-2.5 mr-2">
                                    Register
                                </a>
                            @endif
                        @else
                            <a href="{{ route('profile.edit') }}" class="text-black bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-4 lg:px-5 py-2 lg:py-2.5 mr-2">
                                Profile
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="text-black bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-4 lg:px-5 py-2 lg:py-2.5 mr-2">
                                    Log out
                                </button>
                            </form>
                        @endguest
                    </nav>
                </div>
            @endif
        </div>
    </nav>
</header>
