import {createApp, h} from 'vue'
import {createInertiaApp} from '@inertiajs/vue3'

createInertiaApp({
    resolve: name => {
        const pages = require.context('./Pages', true, /\.vue$/)
        const page = pages(`./${name}.vue`)
        return page.default;
    },
    setup({el, App, props, plugin}) {
        createApp({render: () => h(App, props)})
            .use(plugin)
            .mount(el)
    },
})
