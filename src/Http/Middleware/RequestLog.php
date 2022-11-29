<?php

/*
 * This file is part of the ZhMead/laravel-logger.
 *
 * (c) Mead <751066209@qql.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ZhMead\Logger\Laravel\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use ZhMead\Logger\Laravel\Events\RequestArrivedEvent;
use ZhMead\Logger\Laravel\Events\RequestHandledEvent;

class RequestLog
{
    public function handle(Request $request, Closure $next)
    {
        event(new RequestArrivedEvent($request));

        return $next($request);
    }

    public function terminate(Request $request, $response)
    {
        event(new RequestHandledEvent($request, $response));
    }
}
