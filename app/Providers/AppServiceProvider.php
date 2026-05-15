<?php

namespace App\Providers;

use Google\Cloud\Storage\StorageClient;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use League\Flysystem\Filesystem;
use League\FlysystemGoogleCloudStorage\GoogleCloudStorageAdapter;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Storage::extend('gcs', function ($app, $config) {
            $options = ['projectId' => $config['project_id']];

            if (!empty($config['key_file'])) {
                $options['keyFile'] = $config['key_file'];
            }

            $client = new StorageClient($options);
            $bucket = $client->bucket($config['bucket']);
            $adapter = new GoogleCloudStorageAdapter($bucket, $config['path_prefix'] ?? '');

            return new FilesystemAdapter(
                new Filesystem($adapter, ['visibility' => $config['visibility'] ?? 'public']),
                $adapter,
                $config
            );
        });
    }
}
