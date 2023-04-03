<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Carbon;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        VerifyEmail::createUrlUsing(function ($notifiable) {
            $params = [
                "expires" => Carbon::now()
                    ->addMinutes(60)
                    ->getTimestamp(),
                "id" => $notifiable->getKey(),
                "hash" => sha1($notifiable->getEmailForVerification()),
            ];

            ksort($params);

            $url = route("verification.verify", $params, true);

            $key = config("app.key");
            $signature = hash_hmac("sha256", $url, $key);

            return config("app.url") .
                "/email-verified/" .
                $params["id"] .
                "/" .
                $params["hash"] .
                "?expires=" .
                $params["expires"] .
                "&signature=" .
                $signature;
        });
    }
}
