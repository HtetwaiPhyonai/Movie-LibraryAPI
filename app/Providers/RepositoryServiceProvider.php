<?php

namespace App\Providers;
use App\Repository\Movie\MovieRepo;
use App\Repository\Movie\MovieRepoInterface;
use App\Service\Comment\CommentService;
use App\Service\Comment\CommentServiceInterface;
use App\Service\Movie\MovieService;
use App\Service\Movie\MovieServiceInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        $this->app->bind(MovieServiceInterface::class, MovieService::class);
        $this->app->bind(MovieRepoInterface::class, MovieRepo::class);
        $this->app->bind(CommentServiceInterface::class, CommentService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        // You can leave this method empty unless you have specific bootstrapping tasks.
    }
}
