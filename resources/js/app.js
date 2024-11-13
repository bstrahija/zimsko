import '../css/app.css'
import './bootstrap';

let HeroVideo = {
    scriptTag   : null,
    player      : null,
    videoId     : null,
    thumbnailEl : null,
    el          : null,
    elContainer          : null,
    loadInterval: false,

    render() {
        this.el          = document.getElementById('hero-player');
        this.elContainer = document.getElementById('hero-player-container');
        this.thumbnailEl = document.getElementById('play-hero-video');
        this.videoId     = this.el ? this.el.getAttribute('data-video-id') : null;

        // Run everything only if element exists
        if (this.el && this.videoId) {
            this.addScriptTag();
            this.loadPlayer();
        }
    },

    loadPlayer() {
        this.loadInterval = setInterval(() => {
            if (window.YT && window.YT.loaded) {
                clearInterval(this.loadInterval);
                this.createPlayer();
            }
        }, 20);
    },

    createPlayer() {
        if (this.videoId) {
            // Create player instance
            this.player = new YT.Player('hero-player-container', {
                height: '100%',
                width: '100%',
                videoId: this.videoId,
                listType: 'playlist',
                autoplay: false,
                rel: false,
                events: {
                    'onReady': this.onPlayerReady,
                }
            });
        }

        this.thumbnailEl.addEventListener('click', () => {
            this.playVideo();
        });
    },

    onPlayerReady(event) {
        console.log("PLAYER READY", event);
        // event.target.playVideo();
        // this.player.loadVideoById(this.videoId, "large")
    },

    playVideo() {
        this.el.classList.remove('hidden');
        this.elContainer.classList.add('w-full', 'h-full');
        console.log(this.el);
        this.thumbnailEl.classList.add('hidden');
        console.log(this.thumbnailEl);
        this.player.playVideo();
    },

    addScriptTag() {
        let head = document.getElementsByTagName("head")[0]
        this.scriptTag = document.createElement('script');
        this.scriptTag.src = "https://www.youtube.com/iframe_api";
        document.head.appendChild(this.scriptTag);
    }
}

HeroVideo.render();
