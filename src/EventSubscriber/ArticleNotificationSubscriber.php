<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

class ArticleNotificationSubscriber implements EventSubscriberInterface
{
    public function onResponseEvent(ResponseEvent $event): void
    {
        $event->getResponse()->headers->set('X-Symfony-TP', 'TP5-Finished');
    }

    public static function getSubscribedEvents(): array
    {
        return [
            ResponseEvent::class => 'onResponseEvent',
        ];
    }
}
