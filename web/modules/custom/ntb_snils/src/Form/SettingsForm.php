<?php

declare(strict_types=1);

namespace Drupal\ntb_snils\Form;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\File\FileSystemInterface;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\ntb_snils\Batch\BatchSnils;
use Symfony\Component\DependencyInjection\ContainerInterface;

final class SettingsForm extends ConfigFormBase
{
    public const SETTINGS = 'ntb_snils.settings';

    public function __construct(
        private readonly BatchSnils $batchSnils,
        ConfigFactoryInterface $configFactory,
        protected $typedConfigManager = null,
    ) {
        parent::__construct($configFactory, $typedConfigManager);
    }

    public static function create(ContainerInterface $container): self
    {
        return new self(
            $container->get(BatchSnils::class),
            $container->get('config.factory'),
            $container->get('config.typed'),
        );
    }

    public function getFormId(): string
    {
        return self::SETTINGS;
    }

    protected function getEditableConfigNames(): array
    {
        return [self::SETTINGS];
    }

    public function buildForm(array $form, FormStateInterface $form_state): array
    {
        $form['csv_file'] = [
            '#type' => 'file',
            '#title' => $this->t('Upload CSV file'),
            '#description' => $this->t('Upload a CSV file for processing.'),
        ];

        $form['error_message'] = [
            '#type' => 'textarea',
            '#title' => $this->t('The message will be shown if SNILS is not valid'),
            '#default_value' => $this->config(self::SETTINGS)->get('error_message'),
        ];

        $form['actions']['process'] = [
            '#type' => 'submit',
            '#value' => $this->t('Process CSV File'),
            '#button_type' => 'primary',
            '#submit' => ['::processFile'],
        ];

        return parent::buildForm($form, $form_state);
    }

    public function processFile(array &$form, FormStateInterface $form_state): void
    {
        $validators = ['file_validate_extensions' => ['csv']];
        if ($file = file_save_upload('csv_file', $validators, false, 0, FileSystemInterface::EXISTS_REPLACE)) {
            $file->setPermanent();
            $file->save();

            $this->batchSnils->create($file->getFileUri());
        }
    }

    public function submitForm(array &$form, FormStateInterface $form_state): void
    {
        $this->config(self::SETTINGS)
            ->set('error_message', $form_state->getValue('error_message'))
            ->save();

        parent::submitForm($form, $form_state);
    }
}
