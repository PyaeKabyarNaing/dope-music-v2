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
            Upload Song
        </header>

        <form method="POST" action="{{ route('song.store') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
            @csrf

            <!-- Song Name -->
            <div>
                <x-input-label for="name" :value="__('Song Name')" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                    value="{{ old('name') }}" required />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Artist Name -->
            <div>
                <x-input-label for="artist_name" :value="__('Artist Name')" />
                <x-text-input id="artist_name" name="artist_name" type="text" class="mt-1 block w-full"
                    value="{{ old('artist_name') }}" required />
                <x-input-error :messages="$errors->get('artist_name')" class="mt-2" />
            </div>

            <!-- Ft Artist Name -->
            <div>
                <x-input-label for="ft_artist_name" :value="__('Featuring Artist Name')" />
                <x-text-input id="ft_artist_name" name="ft_artist_name" type="text" class="mt-1 block w-full"
                    value="{{ old('ft_artist_name') }}" />
            </div>

            <!-- Genre -->
            <div>
                <x-input-label for="genre_id" :value="__('Genre')" />
                <select id="genre_id" name="genre_id"
                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                    <option value="" disabled selected>Select a genre</option>
                    @foreach ($genres as $genre)
                        <option value="{{ $genre->id }}" {{ old('genre_id') == $genre->id ? 'selected' : '' }}>
                            {{ $genre->name }}
                        </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('genre_id')" class="mt-2" />
            </div>

            <!-- Cover Image -->
            <div>
                <x-input-label for="cover_image" :value="__('Cover Image (Optional)')" />
                <input id="cover_image" name="cover_image" type="file" accept="image/*"
                    class="mt-1 block w-full text-sm text-gray-900 dark:text-gray-100
                       file:mr-4 file:py-2 file:px-4
                       file:rounded-md file:border-0
                       file:text-sm file:font-semibold
                       file:bg-gray-100 file:text-gray-700
                       hover:file:bg-gray-200
                       dark:file:bg-gray-700 dark:file:text-gray-300" />
                <x-input-error :messages="$errors->get('cover_image')" class="mt-2" />
            </div>

            <!-- Audio File -->
            <div>
                <x-input-label for="audio_file" :value="__('Audio File (MP3, WAV)')" />
                <input id="audio_file" name="audio_file" type="file" accept="audio/*" required
                    class="mt-1 block w-full text-sm text-gray-900 dark:text-gray-100
                       file:mr-4 file:py-2 file:px-4
                       file:rounded-md file:border-0
                       file:text-sm file:font-semibold
                       file:bg-gray-100 file:text-gray-700
                       hover:file:bg-gray-200
                       dark:file:bg-gray-700 dark:file:text-gray-300" />
                <x-input-error :messages="$errors->get('audio_file')" class="mt-2" />
            </div>

            <!-- Album -->
            <div>
                <x-input-label for="album_ids" :value="__('Albums (Optional)')" />
                <select id="album_ids" name="album_ids[]" multiple
                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                    <option value="">No album</option>

                    @foreach ($albums as $album)
                        <option value="{{ $album->id }}"
                            {{ (isset($song) && $song->albums->contains($album->id)) || collect(old('album_ids'))->contains($album->id) ? 'selected' : '' }}>
                            {{ $album->name }}
                        </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('album_ids')" class="mt-2" />
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
                    {{ __('Upload') }}
                </x-primary-button>

                @if (session('status') === 'song-uploaded')
                    <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                        class="text-sm text-gray-600 dark:text-gray-400">
                        {{ __('Uploaded.') }}
                    </p>
                @endif
            </div>
        </form>
    </div>
</x-app-layout>
