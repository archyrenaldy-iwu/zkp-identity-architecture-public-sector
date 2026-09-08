import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    // server: {
    //     host: '0.0.0.0', // WAJIB: agar Vite bisa diakses dari luar server
    //     port: 3036,
    //     strictPort: true,
    //     hmr: {
    //         host: '178.16.139.154', // Ganti dengan IP publik atau domain kamu
    //         port: 3036,
    //     },
    // },

    
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/css/custom-css.css",
                "resources/js/app.js",
                "resources/css/output.css",
                "resources/js/modal.js",
                "resources/js/select2.js",
                "resources/js/actionHandler.js",
            ],
            refresh: true,
        }),
    ],
    build: {
        manifest: true,
        outDir: 'public/build',
        emptyOutDir: true,
        // Tambahkan baris ini agar manifest tidak disimpan di .vite
        rollupOptions: {
            output: {
                // Hapus nested folder .vite
                entryFileNames: 'assets/[name].[hash].js',
                chunkFileNames: 'assets/[name].[hash].js',
                assetFileNames: 'assets/[name].[hash].[ext]'
            }
        }
    },
});
