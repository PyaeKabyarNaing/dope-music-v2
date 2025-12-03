<!-- resources/views/layouts/sidebar.blade.php -->
<!-- whole sidebar -->
<div id="sidebar"
    class="fixed dark:bg-black bg-white inset-y-0 left-0 w-[243px] sm:w-[243px] md:w-[243px] 
           lg:w-[243px] h-full pr-2 flex flex-col
           -translate-x-full lg:translate-x-0
           transform transition-transform duration-300 ease-in-out z-10 pl-7 border-r-4 border-gray-500">


    <div class="h-[10%]"></div>

    <div class="h-[20%] flex flex-col">

        <!-- Sidebar Links -->
        <a href="{{ route('home') }}" class="flex items-center py-2 gap-3 cursor-pointer hover:bg-gray-700 transition">
            <div>
                <x-icons.home-icon class="r-0" />
            </div>
            <div>
                <span class="text-sm font-medium l-0">Home</span>
            </div>
        </a>

        <a href="#" class="flex items-center py-2 gap-3 cursor-pointer hover:bg-gray-700 transition">
            <div>
                <x-icons.playlist-icon class="r-0" />
            </div>
            <div>
                <span class="text-sm font-medium l-0">Playlists</span>
            </div>
        </a>

        <a href="#" class="flex items-center py-2 gap-3 cursor-pointer hover:bg-gray-700 transition">
            <div>
                <x-icons.history-icon class="r-0" />
            </div>
            <div>
                <span class="text-sm font-medium l-0">History</span>
            </div>
        </a>

        @role('artist')
            <a href="{{ route('album.create') }}"
                class="flex items-center py-2 gap-3 cursor-pointer hover:bg-gray-700 transition">
                <div>
                    <x-icons.album-icon class="r-0" />
                </div>
                <div>
                    <span class="text-sm font-medium l-0">Create New ALbum</span>
                </div>
            </a>

            <a href="{{ route('song.create') }}"
                class="flex items-center py-2 gap-3 cursor-pointer hover:bg-gray-700 transition">
                <div>
                    <x-icons.music-icon class="r-0" />
                </div>
                <div>
                    <span class="text-sm font-medium l-0">Add New Song</span>
                </div>
            </a>
        @endrole

        <form method="POST" action="{{ route('logout') }}" class="hover:bg-red-300">
            @csrf
            <button type="submit" class="flex items-center py-2 gap-3 cursor-pointer text-red-500">
                <div>
                    <x-icons.logout-icon class="r-0" />
                </div>
                <div>
                    <span class="text-base font-bold l-0">Logout</span>
                </div>
            </button>
        </form>
    </div>
</div>

<script>
    document.getElementById('menu-btn').addEventListener('click', function() {
        const sidebar = document.getElementById('sidebar');
        sidebar.classList.toggle('-translate-x-full');
    });
</script>
