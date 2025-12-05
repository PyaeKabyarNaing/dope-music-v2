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

    <div class="max-w-2xl mx-auto p-6 rounded-2xl shadow-md mt-10">
        <header class="text-center text-2xl font-bold">
            Create A Playlist
        </header>

        <form method="POST" action="{{ route('playlist.store') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
            @csrf

            <!-- Song Name -->
            <div>
                <x-input-label for="name" :value="__('Song Name')" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                    value="{{ old('name') }}" required />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Desc -->
            <div>
                <x-input-label for="description" :value="__('Description')" />
                <x-text-input id="description" name="description" type="text" class="mt-1 block w-full"
                    value="{{ old('description') }}" />
            </div>

            <!-- Submit -->
            <div class="flex items-center gap-4">
                <x-primary-button class="w-full  justify-center">
                    {{ __('Create') }}
                </x-primary-button>

                @if (session('status') === 'playlist-created')
                    <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                        class="text-sm text-gray-600 dark:text-gray-400">
                        {{ __('Created.') }}
                    </p>
                @endif
            </div>
        </form>
    </div>
</x-app-layout>
