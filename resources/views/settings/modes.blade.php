<x-app-layout>
    <div class="h-[100px] border dark:border-gray-700 border-purple-950 flex justify-between p-4 rounded-md m-4">
        <div class="flex flex-col">
            <p class="text-xl font-bold mb-2">System mode</p>
            <p class="dark:text-gray-300 text-gray-700">Switch between light and dark mode</p>
        </div>
        <button id="themeToggle" class="relative w-[80px] h-[30px]">
            <x-light-toggle />
            <x-dark-toggle />
        </button>
    </div>
</x-app-layout>
