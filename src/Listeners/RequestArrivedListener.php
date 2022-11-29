<?php

/*
 * This file is part of the ZhMead/laravel-logger.
 *
 * (c) Mead <751066209@qql.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ZhMead\Logger\Laravel\Listeners;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use ZhMead\Logger\Laravel\Events\RequestArrivedEvent;

class RequestArrivedListener
{
    public function handle(RequestArrivedEvent $event)
    {
        $uniqueId = $event->request->headers->get('X-Unique-Id') ?: Str::uuid()->toString();

        $event->request->server->set('UNIQUE_ID', $uniqueId);
    }
}
