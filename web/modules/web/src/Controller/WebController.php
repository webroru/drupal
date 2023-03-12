<?php

declare(strict_types=1);

namespace Drupal\web\Controller;

use Drupal\Core\Controller\ControllerBase;

class WebController extends ControllerBase
{
    public function build(): array
    {
        $build['content'] = [
          '#type' => 'item',
          '#markup' => $this->t('It works!'),
        ];
        return $build;
    }
}
