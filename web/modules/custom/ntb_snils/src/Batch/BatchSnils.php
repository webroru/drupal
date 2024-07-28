<?php

declare(strict_types=1);

namespace Drupal\ntb_snils\Batch;

use Drupal\Core\Batch\BatchBuilder;
use Drupal\ntb_snils\Store\SnilsStore;

class BatchSnils
{
    private const BATCH = 5000;

    public function create(string $fileUri): void
    {
        $file = new \SplFileObject($fileUri, 'r');
        $file->seek(PHP_INT_MAX);
        $total = $file->key() + 1;

        $batchBuilder = (new BatchBuilder())
            ->setTitle(t('SNILS import'))
            ->setFinishCallback([static::class, 'finish'])
            ->setInitMessage(t("Start import."))
            ->setProgressMessage(t('Completed @current step of @total.'))
            ->setErrorMessage(t('Operation has encountered an error.'))
            ->addOperation([static::class, 'handle'], [$fileUri, $total])
        ;

        batch_set($batchBuilder->toArray());
    }

    public static function handle(string $file, int $total, array &$context): void
    {
        $handle = fopen($file, 'r');
        if (!isset($context['results']['processed'])) {
            $context['results']['processed'] = 1;
            $context['results']['current_position'] = 0;
        }

        self::skipBytes($handle, $context['results']['current_position']);

        $line = 0;
        while ($line < self::BATCH && ($data = fgetcsv($handle, 0, ';')) !== false) {
            if (!empty($data[0]) && !empty($data[1]) && ctype_digit($data[1])) {
                \Drupal::service(SnilsStore::class)->set($data[1], $data[0]);
            }
            $line++;
            $context['results']['processed']++;
        }

        $context['results']['current_position'] = ftell($handle);;
        fclose($handle);

        $context['finished'] = $context['results']['processed'] / $total;
    }

    public static function finish(bool $success, array $results, array $operations, string $elapsed): void
    {
        $messenger = \Drupal::messenger();
        if ($success) {
            $messenger->addMessage(t('@count results processed.', ['@count' => $results['processed']]));
        } else {
            $errorOperation = reset($operations);
            $messenger->addMessage(
                t(
                    'An error occurred while processing @operation with arguments: @args',
                    [
                        '@operation' => $errorOperation[0],
                        '@args' => print_r($errorOperation[0], true),
                    ]
                )
            );
        }
    }

    private static function skipBytes($handle, $skipBytes): void
    {
        if (fseek($handle, $skipBytes) !== 0) {
            fclose($handle);
            throw new \Exception("Can't read file.");
        }
    }
}
