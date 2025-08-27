import {defineConfig} from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [laravel({
        input: [
            'resources/css/app.css', 
            'resources/js/app.js',
            'resources/css/play.css',
            'resources/js/play.js'
        ],
        refresh: true,
    }), tailwindcss(),
    ],
    server: {
        // proxy: {'/': 'http://localhost:8000',},
    },
});
