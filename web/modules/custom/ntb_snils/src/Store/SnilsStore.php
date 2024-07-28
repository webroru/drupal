<?php

declare(strict_types=1);

namespace Drupal\ntb_snils\Store;

use Drupal\Core\KeyValueStore\KeyValueFactoryInterface;
use Drupal\Core\KeyValueStore\KeyValueStoreInterface;

class SnilsStore
{
    private const COLLECTION = 'snils';
    private KeyValueStoreInterface $keyValueStore;

    public function __construct(KeyValueFactoryInterface $keyValueFactory)
    {
        $this->keyValueStore = $keyValueFactory->get(self::COLLECTION);
    }

    public function get(string $snils): ?string
    {
        return $this->keyValueStore->get($snils);
    }

    public function set(string $snils, string $name): void
    {
        $this->keyValueStore->set($snils, $name);
    }
}
