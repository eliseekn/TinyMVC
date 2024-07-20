<?php

namespace App\Enums;

enum TokenDescription: string
{
    public const PASSWORD_RESET_TOKEN = 'password_reset_token';
    public const EMAIL_VERIFICATION_TOKEN = 'email_verification_token';
}