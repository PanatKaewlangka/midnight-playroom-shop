import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue'; // <-- 1. เพิ่มการ import นี้เข้ามา

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
        vue({ // <-- 2. เพิ่ม plugin นี้เข้าไป
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    resolve: {
        alias: { // <-- 3. เพิ่มส่วนนี้เพื่อช่วยให้ Vite หาไฟล์ Vue เจอ
            'vue': 'vue/dist/vue.esm-bundler.js',
        },
    },
});