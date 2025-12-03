<x-app-layout>
    <div class="container mx-auto px-4">
        <h1 class="text-2xl font-bold mb-4">Search Results</h1>

        @if ($songs->count() > 0)
            <p class="mb-4">Found {{ $songs->count() }} results for "{{ request('search') }}"</p>
            <!-- Songs -->
            <h2 class="text-xl font-bold mb-4">Single Songs</h2>
            <ul class="space-y-2 mb-5">
                @foreach ($songs as $song)
                    <a href="{{ route('song.show', $song) }}">
                        <li class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow">
                            <div class="flex items-center">
                                @if ($song->cover_image)
                                    <img src="{{ asset('storage/' . $song->cover_image) }}" alt="{{ $song->cover_name }}"
                                        class="w-12 h-12 rounded-md mr-4 object-cover">
                                @endif
                                <div>
                                    <h3 class="font-semibold">{{ $song->name }}</h3>
                                    @if ($song->artist_name)
                                        <p class="text-gray-600 dark:text-gray-400">{{ $song->artist_name }}</p>
                                    @endif
                                </div>
                            </div>
                        </li>
                    </a>
                @endforeach
            </ul>
            <!-- Albums -->
            <h2 class="text-xl font-bold mb-4">Albums</h2>
            <ul class="space-y-2 mb-5">
                @foreach ($albums as $album)
                    <a href="#">
                        <li class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow">
                            <div class="flex items-center">
                                @if ($album->cover_image)
                                    <img src="{{ asset('storage/' . $album->cover_image) }}"
                                        alt="{{ $album->cover_name }}" class="w-12 h-12 rounded-md mr-4 object-cover">
                                @endif
                                <div>
                                    <h3 class="font-semibold">{{ $album->name }}</h3>
                                    @if ($album->artist_name)
                                        <p class="text-gray-600 dark:text-gray-400">{{ $album->artist_name }}</p>
                                    @endif
                                </div>
                            </div>
                        </li>
                    </a>
                @endforeach
            </ul>
            <!-- Users -->
            <ul class="space-y-2 mb-5">
                <h2 class="text-xl font-bold mb-4">Artists</h2>
                @foreach ($users as $user)
                    <a href="#">
                        <li class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow">
                            <div class="flex items-center">
                                @if ($user->cover_image)
                                    <img src="{{ asset('storage/' . $user->cover_image) }}"
                                        alt="{{ $user->cover_name }}" class="w-12 h-12 rounded-md mr-4 object-cover">
                                @endif
                                <div>
                                    <h3 class="font-semibold">{{ $user->name }}</h3>
                                </div>
                            </div>
                        </li>
                    </a>
                @endforeach
            </ul>
        @else
            <div class="text-center py-8">
                <p class="text-gray-500">No result found for "{{ request('search') }}"</p>
                <a href="{{ route('home') }}" class="text-purple-500 hover:text-purple-600 mt-2 inline-block">
                    Return to home
                </a>
            </div>
        @endif
    </div>
</x-app-layout>
