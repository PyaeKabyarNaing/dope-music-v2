<x-app-layout>
    {{-- Success message --}}
    @if (session()->has('success'))
        <div id="flash-message" class="w-full bg-green-300 text-black text-center p-4 mb-4 rounded-md">
            {{ session('success') }}
        </div>
    @endif

    <script>
        const flash = document.getElementById('flash-message');

        if (flash) {
            setTimeout(() => {
                flash.style.transition = "opacity 0.5s";
                flash.style.opacity = "0";

                setTimeout(() => flash.remove(), 500);
            }, 3000);
        }
    </script>

    <header>
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">My Playlists</h1>
    </header>

    <div class="flex justify-center">
        <div class="grid sm:grid-cols-1 md:grid-cols-4 lg:grid-cols-5 gap-[30px]">

            @foreach ($playlists as $playlist)
                <a href="{{ route('playlist.detail', $playlist) }}">
                    <div
                        class="min-w-[160px] cursor-pointer hover:bg-[#ffffff26] dark:bg-gray-800/10 bg-gray-500/10 m-2 mx-2">
                        <div
                            class="w-[160px] h-[160px] overflow-hidden bg-red-400 flex justify-center items-center font-bold text-xl rounded-xl">
                        </div>
                        <p class="font-bold mt-2 mb-1 truncate">{{ $playlist->name }}</p>
                    </div>
                </a>
            @endforeach

            <div class="w-[160px] h-[160px] bg-red-500"></div>
            <div class="w-[160px] h-[160px] bg-red-500"></div>
            <div class="w-[160px] h-[160px] bg-red-500"></div>
            <div class="w-[160px] h-[160px] bg-red-500"></div>
            <div class="w-[160px] h-[160px] bg-red-500"></div>
        </div>
    </div>
</x-app-layout>
