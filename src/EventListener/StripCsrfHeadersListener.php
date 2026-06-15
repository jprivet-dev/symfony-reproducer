<?php

namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\RequestEvent;

class StripCsrfHeadersListener
{
    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();
        $request->headers->remove('sec-fetch-site');
        $request->headers->remove('origin');
        $request->headers->remove('referer');
    }
}
