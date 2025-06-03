<?php
namespace App\Providers;

use App\Interfaces\EventConsumer;
use App\Services\KafkaEventConsumer;
use Dedoc\Scramble\Scramble;
use Dedoc\Scramble\Support\Generator\OpenApi;
use Dedoc\Scramble\Support\Generator\SecurityScheme;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(EventConsumer::class, KafkaEventConsumer::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureScramble();
        $this->configureModel();
    }

    private function configureScramble(): void
    {
        Scramble::configure()
            ->withDocumentTransformers(function (OpenApi $openApi) {
                $openApi->secure(
                    SecurityScheme::http('Bearer')
                );
            });
    }

    private function configureModel(): void
    {
        Model::shouldBeStrict();
        Model::automaticallyEagerLoadRelationships();
    }
}
