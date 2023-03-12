<?php

declare(strict_types=1);

namespace Drupal\web\EventSubscriber;

use Drupal\Core\Messenger\MessengerInterface;
use Drupal\node\Entity\Node;
use Drupal\web\Event\EntityPresaveEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class WebSubscriber implements EventSubscriberInterface
{
    public function __construct(protected MessengerInterface $messenger)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            EntityPresaveEvent::EVENT_NAME => ['onEntityPresave'],
        ];
    }

    public function onEntityPresave(EntityPresaveEvent $event): void
    {
        if ($event->entity->getEntityType()->getClass() === Node::class) {
            $event->entity->set('body', '123');
            $this->messenger->addStatus(__FUNCTION__);
        }
    }
}
