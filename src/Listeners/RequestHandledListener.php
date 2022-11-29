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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use ZhMead\Logger\Laravel\Events\RequestHandledEvent;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class RequestHandledListener
{
    public function handle(RequestHandledEvent $event)
    {
        $start = $event->request->server('REQUEST_TIME_FLOAT');
        $end = microtime(true);

        $request = $event->request->all();
        if ($files = $event->request->allFiles()) {
            foreach ($files as $key => $uploadedFile) {
                $request[$key] = [
                    'originalName' => $uploadedFile->getClientOriginalName(),
                    'mimeType' => $uploadedFile->getClientMimeType(),
                ];
            }
        }
        $guard = config('logging.guard', false);
        $context = [
            'request' => $request,
            'response' => $event->response instanceof SymfonyResponse ? json_decode($event->response->getContent(), true) : (string)$event->response,
            'start' => $start,
            'end' => $end,
            'duration' => format_duration($end - $start),
            'user' => $guard ? auth($guard)->user() : null,
        ];

        logger_async(\config('logging.request.message'), $context)
            ->onConnection(\config('logging.request.connection'))
            ->onQueue(\config('logging.request.queue'));
    }
}
