<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class NowShowTest extends TestCase
{
    public function test_returns_the_current_datetime(): void
    {
        Carbon::setTestNow($fakeNow = now());

        $response = $this->getJson(route('now.show'));

        $response->assertJson([
            'datetime' => $fakeNow->toRfc3339String(),
        ]);

        $response->assertOk();
    }

    public function test_the_current_datetime_can_be_overwritten_in_config_through_env_file(): void
    {
        $envDatetimeValue = now()->subYear();

        Config::set('app.fake_now', $envDatetimeValue->toRfc3339String());

        $response = $this->getJson(route('now.show'));

        $response->assertJson([
            'datetime' => $envDatetimeValue->toRfc3339String(),
        ]);

        $response->assertOk();
    }

    public function test_rate_limit_is_working(): void
    {
        $response = $this->getJson(route('now.show'));

        $response->assertOk();

        $response = $this->getJson(route('now.show'));

        $response->assertTooManyRequests();
    }

    public function test_rate_limit_is_only_1_second(): void
    {
        Carbon::setTestNow($fakeNow = now());

        $response = $this->getJson(route('now.show'));

        $response->assertOk();

        Carbon::setTestNow($fakeNow->addSecond());

        $response = $this->getJson(route('now.show'));

        $response->assertOk();
    }
}
