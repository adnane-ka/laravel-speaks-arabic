<?php

if (!function_exists('arabic')) {
    /**
     * Get the Arabic instance
     *
     * @return \Adnane\Arabic\Arabic
     */
    function arabic()
    {
        return app(\Adnane\Arabic\Arabic::class);
    }
}
