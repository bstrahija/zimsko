import '../css/app.css';
import './bootstrap';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';
import { getSlider } from 'simple-slider';
import PhotoSwipeLightbox from 'photoswipe/lightbox';
import Chart from 'chart.js/auto';

import 'photoswipe/style.css';

function initLightbox() {
    const lightbox = new PhotoSwipeLightbox({
        gallery: '#app',
        children: '.lightbox',
        showHideAnimationType: 'fade',
        pswpModule: () => import('photoswipe'),
    });
    lightbox.init();
}

window.addEventListener('livewire:navigated', (e) => {
    initLightbox();
});

document.addEventListener('DOMContentLoaded', () => {
    initLightbox();
    document.body.removeAttribute('x-cloak');
});

let sliders = document.querySelectorAll('[data-simple-slider]');
console.log('Sliders', sliders.length);

if (sliders.length) {
    getSlider({
        transitionTime: 1,
        delay: 5,
        prop: 'opacity',
        unit: '',
        init: 0,
        show: 1,
        end: 0,
    });
}

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true,
});

window.requestNotificationPermission = function () {
    // Check if the browser supports notifications
    if (!('Notification' in window)) {
        console.log('This browser does not support notifications.');
        return;
    }
    Notification.requestPermission().then((permission) => {
        // Do something with the permission
        // console.log(permission);
    });
};

Notification.requestPermission().then((result) => {
    window.requestNotificationPermission();
});

window.sendNotification = function (message) {
    const img = '/img/logo_ball_white.png';
    const text = message;
    const notification = new Notification('Zimsko Live Score', { body: text, icon: img });
};

const channel = window.Echo.channel('live-score');

channel.listen('\\App\\LiveScore\\Events\\LiveScoreUpdated', (e, obj) => {
    console.log(e.event, e.data);

    if (e.event === 'startGame') {
        window.sendNotification(`Utakmica je započela.\n${e.data.homeTeam} ${e.data.homeScore} : ${e.data.awayScore} ${e.data.awayTeam}`);
    } else if (e.event === 'endGame') {
        window.sendNotification(`Utakmica je zavrsila.\n${e.data.homeTeam} ${e.data.homeScore} : ${e.data.awayScore} ${e.data.awayTeam}`);
    } else if (e.event === 'nextPeriod') {
        window.sendNotification(`Završena je ${e.data.period - 1}. četvrtina.\n${e.data.homeTeam} ${e.data.homeScore} : ${e.data.awayScore} ${e.data.awayTeam}`);
    }
});

let HeroVideo = {
    scriptTag: null,
    player: null,
    videoId: null,
    thumbnailEl: null,
    el: null,
    elContainer: null,
    loadInterval: false,

    render() {
        this.el = document.getElementById('hero-player');
        this.elContainer = document.getElementById('hero-player-container');
        this.thumbnailEl = document.getElementById('play-hero-video');
        this.videoId = this.el ? this.el.getAttribute('data-video-id') : null;

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
                    onReady: this.onPlayerReady,
                },
            });
        }

        this.thumbnailEl.addEventListener('click', () => {
            this.playVideo();
        });
    },

    onPlayerReady(event) {
        // console.log('PLAYER READY', event);
        // event.target.playVideo();
        // this.player.loadVideoById(this.videoId, "large")
    },

    playVideo() {
        this.el.classList.remove('hidden');
        this.elContainer.classList.add('w-full', 'h-full');
        // console.log(this.el);
        this.thumbnailEl.classList.add('hidden');
        // console.log(this.thumbnailEl);
        this.player.playVideo();
    },

    addScriptTag() {
        let head = document.getElementsByTagName('head')[0];
        this.scriptTag = document.createElement('script');
        this.scriptTag.src = 'https://www.youtube.com/iframe_api';
        document.head.appendChild(this.scriptTag);
    },
};

HeroVideo.render();

window.onload = function () {
    const ctx = document.getElementById('globalChartContainer');

    if (ctx && window.globalChartData) {
        const chart = new Chart(ctx, {
            type: 'line',
            data: window.globalChartData,
            options: {
                pointStyle: 'circle',
                elements: {
                    line: {
                        tension: 0.3,
                    },
                },
                scales: {
                    y: {
                        beginAtZero: true,
                    },
                    x: {
                        display: false,
                    },
                },
                plugins: {
                    legend: {
                        display: false,
                    },
                },
            },
        });

        // Apply custom colors
        chart.data.datasets.forEach((dataset, index) => {
            dataset.borderColor = index === 0 ? 'rgb(1, 114, 173)' : '#FF6B00';
            dataset.backgroundColor = index === 0 ? 'rgba(77, 255, 191, 0.2)' : 'rgba(236, 75, 75, 0.2)';
        });
        chart.update();
    }
};
