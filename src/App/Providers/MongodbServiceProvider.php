<?php

namespace Code\MongoDb\App\Providers;

use Illuminate\Support\ServiceProvider;
use Code\MongoDb\Eloquent\Model;
use Code\MongoDb\Connection;
use Code\MongoDb\Queue\MongoConnector;

class MongodbServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        Model::setConnectionResolver($this->app['db']);

        Model::setEventDispatcher($this->app['events']);
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        // Add database driver.
        $this->app->resolving('db', function ($db) {
            $db->extend('mongodb', function ($config, $name) {
                $config['name'] = $name;

                return new Connection($config);
            });
        });

        // Add connector for queue support.
        $this->app->resolving('queue', function ($queue) {
            $queue->addConnector('mongodb', function () {
                return new MongoConnector($this->app['db']);
            });
        });
    }
}
