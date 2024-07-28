<?php

declare(strict_types=1);

namespace Drupal\ntb_snils;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\KeyValueStore\KeyValueStoreInterface;

class SnilsHandler
{
    private const COLLECTION_NAME = 'ntb_snils';

    public function __construct(
        private readonly ConfigFactoryInterface $configFactory,
        private readonly KeyValueStoreInterface $keyValueStore,
    ) {
    }

    public function validate(string $snils, string $name): bool
    {
        return $this->keyValueStore->get('ntb_snils')->get($snils) === $name;
    }
}
