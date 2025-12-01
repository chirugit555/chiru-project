
<?php
// src/functions.php

declare(strict_types=1);

/**
 * Escape output for HTML.
 */
function e(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

/**
 * Basic email validation.
 */
function is_valid_email(string $email): bool
{
    return (bool) filter_var($email, FILTER_VALIDATE_EMAIL);
}

/**
 * Basic phone validation (very simple).
 */
function is_valid_phone(string $phone): bool
{
    // accept digits, spaces, +, -, parentheses; length check
    $clean = preg_replace('/[^\d]/', '', $phone);
    return strlen($clean) >= 8 && strlen($clean) <= 15;
}
