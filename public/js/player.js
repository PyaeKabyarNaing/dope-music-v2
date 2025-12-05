const audioElement = document.getElementById("audio-player");
const audioCover = document.getElementById("audio-cover");
const audioTitle = document.getElementById("audio-title");
const audioArtist = document.getElementById("audio-artist");
const displayTitle = document.getElementById("display-title");
const displayArtist = document.getElementById("display-artist");

const player = {
    audio: audioElement,
    playlist: [],
    currentIndex: 0,

    loadSongs(songs) {
        this.playlist = songs;
        this.currentIndex = 0;
        if (songs.length > 0) {
            this.playCurrent();
        }
    },

    playCurrent() {
        const song = this.playlist[this.currentIndex];
        if (!song) return;

        // Update UI with proper cover image fallback
        if (song.cover_image) {
            audioCover.src = `/storage/${song.cover_image}`;
        } else if(window.albumData && window.albumData.album && window.albumData.album.cover_image) {
            audioCover.src = `/storage/${window.albumData.album.cover_image}`;
        }
        else {
            audioCover.src = `/images/default-cover.jpg`;
        }
        
        audioTitle.textContent = song.name;
        audioArtist.textContent = song.artist_name;
        displayTitle.textContent = song.name;
        displayArtist.textContent = song.artist_name;

        // Play audio - make sure file_url exists in your songs
        if (song.audio_file) {
            this.audio.src = song.audio_file.startsWith('http') ? song.audio_file : `/storage/${song.audio_file}`;
            this.audio.play().catch(e => {
                console.log("Auto-play prevented:", e);
                // User interaction might be required for auto-play
            });
        }

        // Dispatch event for other components to listen to
        window.dispatchEvent(new CustomEvent("songChanged", { detail: song }));
    },

    playSongAt(index) {
        if (index >= 0 && index < this.playlist.length) {
            this.currentIndex = index;
            this.playCurrent();
        }
    },

    next() {
        if (this.currentIndex < this.playlist.length - 1) {
            this.currentIndex++;
            this.playCurrent();
        }
    },

    previous() {
        if (this.currentIndex > 0) {
            this.currentIndex--;
            this.playCurrent();
        }
    }
};

// Auto play next song when current ends
player.audio.addEventListener("ended", () => {
    player.next();
});

// Make player globally available
window.player = player;

// Above code works for album songs

// const audioElement = document.getElementById("audio-player");
// const audioCover = document.getElementById("audio-cover");
// const audioTitle = document.getElementById("audio-title");
// const audioArtist = document.getElementById("audio-artist");

// const player = {
//     audio: audioElement,
//     playlist: [],
//     currentIndex: 0,
//     currentContext: null, // 'single', 'album', 'search', 'popular'

//     loadSongs(songs, context = 'single') {
//         this.playlist = songs;
//         this.currentIndex = 0;
//         this.currentContext = context;
        
//         if (songs.length > 0) {
//             this.playCurrent();
//         }
//     },

//     playCurrent() {
//         const song = this.playlist[this.currentIndex];
//         if (!song) return;

//         // Update UI with proper cover image fallback
//         if (song.cover_image) {
//             audioCover.src = `/storage/${song.cover_image}`;
//         } else if(this.currentContext === 'album' && window.albumData && window.albumData.albumCover) {
//             audioCover.src = window.albumData.albumCover;
//         } else {
//             audioCover.src = `/images/default-cover.jpg`;
//         }
        
//         audioTitle.textContent = song.name;
//         audioArtist.textContent = song.artist_name;

//         // Play audio
//         if (song.audio_file) {
//             this.audio.src = song.audio_file.startsWith('http') ? song.audio_file : `/storage/${song.audio_file}`;
//             this.audio.play().catch(e => {
//                 console.log("Auto-play prevented:", e);
//             });
//         }

//         // Dispatch event for other components to listen to
//         window.dispatchEvent(new CustomEvent("songChanged", { 
//             detail: { 
//                 song: song,
//                 context: this.currentContext,
//                 index: this.currentIndex,
//                 total: this.playlist.length
//             } 
//         }));
//     },

//     playSongAt(index) {
//         if (index >= 0 && index < this.playlist.length) {
//             this.currentIndex = index;
//             this.playCurrent();
//         }
//     },

//     next() {
//         // In single song mode, don't auto-advance
//         if (this.currentContext === 'single' && this.playlist.length === 1) {
//             this.audio.currentTime = 0;
//             this.audio.play();
//             return;
//         }
        
//         if (this.currentIndex < this.playlist.length - 1) {
//             this.currentIndex++;
//             this.playCurrent();
//         }
//     },

//     previous() {
//         if (this.currentIndex > 0) {
//             this.currentIndex--;
//             this.playCurrent();
//         } else {
//             // If at first song, restart it
//             this.audio.currentTime = 0;
//             this.audio.play();
//         }
//     },

//     // Helper to play single song
//     playSingle(song) {
//         this.loadSongs([song], 'single');
//     }
// };

// // Auto play next song when current ends (only for playlists)
// player.audio.addEventListener("ended", () => {
//     if (player.currentContext !== 'single' || player.playlist.length > 1) {
//         player.next();
//     }
// });

// // Make player globally available
// window.player = player;

// // Global function for individual song playback from anywhere
// window.playSingleSong = function(song) {
//     if (window.player) {
//         window.player.playSingle(song);
//     }
// };