<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Faker\Generator as FakerGenerator;
use Faker\Factory as FakerFactory;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Override the email notification for verifying email
        VerifyEmail::toMailUsing(function ($notifiable) {
            $verifyUrl = URL::temporarySignedRoute(
                'verification.verify',
                Carbon::now()->addMinutes(config('auth.verification.expire', 60)),
                ['id' => $notifiable->getKey()]
            );

            $verificationUrl = implode([
                config('app.web_url'), config('app.web_verify_email_path'), '?queryURL=', $verifyUrl
            ]);

            return (new MailMessage)
                ->subject(Lang::getFromJson('Verify Email Address'))
                ->line(Lang::getFromJson('Please click the button below to verify your email address.'))
                ->action(Lang::getFromJson('Verify Email Address'), $verificationUrl)
                ->line(Lang::getFromJson('If you did not create an account, no further action is required.'));
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->useStoragePath(config('app.app_storage'));
        $this->app->singleton(FakerGenerator::class, function () {
            return FakerFactory::create('pt_BR');
        });
    }
}
