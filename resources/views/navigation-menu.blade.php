<aside class="fixed top-0 left-0 z-50 w-1/6 h-screen bg-white">
    <div class="h-screen flex flex-col items-center justify-between pt-10 pb-10">
        <div class="flex flex-col items-center justify-center">
            <img src="{{ url('img/image 34.png')}}" alt="" class="w-1/2">
            <h1 class="text-center text-xl font-bold text-gray-800 mt-5">
                BUREAU OF <br> INTERNAL REVENUE
            </h1>
        </div>

        <style>
            .active{
                background-color: #102566;
                color: white;
                position: relative;
            }
            .active::before{
                content: '';
                display: block;
                width: 7%;
                height: 100%;
                position: absolute;
                background-color: #102566;
                bottom: 0;
                left: -40px;
                border-radius: 0 10px 10px 0;
            }
        </style>

        <nav class="h-1/2 flex w-full justify-center flex-col gap-8">
            @if (auth()->user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" 
                    class="text-xl font-bold text-gray-800 hover:text-blue-500 px-4 ml-9 rounded-l-xl {{ Route::is('admin.dashboard') ? 'py-4 active' : '' }}">
                    Dashboard
                </a>
                <a href="{{ route('documents.index') }}" 
                    class="text-xl font-bold text-gray-800 hover:text-blue-500 px-4 ml-9 rounded-l-xl {{ Route::is('documents.index') ? 'py-4 active' : '' }}">
                    Documents
                </a>
                <a href="{{ route('admin.users.index') }}" 
                    class="text-xl font-bold text-gray-800 hover:text-blue-500 px-4 ml-9 rounded-l-xl {{ Route::is('admin.users.index') ? 'py-4 active' : '' }}">
                    Users
                </a>
                <a href="{{ route('admin.profile.edit') }}" 
                    class="text-xl font-bold text-gray-800 hover:text-blue-500 px-4 ml-9 rounded-l-xl {{ Route::is('admin.profile.edit') ? 'py-4 active' : '' }}">
                    Profile
                </a>
            @else
                <a href="{{ route('user.dashboard') }}" 
                    class="text-xl font-bold text-gray-800 hover:text-blue-500 px-4 rounded-l-xl ml-9 {{ Route::is('user.dashboard') ? 'py-4 active' : '' }}">
                    Dashboard
                </a>
                <a href="{{ route('documents.indexOffice') }}" 
                    class="text-xl font-bold text-gray-800 hover:text-blue-500 px-4 rounded-l-xl ml-9 {{ Route::is('documents.indexOffice') ? 'py-4 active' : '' }}">
                    My Documents
                </a>
                <a href="{{ route('user.profile.edit') }}" 
                    class="text-xl font-bold text-gray-800 hover:text-blue-500 px-4 rounded-l-xl ml-9 {{ Route::is('user.profile.edit') ? 'py-4 active' : '' }}">
                    Profile
                </a>
            @endif
        </nav>

        <form method="POST" action="{{ route('logout') }}" x-data class="">
            @csrf

            <x-dropdown-link href="{{ route('logout') }}" class="!text-xl font-bold text-gray-800"
                        @click.prevent="$root.submit();">
                {{ __('Log Out') }}
            </x-dropdown-link>
        </form>
    </div>
</aside>

