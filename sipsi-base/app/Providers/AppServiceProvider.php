<?php

namespace App\Providers;

use App\Notifications\ResetPasswordNotification;
use App\Services\DocGeneratorService;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(DocGeneratorService::class, function ($app) {
            return new DocGeneratorService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::directive('sidebarActive', function ($expression) {
            return "<?php echo request()->is(trim($expression, '\"')) || request()->is(trim($expression, '\"') . '/*') ? 'sidebar-active' : ''; ?>";
        });

        ResetPassword::toMailUsing(function ($notifiable, $token) {
            return (new ResetPasswordNotification($token))
                ->toMail($notifiable);
        });
    }
}
