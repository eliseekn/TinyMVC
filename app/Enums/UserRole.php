<?php

declare(strict_types=1);

namespace App\Enums;

enum UserRole: string
{
    public const ADMIN = 'admin';

    public const USER = 'user';
}
