import '../css/live.css';
import './bootstrap';
import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import Toaster from '@meforma/vue-toaster';
import { vfmPlugin } from 'vue-final-modal';

createInertiaApp({
    resolve: (name) => {
        const pages = import.meta.glob('./Pages/**/*.vue', { eager: true });
        return pages[`./Pages/${name}.vue`];
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(
                vfmPlugin({
                    key: '$vfm',
                    componentName: 'VueFinalModal',
                    dynamicContainerName: 'ModalsContainer',
                }),
            )
            .use(Toaster)
            .mount(el);
    },
});
