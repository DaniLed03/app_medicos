<nav class="bg-[#2D7498] border-gray-200">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
      <a href="{{ route('dashboardSecretaria') }}" class="flex items-center space-x-3">
          <img src="{{ asset('images/LedeHealth.png') }}" alt="LedeHealth" class="h-10 w-auto">
          <span class="self-center text-2xl font-semibold whitespace-nowrap text-white">Lede<span class="text-[#33AD9B]">Health</span></span>
        </a>
      <div class="flex items-center md:order-2 space-x-3 md:space-x-0" x-data="{ open: false }">
        <button @click="open = !open" type="button" class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600" id="user-menu-button" aria-expanded="false">
          <span class="sr-only">Open user menu</span>
          <img class="w-8 h-8 rounded-full" src="{{ asset('images/user-photo.jpg') }}" alt="user photo">
        </button>
        <!-- Dropdown menu -->
        <div x-show="open" @click.away="open = false" class="z-50 mt-10 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600 absolute right-0 mt-12 w-48" id="user-dropdown">
          <div class="px-4 py-3 bg-gray-100 dark:bg-gray-700">
            <span class="block text-sm font-semibold text-gray-900 dark:text-white">{{ Auth::user()->name }}</span>
            <span class="block text-sm text-gray-500 truncate dark:text-gray-400">{{ Auth::user()->email }}</span>
          </div>
          <ul class="py-2 bg-white dark:bg-gray-700" aria-labelledby="user-menu-button">
            <li>
              <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-[#33AD9B] dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Profile</a>
            </li>
            <li>
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault(); this.closest('form').submit();"
                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-[#33AD9B] dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Sign out</a>
              </form>
            </li>
          </ul>
        </div>
      </div>
      <button data-collapse-toggle="navbar-user" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="navbar-user" aria-expanded="false">
        <span class="sr-only">Open main menu</span>
        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
        </svg>
      </button>
      <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-user">
        <ul class="flex flex-col font-medium p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:space-x-8 md:flex-row md:mt-0 md:border-0 md:bg-[#2D7498] dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
          <li>
            <a href="{{ route('dashboardSecretaria') }}" class="block py-2 px-3 text-white rounded hover:bg-[#33AD9B] md:hover:bg-transparent md:hover:text-[#33AD9B] md:p-0 dark:text-white md:dark:hover:text-[#33AD9B] dark:hover:bg-[#33AD9B] dark:hover:text-white md:dark:hover:bg-transparent {{ request()->routeIs('dashboardSecretaria') ? 'text-blue-100' : '' }}">Pacientes</a>
          </li>
          <li>
            <a href="{{ route('medicos') }}" class="block py-2 px-3 text-white rounded hover:bg-[#33AD9B] md:hover:bg-transparent md:hover:text-[#33AD9B] md:p-0 dark:text-white md:dark:hover:text-[#33AD9B] dark:hover:bg-[#33AD9B] dark:hover:text-white md:dark:hover:bg-transparent {{ request()->routeIs('medicos') ? 'text-blue-100' : '' }}">Medicos</a>
          </li>
          <li>
            <a href="{{ route('citas') }}" class="block py-2 px-3 text-white rounded hover:bg-[#33AD9B] md:hover:bg-transparent md:hover:text-[#33AD9B] md:p-0 dark:text-white md:dark:hover:text-[#33AD9B] dark:hover:bg-[#33AD9B] dark:hover:text-white md:dark:hover:bg-transparent {{ request()->routeIs('citas') ? 'text-blue-100' : '' }}">Citas</a>
          </li>
          <li>
            <a href="{{ route('servicios') }}" class="block py-2 px-3 text-white rounded hover:bg-[#33AD9B] md:hover:bg-transparent md:hover:text-[#33AD9B] md:p-0 dark:text-white md:dark:hover:text-[#33AD9B] dark:hover:bg-[#33AD9B] dark:hover:text-white md:dark:hover:bg-transparent {{ request()->routeIs('servicios') ? 'text-blue-100' : '' }}">Servicios</a>
          </li>
          <li>
            <a href="{{ route('productos') }}" class="block py-2 px-3 text-white rounded hover:bg-[#33AD9B] md:hover:bg-transparent md:hover:text-[#33AD9B] md:p-0 dark:text-white md:dark:hover:text-[#33AD9B] dark:hover:bg-[#33AD9B] dark:hover:text-white md:dark:hover:bg-transparent {{ request()->routeIs('productos') ? 'text-blue-100' : '' }}">Productos</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  