<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Contracts\NowProvider;
use Illuminate\Http\JsonResponse;

class NowShowController extends Controller
{
    public function __invoke(NowProvider $nowProvider): JsonResponse
    {
        return response()->json([
            'datetime' => $nowProvider->get()
        ]);
    }
}
