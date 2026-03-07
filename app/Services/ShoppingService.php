<?php

namespace App\Services;

use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class ShoppingService
{
    public static function getDayConfig(): ?array
    {
        $path = base_path('config/app_settings.json');
        if (!File::exists($path)) {
            return null;
        }

        $settings = json_decode(File::get($path), true);
        $config = $settings['shopping_hours'] ?? null;

        if (!$config || !($config['enabled'] ?? false)) {
            return null;
        }

        $now = Carbon::now();
        $currentDay = strtolower($now->format('D')); // mon, tue, etc.
        
        $schedule = $config['schedule'] ?? [];
        return $schedule[$currentDay] ?? null;
    }

    public static function isDayDisabled(): bool
    {
        $dayConfig = self::getDayConfig();
        // If config exists and explicitly enabled is false, day is disabled
        return $dayConfig !== null && !($dayConfig['enabled'] ?? false);
    }

    public static function isOutsideHours(): bool
    {
        $dayConfig = self::getDayConfig();
        if ($dayConfig === null || !($dayConfig['enabled'] ?? false)) {
            return false;
        }

        $now = Carbon::now();
        $currentTime = $now->format('H:i');
        $startTime = $dayConfig['start_time'] ?? '00:00';
        $endTime = $dayConfig['end_time'] ?? '23:59';

        return $currentTime < $startTime || $currentTime > $endTime;
    }

    public static function isShoppingAllowed(): bool
    {
        $path = base_path('config/app_settings.json');
        if (!File::exists($path)) {
            return true;
        }

        $settings = json_decode(File::get($path), true);
        $config = $settings['shopping_hours'] ?? null;

        if (!$config || !($config['enabled'] ?? false)) {
            return true;
        }

        $now = Carbon::now();
        $currentDay = strtolower($now->format('D'));
        $currentTime = $now->format('H:i');

        $schedule = $config['schedule'] ?? [];
        $dayConfig = $schedule[$currentDay] ?? null;

        if (!$dayConfig || !($dayConfig['enabled'] ?? false)) {
            return false;
        }

        $startTime = $dayConfig['start_time'] ?? '00:00';
        $endTime = $dayConfig['end_time'] ?? '23:59';

        return $currentTime >= $startTime && $currentTime <= $endTime;
    }

    public static function getStatusMessage(): ?string
    {
        if (self::isDayDisabled()) {
            return "Lo sentimos, hoy no tomamos pedidos online.";
        }
        
        if (self::isOutsideHours()) {
            $dayConfig = self::getDayConfig();
            return "Lo sentimos, nuestro horario de atención hoy es de {$dayConfig['start_time']} a {$dayConfig['end_time']}.";
        }

        return null;
    }
}
