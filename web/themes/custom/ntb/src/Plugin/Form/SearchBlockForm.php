<?php

declare(strict_types=1);

namespace Drupal\ntb\Plugin\Form;

use Drupal\bootstrap\Plugin\Form\SearchBlockForm as BootstrapSearchBlockForm;
use Drupal\bootstrap\Utility\Element;
use Drupal\Core\Form\FormStateInterface;

/**
 * Implements hook_form_FORM_ID_alter().
 *
 * @ingroup plugins_form
 *
 * @BootstrapForm("search_api_page_block_form")
 */
class SearchBlockForm extends BootstrapSearchBlockForm
{
    public function alterFormElement(Element $form, FormStateInterface $form_state, $form_id = null) {
        $form->actions->submit->setProperty('icon_only', true);
        $form->keys->setProperty('input_group_button', true);
    }
}
