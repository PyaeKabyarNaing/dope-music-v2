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
        <a href="{{ route('setting.mode') }}"
            class="flex items-center py-2 gap-3 cursor-pointer transition {{ request()->routeIs('setting.mode') ? 'bg-gray-400 dark:bg-gray-700 active' : 'hover:bg-gray-400 dark:hover:bg-gray-700' }}">
            <div>
                <x-icons.dark-icon class="r-0" />
            </div>
            <div>
                <span class="text-sm font-medium l-0">System Mode</span>
            </div>
        </a>

        <a href="{{ route('setting.language') }}"
            class="flex items-center py-2 gap-3 cursor-pointer transition {{ request()->routeIs('setting.language') ? 'bg-gray-400 dark:bg-gray-700 active' : 'hover:bg-gray-400 dark:hover:bg-gray-700' }}">
            <div>
                <x-icons.language-icon class="r-0" />
            </div>
            <div>
                <span class="text-sm font-medium l-0">Languages</span>
            </div>
        </a>
    </div>
</div>

<script>
    document.getElementById('menu-btn').addEventListener('click', function() {
        const sidebar = document.getElementById('sidebar');
        sidebar.classList.toggle('-translate-x-full');
    });
</script>
