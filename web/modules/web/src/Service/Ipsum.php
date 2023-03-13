<?php

declare(strict_types=1);

namespace Drupal\web\Service;

use Drupal\Core\Render\Element\Form;
use Drupal\node\Entity\Node;
use joshtronic\LoremIpsum;

class Ipsum
{
    public function __construct(
        private readonly LoremIpsum $loremIpsum,
    ) {
    }

    public function ipsumNode(Node $node, bool $save = false): void
    {
        $body = [
            'summary' => $this->loremIpsum->paragraph(),
            'value' => $this->loremIpsum->paragraphs(3, true),
        ];
        $node->set('body', $body);
        $node->setTitle($this->loremIpsum->words(3));
        if ($save) {
            $node->save();
        }
    }

    public function ipsumForm(Form $form): void
    {}
}
