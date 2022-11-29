<?php

/*
 * This file is part of the ZhMead/laravel-logger.
 *
 * (c) Mead <751066209@qql.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

if (! function_exists('logger_async')) {
    /**
     * Log a debug message to the logs.
     *
     * @param  string  $message
     * @param  array  $context
     * @return \Illuminate\Foundation\Bus\PendingDispatch|mixed
     */
    function logger_async(string $message, array $context = [])
    {
        return dispatch(new \ZhMead\Logger\Laravel\Jobs\LogJob($message, $context, request()->server()));
    }
}
