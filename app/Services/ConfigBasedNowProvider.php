<?php

namespace App\Services;

use App\Contracts\NowProvider;
use Carbon\Carbon;

readonly class ConfigBasedNowProvider implements NowProvider
{
    public function __construct(private ?string $fakeDatetime) {}


    public function get(): string
    {
        return $this->fakeDatetime
            ? Carbon::parse($this->fakeDatetime)->toRfc3339String()
            : now()->toRfc3339String();
    }
}
