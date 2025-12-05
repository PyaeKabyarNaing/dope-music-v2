<x-app-layout>
    <!-- listbar -->
    @include('layouts.listbar')

    <!-- Song Cover Image -->
    <div class="w-full flex justify-center mb-6">
        {{-- @if ($playlist->cover_image)
            <img src="{{ asset('storage/' . $playlist->cover_image) }}" alt="{{ $playlist->name }}"
                class="w-64 h-64 object-cover rounded-xl shadow-lg">
        @else
            <img src="{{ asset('storage/' . $playlist->song->cover_image) }}" alt="{{ $playlist->song->name }}"
                class="w-64 h-64 object-cover rounded-xl shadow-lg">
        @endif --}}
    </div>

    {{-- Song name --}}
    <div class="flex items-center justify-between mb-6">
        @foreach ($songs as $song)
            <p class="text-2xl font-semibold">{{ $song->artist_name }} - </p>
            <p class="text-2xl font-semibold">{{ $song->name }}</p>
        @endforeach
    </div>

    <!-- Uploader Info + Actions -->
    <div class="flex items-center justify-between mb-6">

        <!-- Left: Uploader avatar + name + subscribers -->
        <div class="flex items-center gap-3">
            <!-- Avatar -->
            @if ($song->user->cover_image)
                <img src="{{ asset('storage/' . $song->user->image) }}" class="w-12 h-12 rounded-full object-cover" />
            @else
                <div
                    class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center text-white text-xl font-bold">
                    {{ strtoupper(substr($song->user->name, 0, 1)) }}
                </div>
            @endif

            <!-- Name and subscriptions -->
            <div>
                <p class="text-lg font-semibold">{{ $song->user->name }}</p>
                <p class="text-sm text-gray-500">100 K subscribers</p>
            </div>
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

        <!-- Add Comment -->
        <form id="comment-form" class="mb-4">
            @csrf
            <textarea name="content" rows="2" class="w-full p-2 border rounded-md focus:ring focus:ring-purple-300 text-black"
                placeholder="Add a comment..."></textarea>
            <input id="comment-song-id" type="hidden" name="song_id" value="">

            <x-secondary-button>Comment</x-secondary-button>
        </form>

        <h1 class="text-xl font-bold mb-3">
            Comments
        </h1>

        <!-- Display Comments -->

        <div id="comment-section"></div>
    </div>

    {{-- <script>
        window.albumData = {
            songs: @json($songs),
            album: @json($album),
            albumCover: "{{ $album->cover_image ? asset('storage/' . $album->cover_image) : asset('images/default-cover.jpg') }}"
        };

        document.addEventListener("DOMContentLoaded", () => {
            if (window.albumData.songs && window.albumData.songs.length > 0) {
                // Load all songs into the player
                player.loadSongs(window.albumData.songs);

                // Set cover
                const audioCover = document.getElementById('audio-cover');
                if (audioCover) {
                    audioCover.src = window.albumData.albumCover;
                }
            }
        });
    </script> --}}

    {{-- for comment --}}
    <script>
        function loadComments(songId) {
            fetch(`/song/${songId}/comments`)
                .then(res => res.json())
                .then(comments => {
                    const box = document.getElementById("comment-section");
                    box.innerHTML = ""; // clear old comments

                    if (comments.length === 0) {
                        box.innerHTML = `<p class="text-gray-500">No comments yet.</p>`;
                        return;
                    }

                    comments.forEach(c => {
                        box.innerHTML += `
                    <div class="mb-4 pb-2 border-b border-gray-200">
                        <p class="font-semibold">${c.content}</p>
                        <p class="text-gray-400">by ${c.user.name}</p>
                        <p class="text-xs text-gray-400">${new Date(c.created_at).toLocaleString()}</p>
                    </div>
                `;
                    });
                });
        }

        // When player changes the song
        window.addEventListener("songChanged", (e) => {
            const song = e.detail;

            // Change hidden input to current song ID
            document.getElementById("comment-song-id").value = song.id;

            loadComments(song.id);
        });

        // Load comments for first song on page load
        document.addEventListener("DOMContentLoaded", () => {
            if (window.albumData.songs.length > 0) {
                const firstSongId = window.albumData.songs[0].id;
                document.getElementById("comment-song-id").value = firstSongId;
                loadComments(firstSongId);
            }
        });
    </script>

    <script>
        document.getElementById("comment-form").addEventListener("submit", function(e) {
            e.preventDefault(); // prevent page reload

            const songId = document.getElementById("comment-song-id").value;
            const content = this.querySelector("textarea[name='content']").value;
            const token = this.querySelector("input[name='_token']").value;

            fetch("{{ route('comment.store') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": token
                    },
                    body: JSON.stringify({
                        song_id: songId,
                        content: content
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        // Clear textarea
                        this.querySelector("textarea[name='content']").value = "";

                        // Reload comments for current song
                        loadComments(songId);
                    } else {
                        alert("Error posting comment");
                    }
                })
                .catch(err => console.log(err));
        });
    </script>


</x-app-layout>
