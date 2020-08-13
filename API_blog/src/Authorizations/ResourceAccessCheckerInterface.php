<?php

declare(strict_types=1);

namespace App\Authorizations;

interface ResourceAccessCheckerInterface
{
    const MESSAGE_ERROR = "it's not your ressource";

    public function canAccess(?int $id): void;
}
