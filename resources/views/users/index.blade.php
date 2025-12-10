<x-app-layout>

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

    <!-- Genres -->
    <div class="mb-4">
        <div class="flex overflow-auto scrollbar-hide">
            @foreach ($genres as $genre)
                <a href="{{ route('songs.byGenre', $genre->id) }}"
                    class="m-2 px-3 py-0.5 text-sm border dark:border-white border-black rounded-full flex justify-center items-center whitespace-nowrap">
                    {{ $genre->name }}
                </a>
            @endforeach
        </div>
    </div>

    @auth
        <div class="flex">
            @if (auth()->user()->name)
                <div class="w-[40px] h-[40px] rounded-full overflow-hidden">
                    <img class="rounded-full w-[40px] h-auto object-scale-down"
                        src="{{ asset('storage/' . auth()->user()->image) }}" alt="profile">
                </div>
            @else
                <div
                    class="w-[45px] h-[45px] bg-blue-500 rounded-full flex items-center justify-center text-white text-xl font-bold">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
            @endif

            <h1 class="font-bold text-2xl mt-[1%] ml-2 mb-1">Welcome Back {{ auth()->user()->name }}</h1>
        </div>
    @endauth

    <!-- Album Section -->
    <div class="mb-4">
        <h1 class="my-5 font-bold text-2xl">
            Popular Albums
        </h1>
        <div class="flex overflow-auto">

            <!-- each album -->
            @foreach ($albums as $album)
                <a href="{{ route('album.detail', $album) }}">
                    <div
                        class="min-w-[160px] cursor-pointer hover:bg-[#ffffff26] dark:bg-gray-800/10 bg-gray-500/10 m-2 mx-2">
                        <img class="w-[160px] h-[160px] overflow-hidden bg-red-400 flex justify-center items-center font-bold text-xl rounded-xl object-cover"
                            src="{{ asset('storage/' . $album->cover_image) }}" alt="">
                        <p class="font-bold mt-2 mb-1 truncate max-w-[160px]">{{ $album->name }}
                        </p>
                        <p class="text-sm truncate max-w-[160px]">{{ $album->user->name ?? 'Unknown Artist' }}</p>
                    </div>
                </a>
            @endforeach

        </div>
    </div>

    <!-- Latest Songs Section -->
    <div class="mb-4">
        <h1 class="my-5 font-bold text-2xl">
            Latest Songs
        </h1>
        <div class="flex overflow-auto">

            <!-- each song -->
            @foreach ($songs as $song)
                <a href="{{ route('song.show', $song) }}">
                    <div
                        class="min-w-[160px] cursor-pointer hover:bg-[#ffffff26] dark:bg-gray-800/10 bg-gray-500/10 m-2 mx-2">
                        {{-- <div
                            class="w-[160px] h-[160px] overflow-hidden bg-red-400 flex justify-center items-center font-bold text-xl rounded-xl">
                            Top 50 Hits
                        </div> --}}
                        <img class="w-[160px] h-[160px] overflow-hidden bg-red-400 flex justify-center items-center font-bold text-xl rounded-xl object-cover"
                            src="{{ asset('storage/' . $song->cover_image) }}" alt="">
                        <p class="font-bold mt-2 mb-1 truncate max-w-[160px]">{{ $song->user->name }} -
                            {{ $song->name }}</p>
                        <p class="text-sm truncate max-w-[160px]">{{ $song->user->name ?? 'Unknown Artist' }}</p>
                    </div>
                </a>
            @endforeach

        </div>
    </div>

    <!-- Artist Section -->
    <div class="mb-4">
        <h1 class="my-5 font-bold text-2xl">
            Popular Atrists
        </h1>
        <div class="flex overflow-auto">

            <!-- each artist -->
            @foreach ($artists as $artist)
                <a href="{{ route('user.profile', $artist->id) }}"
                    class="min-w-[150px] cursor-pointer hover:bg-[#ffffff26] m-2 mx-2 flex flex-col justify-center items-center">
                    <div class="w-[150px] h-[150px] rounded-full overflow-hidden">
                        <img class="w-full h-full object-cover" src="{{ asset('storage/' . $artist->image) }}"
                            alt="profile">
                    </div>
                    <div class="font-bold mt-3 mb-1 truncate">{{ $artist->name }}</div>
                </a>
            @endforeach
        </div>
    </div>

    <div class="h-[79px]"></div>

</x-app-layout>
