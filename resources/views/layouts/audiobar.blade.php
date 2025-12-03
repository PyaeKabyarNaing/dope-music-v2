<div
    class="fixed bottom-0 inset-x-0 w-full h-[70px] dark:bg-black bg-white flex justify-between items-center px-4 z-50 border-t border-gray-300 dark:border-gray-700">
    <!-- Left: Song Info -->
    <div class="flex items-center justify-center gap-4 min-w-0 flex-1">
        <img id="audio-cover" class="w-12 h-12 object-cover rounded" src="{{ asset('images/default-cover.jpg') }}"
            alt="Song cover">
        <div class="min-w-0 flex-1">
            <p id="audio-title" class="font-bold text-sm truncate">No song selected</p>
            <p id="audio-artist" class="text-sm text-gray-600 dark:text-gray-400 truncate">Select a song to play</p>
        </div>
    </div>

    <!-- Center: Audio Controls -->
    <div class="flex flex-col items-center gap-2 mx-4 flex-1 max-w-2xl">
        <!-- Control Buttons -->
        <div class="flex items-center gap-4">

            <!-- Previous -->
            <button class="text-gray-600 dark:text-gray-400 hover:text-purple-600 transition" id="prev-btn">
                <x-icons.previous-icon class="w-5 h-5" />
            </button>

            <!-- Play/Pause -->
            <button class="bg-purple-600 text-white p-2 rounded-full hover:bg-purple-700 transition"
                id="play-pause-btn">
                <x-icons.play-icon class="w-5 h-5" id="play-icon" />
                <x-icons.pause-icon class="w-5 h-5" id="pause-icon" />
            </button>

            <!-- Next -->
            <button class="text-gray-600 dark:text-gray-400 hover:text-purple-600 transition" id="next-btn">
                <x-icons.next-icon class="w-5 h-5" />
        </div>
        <audio id="audio-player"></audio>

        <!-- Progress Bar -->
        <div class="flex items-center gap-3 w-full max-w-md">
            <span class="text-xs text-gray-500" id="current-time">0:00</span>
            <div class="flex-1 relative group cursor-pointer" id="progress-container">
                <div class="w-full h-1 bg-gray-300 dark:bg-gray-600 rounded-full">
                    <div class="h-1 bg-purple-600 rounded-full" id="progress-bar" style="width: 0%"></div>
                </div>
                <div class="absolute top-1/2 -translate-y-1/2 w-3 h-3 bg-purple-600 rounded-full opacity-0 group-hover:opacity-100 transition-opacity"
                    id="progress-handle" style="left: 0%"></div>
            </div>
            <span class="text-xs text-gray-500" id="duration">0:00</span>
        </div>
    </div>

    <!-- Right: Volume & Additional Controls -->
    <div class="items-center gap-4 flex-2 justify-end">

        <!-- Volume -->
        <div class="flex items-center gap-1">
            <button class="text-gray-600 dark:text-gray-400 hover:text-purple-600 transition" id="volume-btn">
                <x-icons.volumn-high-icon id="volume-high-icon" />
                <x-icons.volumn-low-icon id="volume-low-icon" />
                <x-icons.volumn-mute-icon id="volume-mute-icon" />
            </button>
            <div class="w-[90px] relative group cursor-pointer" id="volume-container">
                <div class="w-full h-1 bg-gray-300 dark:bg-gray-600 rounded-full">
                    <div class="h-1 bg-purple-600 rounded-full" id="volume-bar" style="width: 70%"></div>
                </div>
                <div class="absolute top-1/2 -translate-y-1/2 w-3 h-3 bg-purple-600 rounded-full opacity-0 group-hover:opacity-100 transition-opacity"
                    id="volume-handle" style="left: 70%"></div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get elements
        const audioElement = document.getElementById('audio-player');
        const playPauseBtn = document.getElementById('play-pause-btn');
        const playIcon = document.getElementById('play-icon');
        const pauseIcon = document.getElementById('pause-icon');
        const prevBtn = document.getElementById('prev-btn');
        const nextBtn = document.getElementById('next-btn');
        const progressBar = document.getElementById('progress-bar');
        const progressHandle = document.getElementById('progress-handle');
        const progressContainer = document.getElementById('progress-container');
        const currentTimeEl = document.getElementById('current-time');
        const durationEl = document.getElementById('duration');
        const volumeBar = document.getElementById('volume-bar');
        const volumeHandle = document.getElementById('volume-handle');
        const volumeContainer = document.getElementById('volume-container');
        const volumeBtn = document.getElementById('volume-btn');
        const volumeHighIcon = document.getElementById('volume-high-icon');
        const volumeLowIcon = document.getElementById('volume-low-icon');
        const volumeMuteIcon = document.getElementById('volume-mute-icon');

        // Initialize button states
        function initializeButtonStates() {
            // Ensure only play icon is visible initially
            playIcon.classList.remove('hidden');
            pauseIcon.classList.add('hidden');

            // Set initial volume icon (70% volume = high volume icon)
            volumeHighIcon.classList.remove('hidden');
            volumeLowIcon.classList.add('hidden');
            volumeMuteIcon.classList.add('hidden');
        }

        // Play/Pause functionality
        playPauseBtn.addEventListener('click', function() {
            if (window.player && window.player.audio) {
                if (window.player.audio.paused) {
                    window.player.audio.play();
                    playIcon.classList.add('hidden');
                    pauseIcon.classList.remove('hidden');
                } else {
                    window.player.audio.pause();
                    playIcon.classList.remove('hidden');
                    pauseIcon.classList.add('hidden');
                }
            }
        });

        // Previous/Next functionality
        prevBtn.addEventListener('click', function() {
            if (window.player && window.player.previous) {
                window.player.previous();
            }
        });

        nextBtn.addEventListener('click', function() {
            if (window.player && window.player.next) {
                window.player.next();
            }
        });

        // Progress bar functionality
        function updateProgress() {
            if (window.player && window.player.audio) {
                const {
                    currentTime,
                    duration
                } = window.player.audio;
                const progressPercent = (currentTime / duration) * 100 || 0;

                progressBar.style.width = `${progressPercent}%`;
                progressHandle.style.left = `${progressPercent}%`;

                currentTimeEl.textContent = formatTime(currentTime);
                durationEl.textContent = formatTime(duration);
            }
        }

        function setProgress(e) {
            if (window.player && window.player.audio) {
                const width = this.clientWidth;
                const clickX = e.offsetX;
                const duration = window.player.audio.duration;

                window.player.audio.currentTime = (clickX / width) * duration;
            }
        }

        // Volume functionality
        function setVolume(e) {
            if (window.player && window.player.audio) {
                const width = this.clientWidth;
                const clickX = e.offsetX;
                const volume = Math.max(0, Math.min(1, clickX / width));

                window.player.audio.volume = volume;
                volumeBar.style.width = `${volume * 100}%`;
                volumeHandle.style.left = `${volume * 100}%`;

                updateVolumeIcon(volume);
            }
        }

        function updateVolumeIcon(volume) {
            volumeHighIcon.classList.add('hidden');
            volumeLowIcon.classList.add('hidden');
            volumeMuteIcon.classList.add('hidden');

            if (volume === 0) {
                volumeMuteIcon.classList.remove('hidden');
            } else if (volume < 0.5) {
                volumeLowIcon.classList.remove('hidden');
            } else {
                volumeHighIcon.classList.remove('hidden');
            }
        }

        volumeBtn.addEventListener('click', function() {
            if (window.player && window.player.audio) {
                if (window.player.audio.volume > 0) {
                    window.player.audio.volume = 0;
                    volumeBar.style.width = '0%';
                    volumeHandle.style.left = '0%';
                    updateVolumeIcon(0);
                } else {
                    window.player.audio.volume = 0.7;
                    volumeBar.style.width = '70%';
                    volumeHandle.style.left = '70%';
                    updateVolumeIcon(0.7);
                }
            }
        });

        // Utility function to format time
        function formatTime(seconds) {
            if (isNaN(seconds)) return '0:00';

            const minutes = Math.floor(seconds / 60);
            const secs = Math.floor(seconds % 60);
            return `${minutes}:${secs.toString().padStart(2, '0')}`;
        }

        // Event listeners
        if (window.player && window.player.audio) {
            window.player.audio.addEventListener('timeupdate', updateProgress);
            window.player.audio.addEventListener('play', function() {
                playIcon.classList.add('hidden');
                pauseIcon.classList.remove('hidden');
            });
            window.player.audio.addEventListener('pause', function() {
                playIcon.classList.remove('hidden');
                pauseIcon.classList.add('hidden');
            });
            window.player.audio.addEventListener('ended', function() {
                playIcon.classList.remove('hidden');
                pauseIcon.classList.add('hidden');
            });
        }

        progressContainer.addEventListener('click', setProgress);
        volumeContainer.addEventListener('click', setVolume);

        // Initialize button states
        initializeButtonStates();

        // Initialize volume
        if (window.player && window.player.audio) {
            window.player.audio.volume = 0.7;
            updateVolumeIcon(0.7);
        }
    });
</script>
