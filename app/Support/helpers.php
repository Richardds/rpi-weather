<?php

if (!function_exists('asset_url')) {
    /**
     * Generate a url for the application with hashed target suffix.
     *
     * @param  string $path
     * @param  mixed $parameters
     * @param  bool $secure
     * @return string
     */
    function asset_url($path = null, $parameters = [], $secure = null)
    {
        $path_name = 'version_' . str_replace('/', '_', $path);
        $crc32 = Cache::remember($path_name, 60 * 24, function () use ($path) {
            return hash('crc32', file_get_contents(base_path('public/' . $path)));
        });
        return app('url')->to($path, $parameters, $secure) . '?' . $crc32;
    }
}
