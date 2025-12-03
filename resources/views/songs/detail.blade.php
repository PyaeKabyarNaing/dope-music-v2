<x-app-layout>

    <!-- Song Cover Image -->
    <div class="w-full flex justify-center mb-6">
        @if ($song->cover_image)
            <img src="{{ asset('storage/' . $song->cover_image) }}" alt="{{ $song->name }}"
                class="w-[500px] h-[500px] object-cover rounded-xl shadow-lg">
        @else
            <div class="w-[500px] h-[500px] object-cover rounded-xl shadow-lg bg-slate-400"></div>
        @endif
    </div>
    {{-- Song name --}}
    <div class="flex items-center justify-between mb-6">
        <p class="text-2xl font-semibold">{{ $song->artist_name }} - {{ $song->name }}</p>
    </div>

    <!-- Uploader Info + Actions -->
    <div class="flex items-center justify-between mb-6">

        <!-- Left: Uploader avatar + name + subscribers -->
        <div class="flex items-center gap-3">
            <!-- Avatar -->
            @if ($user->image)
                <img src="{{ asset('storage/' . $user->image) }}" class="w-12 h-12 rounded-full object-cover" />
            @else
                <div
                    class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center text-white text-xl font-bold">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
            @endif

            <!-- Name and subscriptions -->
            <div>
                <p class="text-lg font-semibold">{{ $user->name }}</p>
                <p class="text-sm text-gray-500">100 K subscribers</p>
            </div>

            <a href="#" class="hover:text-blue-500 transition">
                <x-primary-button>
                    Subscribe
                </x-primary-button>
            </a>
        </div>
        <!-- Right: Buttons - React, Share, Download -->
        <div class="flex items-center gap-4 text-xl">

            <!-- React -->
            <button class="hover:text-blue-500 transition">
                <x-icons.heart-icon />
            </button>

            <!-- Share -->
            <button class="hover:text-blue-500 transition">
                <x-icons.share-icon />
            </button>

            <!-- Download -->
            {{-- <a href="{{ route('song.download', $song->id) }}" class="hover:text-blue-500 transition"> --}}
            <a href="#" class="hover:text-blue-500 transition">
                <x-icons.download-icon />
            </a>
        </div>
    </div>

    <!-- Divider -->
    <hr class="my-4 border-gray-300">

    <!-- Comment Section -->
    <div class="h-64 overflow-y-auto pr-2">

        {{-- @foreach ($album->songs as $song) --}}
        <!-- Add Comment -->
        <form action="{{ route('comment.store') }}" method="POST" class="mb-4">
            @csrf
            <textarea name="content" rows="2" class="w-full p-2 border rounded-md focus:ring focus:ring-purple-300 text-black"
                placeholder="Add a comment..."></textarea>
            <input type="hidden" name="song_id" value="{{ $song->id }}">

            <x-secondary-button>Comment</x-secondary-button>
        </form>

        <!-- Display Comments -->
        <div class="mb-4 pb-2 border-b border-gray-200">
            @foreach ($song->comments as $comment)
                <p class="font-semibold">{{ $comment->user->name }}</p>
                <p class="text-gray-700">{{ $comment->content }}</p>
                <p class="text-xs text-gray-400">{{ $comment->created_at->diffForHumans() }}</p>
            @endforeach
        </div>

    </div>

    <script>
        // Wait for everything to be ready
        document.addEventListener('DOMContentLoaded', function() {
            // Small delay to ensure player.js is loaded
            setTimeout(function() {
                if (window.player && @json($song)) {
                    const songData = @json($song);

                    // Load the single song as an array
                    window.player.loadSongs([songData]);

                    // Optional: Force update UI immediately
                    const audioCover = document.getElementById('audio-cover');
                    const audioTitle = document.getElementById('audio-title');
                    const audioArtist = document.getElementById('audio-artist');

                    if (audioCover && songData.cover_image) {
                        audioCover.src = `/storage/${songData.cover_image}`;
                    }
                    if (audioTitle) audioTitle.textContent = songData.name;
                    if (audioArtist) audioArtist.textContent = songData.artist_name;
                }
            }, 100);
        });
    </script>

</x-app-layout>
