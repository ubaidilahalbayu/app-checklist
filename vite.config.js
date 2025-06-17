import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    // base: '/build/', // Ganti sesuai URL ngrok
    // server: {
    //     host: true,           // supaya bisa diakses dari luar (0.0.0.0)
    //     hmr: {
    //         host: 'https://8d1e-158-140-172-77.ngrok-free.app/', // ganti dengan domain Ngrok kamu
    //         protocol: 'wss',    // websocket secure, penting buat HMR
    //     },
    //     port: 5173,             // port Vite default
    // },
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
});
