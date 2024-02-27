<?php

use App\Models\User;
use Carbon\Carbon;

if (!function_exists('user')) {
    function user(): ?User
    {
        if (auth()->check()) {
            return auth()->user();
        }

        return null;
    }
}

function formatDateTime(?string $date = null): string
{
    return $date ? Carbon::parse($date)->format('d/m/Y') : '-';
}

function formatMoney(float $value): string
{
    return number_format($value, 2, ',', '.');
}

function cleanMoney(string $value): string
{
    return trim(str_replace('R$', '', $value));
}

function formatMoneyToFloat(string $value): float
{
    return (float) cleanMoney(str_replace(['.', ','], ['', '.'], $value));
}
