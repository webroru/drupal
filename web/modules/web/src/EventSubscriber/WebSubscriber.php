<?php

declare(strict_types=1);

namespace Drupal\web\EventSubscriber;

use Drupal\node\Entity\Node;
use Drupal\web\Event\EntityPresaveEvent;
use Drupal\web\Service\Ipsum;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class WebSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly Ipsum $ipsum,
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            EntityPresaveEvent::EVENT_NAME => ['onEntityPresave'],
        ];
    }

    public function onEntityPresave(EntityPresaveEvent $event): void
    {
        if ($event->entity instanceof Node) {
            $this->ipsum->ipsumNode($event->entity);
        }
    }
}
