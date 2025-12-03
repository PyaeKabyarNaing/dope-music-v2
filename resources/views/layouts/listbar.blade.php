<!-- whole listbar -->
<div
    class="fixed dark:bg-black bg-white inset-y-0 right-0 w-[30%] h-full pr-2 flex-col gap-2 hidden sm:block transform transition-transform duration-300 ease-in-out z-10 pl-1 border-l-4 border-gray-500 overflow-y-auto">

    <div class="h-[70px]"></div>

    <!-- Loop through songs -->
    @foreach ($songs as $index => $song)
        <div class="flex items-center gap-3 p-2 hover:bg-gray-100 dark:hover:bg-gray-800 rounded cursor-pointer song-item"
            data-index="{{ $index }}">

            <!-- Song Cover -->
            @if ($song->cover_image)
                <img src="{{ asset('storage/' . $song->cover_image) }}" alt="{{ $song->name }}"
                    class="w-10 h-10 object-cover rounded-md" />
            @else
                <img src="{{ asset('storage/' . $album->cover_image) }}" alt="{{ $song->name }}"
                    class="w-10 h-10 object-cover rounded-md" />
            @endif

            <!-- Song Info -->
            <div class="flex flex-col">
                <!-- Song Name -->
                <span class="font-semibold text-sm text-gray-900 dark:text-white">{{ $song->name }}</span>

                <!-- Artist Name -->
                <span class="text-sm text-gray-500 dark:text-gray-400">{{ $song->artist_name }}</span>
            </div>

        </div>
    @endforeach
</div>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const songItems = document.querySelectorAll(".song-item");

        songItems.forEach(item => {
            item.addEventListener("click", () => {
                const index = parseInt(item.dataset.index);
                player.playSongAt(index);
            });
        });
    });
</script>
