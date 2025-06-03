document.addEventListener("DOMContentLoaded", function() {
    var audio = new Audio('/tamagochi/public/muzika.mp3');
    audio.loop = true;
    audio.volume = 0.2;

    var savedTime = localStorage.getItem('audioCurrentTime');
    if (savedTime) {
        audio.currentTime = savedTime;
    }

    function Muzika() {
        audio.play().catch(function(err) {
            console.log("Kluda:", err);
        });
    }

    window.addEventListener('beforeunload', function() {
        localStorage.setItem('audioCurrentTime', audio.currentTime);
    });

    Muzika();

    document.body.addEventListener('click', function() {
        if (audio.paused) {
            Muzika();
        }
    });
});