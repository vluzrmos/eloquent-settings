<?php

if (!function_exists('setting')) {
    /**
     * @param string $key
     * @param mixed $default
     * @return \Vluzrmos\EloquentSettings\Setting|mixed
     */
    function setting($key = null, $default = null)
    {
        /** @var Vluzrmos\EloquentSettings\Setting $settings */
        $settings = app(\Vluzrmos\EloquentSettings\Setting::class);

        if ($key) {
            return $settings->get($key, $default);
        }

        return $settings;
    }
}
