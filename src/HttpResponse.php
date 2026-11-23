<?php

declare(strict_types=1);

namespace App;

final readonly class HttpResponse
{
    /** @param array<string, mixed> $body */
    public function __construct(public int $status, public array $body)
    {
    }
}
