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
            Edit Song
        </header>

        <form method="post" action="{{ route('song.update', $song->id) }}" enctype="multipart/form-data"
            class="mt-6 space-y-6">
            @csrf
            @method('PUT')

            <!-- Song Name -->
            <div>
                <x-input-label for="name" :value="__('Song Name')" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                    value="{{ old('name', $song->name) }}" required />
            </div>

            <!-- Artist Name -->
            <div>
                <x-input-label for="artist_name" :value="__('Artist Name')" />
                <x-text-input id="artist_name" name="artist_name" type="text" class="mt-1 block w-full"
                    value="{{ old('artist_name', $song->artist_name) }}" required />
            </div>

            <!-- Ft Artist Name -->
            <div>
                <x-input-label for="ft_artist_name" :value="__('Featuring Artist Name')" />
                <x-text-input id="ft_artist_name" name="ft_artist_name" type="text"
                    class="mt-1 block w-full text-black" value="{{ old('ft_artist_name', $song->ft_artist_name) }}" />
            </div>

            <!-- Genre -->
            <div>
                <x-input-label for="genre_id" :value="__('Genre')" />
                <select id="genre_id" name="genre_id" class="mt-1 block w-full rounded-md text-black">
                    @foreach ($genres as $genre)
                        <option value="{{ $genre->id }}"
                            {{ old('genre_id', $song->genre_id) == $genre->id ? 'selected' : '' }}>
                            {{ $genre->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Old Cover Preview -->
            @if ($song->cover_image)
                <div>
                    <p class="font-semibold">Current Cover Image:</p>
                    <img src="{{ asset('storage/' . $song->cover_image) }}"
                        class="w-32 h-32 object-cover rounded-md border mt-2">
                </div>
            @endif

            <!-- New Cover Upload -->
            <div>
                <x-input-label for="cover_image" :value="__('Change Cover Image')" />
                <input id="cover_image" name="cover_image" type="file" accept="image/*" class="mt-1 block w-full" />
            </div>

            <!-- Audio File -->
            <div>
                <x-input-label for="audio_file" :value="__('Replace Audio File (Optional)')" />
                <input id="audio_file" name="audio_file" type="file" accept="audio/*" class="mt-1 block w-full" />
            </div>

            <!-- Album -->
            <div>
                <x-input-label for="album_id" :value="__('Album (Optional)')" />
                <select id="album_id" name="album_id" class="mt-1 block w-full rounded-md text-black">
                    <option value="">No album</option>
                    @foreach ($albums as $album)
                        <option value="{{ $album->id }}"
                            {{ old('album_id', $song->album_id) == $album->id ? 'selected' : '' }}>
                            {{ $album->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Description -->
            <div>
                <x-input-label for="description" :value="__('Description')" />
                <x-text-input id="description" name="description" type="text" class="mt-1 block w-full"
                    value="{{ old('description', $song->description) }}" required />
            </div>

            <!-- Submit -->
            <div class="flex items-center gap-4">
                <x-primary-button class="w-full justify-center">
                    {{ __('Update Song') }}
                </x-primary-button>
            </div>

        </form>
    </div>

</x-app-layout>
