import '../css/live.css';
import './bootstrap';
import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import Toaster from '@meforma/vue-toaster';
import { vfmPlugin } from 'vue-final-modal';
import LiveHelpers from './helpers/live';

createInertiaApp({
    resolve: (name) => {
        const pages = import.meta.glob('./Pages/**/*.vue', { eager: true });
        return pages[`./Pages/${name}.vue`];
    },
    setup({ el, App, props, plugin }) {
        const app = createApp({
            render: () => h(App, props),
            provide: {
                helpers: LiveHelpers,
            },
        })
            .use(plugin)
            .use(
                vfmPlugin({
                    key: '$vfm',
                    componentName: 'VueFinalModal',
                    dynamicContainerName: 'ModalsContainer',
                }),
            )
            .use(Toaster);

        app.config.globalProperties.$live = LiveHelpers;

        app.mount(el);
    },
});
