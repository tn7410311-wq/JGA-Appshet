<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_google_redirect_uses_app_url_when_env_is_not_set(): void
    {
        $previousAppUrl = getenv('APP_URL');
        $previousGoogleRedirect = getenv('GOOGLE_REDIRECT_URI');

        putenv('APP_URL=http://localhost:8000');
        putenv('GOOGLE_REDIRECT_URI=');

        try {
            $config = require base_path('config/services.php');
            $this->assertSame('http://localhost:8000/auth/google/callback', $config['google']['redirect']);
        } finally {
            if ($previousAppUrl === false) {
                putenv('APP_URL');
            } else {
                putenv('APP_URL=' . $previousAppUrl);
            }

            if ($previousGoogleRedirect === false) {
                putenv('GOOGLE_REDIRECT_URI');
            } else {
                putenv('GOOGLE_REDIRECT_URI=' . $previousGoogleRedirect);
            }
        }
    }
}
