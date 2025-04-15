<?php

namespace App\Contracts;

interface NowProvider {
    public function get(): string;
}
