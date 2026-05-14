<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Mail\MailManager;
use Symfony\Component\Mailer\Bridge\Mailjet\Transport\MailjetTransportFactory;
use Symfony\Component\Mailer\Transport\Dsn;

class MailjetServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->app->make(MailManager::class)->extend('mailjet', function () {
            $key = $this->app['config']->get('services.mailjet.key');
            $secret = $this->app['config']->get('services.mailjet.secret');

            $factory = new MailjetTransportFactory();
            return $factory->create(new Dsn(
                'mailjet+api',
                'default',
                $key,
                $secret
            ));
        });
    }
}
