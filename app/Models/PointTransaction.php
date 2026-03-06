<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\File;

class PointTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_id',
        'points',
        'type',
        'description',
        'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'points' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get current valid balance for a user.
     */
    public static function getBalance(User $user): int
    {
        // Earned points not yet expired - Spent/Adjusted points
        $earned = self::where('user_id', $user->id)
            ->where('points', '>', 0)
            ->where(function ($query) {
                $query->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());
            })
            ->sum('points');

        $spent = self::where('user_id', $user->id)
            ->where('points', '<', 0)
            ->sum('points');

        return max(0, (int)($earned + $spent));
    }

    /**
     * Create an "earned" transaction based on config.
     */
    public static function earn(User $user, int $points, $orderId = null, $description = null)
    {
        $settings = self::getSettings('loyalty_points');
        $validityDays = $settings['validity_days'] ?? 365;

        return self::create([
            'user_id' => $user->id,
            'order_id' => $orderId,
            'points' => $points,
            'type' => 'earned',
            'description' => $description ?: 'Puntos ganados por compra',
            'expires_at' => now()->addDays($validityDays),
        ]);
    }

    /**
     * Deduct points for redemption.
     */
    public static function spend(User $user, int $points, $description = null)
    {
        if (self::getBalance($user) < $points) {
            throw new \Exception('Saldo de puntos insuficiente');
        }

        return self::create([
            'user_id' => $user->id,
            'points' => -abs($points),
            'type' => 'spent',
            'description' => $description ?: 'Canje de puntos',
        ]);
    }

    /**
     * Load settings from generic JSON file.
     * Can pass a section name like 'loyalty_points' or 'delivery'
     */
    public static function getSettings($section = null)
    {
        $path = base_path('config/app_settings.json');
        if (!File::exists($path)) {
            return $section ? [] : [];
        }

        $allSettings = json_decode(File::get($path), true);
        
        if ($section) {
            return $allSettings[$section] ?? [];
        }

        return $allSettings;
    }
}
