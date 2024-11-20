document.addEventListener('DOMContentLoaded', () => {
    const audioPlayer = document.getElementById('audio-player');
    const currentSong = document.getElementById('current-song');
    const lastSong = document.getElementById('last-song');
    const shuffleCheckbox = document.getElementById('shuffle');
    const muteCheckbox = document.getElementById('mute');
    const playButtons = document.querySelectorAll('.play-btn');

    let currentSongIndex = null;

    playButtons.forEach((button, index) => {
        button.addEventListener('click', () => {
            const audioSrc = button.getAttribute('data-audio');
            audioPlayer.src = audioSrc;
            audioPlayer.play();

            const previousSong = currentSong.textContent.replace('Reproduint: ', '').trim();
            if (previousSong && previousSong !== "Selecciona una cançó") {
                document.cookie = `previous_song=${previousSong};path=/`;
                lastSong.textContent = previousSong;
            } else {
                lastSong.textContent = 'Cap cançó anterior';
            }

            const songName = button.closest('li').querySelector('strong').textContent;
            currentSong.textContent = `Reproduint: ${songName}`;
            document.cookie = `last_played=${songName};path=/`;
            currentSongIndex = index;
        });
    });

    const playNextSong = () => {
        if (shuffleCheckbox.checked) {
            const randomIndex = Math.floor(Math.random() * playButtons.length);
            if (randomIndex !== currentSongIndex) {
                playButtons[randomIndex].click();
            } else {
                playNextSong(); 
            }
        } else {
            const nextIndex = (currentSongIndex + 1) % playButtons.length;
            playButtons[nextIndex].click();
        }
    };

    audioPlayer.addEventListener('ended', () => {
        playNextSong();
    });

    muteCheckbox.addEventListener('change', () => {
        audioPlayer.muted = muteCheckbox.checked;
    });

    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', () => {
            const songId = button.getAttribute('data-id');

            document.cookie = `delete_song_${songId}=1;path=/`;
            button.closest('li').remove();
        });
    });
});
