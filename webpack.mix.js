mix.browserSync({
    proxy: 'localhost:8000', // Sesuaikan dengan URL lokal Anda
    files: [
        'app/**/*',
        'public/**/*',
        'resources/views/**/*',
        'routes/**/*',
        'config/**/*',
    ]
});
