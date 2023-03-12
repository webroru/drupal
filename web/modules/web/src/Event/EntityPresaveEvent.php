<?php

declare(strict_types=1);

namespace Drupal\web\Event;

use Drupal\Component\EventDispatcher\Event;
use Drupal\Core\Entity\EntityInterface;

class EntityPresaveEvent extends Event
{
    public const EVENT_NAME = 'web_entity_presave';

    public function __construct(
        public EntityInterface $entity,
    ) {
    }
}
