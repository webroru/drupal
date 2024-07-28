<?php

declare(strict_types=1);

namespace Drupal\ntb_snils;

use Drupal\ntb_snils\Store\SnilsStore;

class Validator
{
    public function __construct(
        private readonly SnilsStore $snilsStore,
    ) {
    }

    public function validate(string $snils, string $name): bool
    {
        return $this->snilsStore->get($snils) === $name;
    }
}
