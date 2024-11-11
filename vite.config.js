import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',         // Main CSS file
                'resources/js/app.js',           // Main JS file
                'resources/css/rate_modal.css',  // rate_modal.css file
                'resources/js/rate_modal.js',    // rate_modal.js file
                'resources/js/admin-category-subcategory.js'     // admin-category-subcategory.js file
            ],
            refresh: true,
        }),
    ],
});
