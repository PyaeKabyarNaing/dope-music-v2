<x-app-layout>

    <!-- Header -->
    <header>
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">{{ $artist->name }}'s Account</h1>
    </header>

    <!-- Profile Header -->
    <div class="p-6 flex items-center justify-between mt-4">

        <!-- LEFT SIDE -->
        <div class="flex items-center space-x-6">
            @if ($artist->image)
                <img src="{{ asset('storage/' . $artist->image) }}" alt="Profile Image"
                    class="w-24 h-24 rounded-full object-cover">
            @else
                <div class="w-20 h-20 bg-blue-400 rounded-full flex items-center justify-center text-3xl font-bold">
                    {{ strtoupper($artist->name[0]) }}
                </div>
            @endif

            <div>
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white">
                    {{ $artist->name }}
                </h2>

                <p class="text-purple-500 dark:text-purple-500">
                    {{ strtoupper($artist->getRoleNames()->first()) }}

                </p>
            </div>
        </div>

        <!-- RIGHT SIDE BUTTON -->
        <a href="{{ route('profile.edit') }}">
            <x-primary-button>
                Edit Account Info
            </x-primary-button>
        </a>
    </div>

    <!-- Tabs -->
    <div class="mt-6 bg-white dark:bg-gray-800 shadow">
        <ul class="flex border-b border-gray-200 dark:border-gray-700" id="tabs">
            <li class="-mb-px mr-1">
                <button class="tab-btn py-2 px-4 font-semibold" data-tab="songs">Songs</button>
            </li>
            <li class="mr-1">
                <button class="tab-btn py-2 px-4 font-semibold" data-tab="albums">Albums</button>
            </li>
            <li class="mr-1">
                <button class="tab-btn py-2 px-4 font-semibold" data-tab="playlists">Playlists</button>
            </li>
        </ul>
    </div>

    <!-- Tab content -->
    <div id="tab-contents" class="p-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

        <!-- Songs Tab -->
        <div class="tab-content" id="songs">
            <h1 class="text-2xl font-bold mb-4">{{ $artist->name }}'s Songs</h1>
            @foreach ($songs as $index => $song)
                <a href="{{ route('song.show', $song) }}">
                    <div class="flex items-center gap-3 p-2 hover:bg-gray-100 dark:hover:bg-gray-800 rounded cursor-pointer song-item"
                        data-index="{{ $index }}">
                        @if ($song->cover_image)
                            <img src="{{ asset('storage/' . $song->cover_image) }}" alt="{{ $song->name }}"
                                class="w-10 h-10 object-cover rounded-md" />
                        @else
                            <img src="https://via.placeholder.com/40" class="w-10 h-10 object-cover rounded-md" />
                        @endif
                        <div class="flex flex-col">
                            <span
                                class="font-semibold text-sm text-gray-900 dark:text-white">{{ $song->name }}</span>
                            <span class="text-sm text-gray-500 dark:text-gray-400">{{ $artist->name }}</span>
                        </div>
                        <a href="{{ route('song.edit', $song->id) }}" class="">
                            <x-icons.edit-icon />
                        </a>
                    </div>
                </a>
            @endforeach
        </div>

        <!-- Albums Tab -->
        <div class="tab-content hidden" id="albums">
            <h1 class="text-2xl font-bold mb-4">{{ $artist->name }}'s Albums</h1>
            @foreach ($albums as $album)
                <a href="{{ route('album.show', $album) }}"
                    class="min-w-[160px] cursor-pointer hover:bg-[#ffffff26] dark:bg-gray-800/10 bg-gray-500/10 m-2 mx-2">
                    <img class="w-[160px] h-[160px] overflow-hidden bg-red-400 flex justify-center items-center font-bold text-xl rounded-xl object-cover"
                        src="{{ asset('storage/' . $album->cover_image) }}" alt="">
                    <p class="font-bold mt-2 mb-1 truncate">{{ $album->name }}</p>
                    <p class="text-sm truncate">{{ $album->user->name ?? 'Unknown Artist' }}</p>
                    <a href="{{ route('album.edit', $album->id) }}">
                        <x-icons.edit-icon />
                    </a>
                </a>
            @endforeach
        </div>

        <!-- Playlists Tab -->
        <div class="tab-content hidden" id="playlists">
            <h1 class="text-2xl font-bold mb-4">{{ $artist->name }}'s Playlists</h1>
            {{-- @foreach ($playlists as $playlist)
                <div>{{ $playlist->name }}</div>
            @endforeach --}}
        </div>
    </div>

    <!-- JS for Tabs with localStorage -->
    <script>
        const tabs = document.querySelectorAll('.tab-btn');
        const contents = document.querySelectorAll('.tab-content');

        // Get last active tab from localStorage or default to 'songs'
        let activeTab = localStorage.getItem('activeTab') || 'songs';

        function showTab(tabName) {
            // Remove active class from all tabs
            tabs.forEach(t => t.classList.remove('active'));
            tabs.forEach(t => {
                if (t.dataset.tab === tabName) t.classList.add('active');
            });

            // Hide all contents
            contents.forEach(c => c.classList.add('hidden'));

            // Show selected content
            document.getElementById(tabName).classList.remove('hidden');

            // Save to localStorage
            localStorage.setItem('activeTab', tabName);
        }

        // Initial load
        showTab(activeTab);

        // Click event
        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                showTab(tab.dataset.tab);
            });
        });
    </script>

    <style>
        .tab-btn.active {
            border-left: 1px solid #ccc;
            border-top: 1px solid #ccc;
            border-right: 1px solid #ccc;
            border-radius: 0.25rem 0.25rem 0 0;
            color: #1d4ed8;
            /* blue */
        }
    </style>

</x-app-layout>
