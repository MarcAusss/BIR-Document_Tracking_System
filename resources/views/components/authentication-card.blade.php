<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
    <div class="flex items-center justify-center w-full">
        <div class="relative">
            <div class="flex h-[415px] my-3 relative">
                <div class="absolute z-10 bg-[#00000054] w-full h-full"></div>
                <img src="{{ url('img/img1.png') }}" alt="Logo" class="">
            </div>
        </div>
         <div class="w-full h-[415px] sm:max-w-md px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-l-lg">
            <div class="flex justify-center items-center mt-3 mb-10">
                <img src="{{ url('img/logo_long.png') }}" alt="Logo" class="">
            </div>
            {{ $slot }}
        </div>
    </div>
    
</div>
