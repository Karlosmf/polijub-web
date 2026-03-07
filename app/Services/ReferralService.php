<?php

namespace App\Services;

use App\Models\User;
use App\Models\Coupon;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;

class ReferralService
{
    protected $settings;

    public function __construct()
    {
        $path = base_path('config/app_settings.json');
        if (File::exists($path)) {
            $allSettings = json_decode(File::get($path), true);
            $this->settings = $allSettings['referrals'] ?? null;
        }
    }

    /**
     * Issue coupons to both the referrer and the referred user.
     *
     * @param User $newUser
     * @return void
     */
    public function issueReferralCoupons(User $newUser)
    {
        if (!$this->settings || !($this->settings['enabled'] ?? false)) {
            return;
        }

        if (!$newUser->referredBy) {
            return;
        }

        $referrer = $newUser->referredBy;

        // Create coupon for the NEW USER (Referred)
        $newBenefit = $this->settings['new_user_benefit'];
        $this->createCouponForUser(
            $newUser, 
            'REF-NEW-', 
            (float) $newBenefit['value'], 
            $newBenefit['type'],
            (int) ($newBenefit['validity_days'] ?? 30)
        );

        // Create coupon for the REFERRER
        $referrerBenefit = $this->settings['referrer_benefit'];
        $this->createCouponForUser(
            $referrer, 
            'REF-SHARE-', 
            (float) $referrerBenefit['value'], 
            $referrerBenefit['type'],
            (int) ($referrerBenefit['validity_days'] ?? 30)
        );
    }

    /**
     * Helper to create a unique coupon for a user.
     */
    private function createCouponForUser(User $user, string $prefix, float $value, string $type, int $days)
    {
        $code = $prefix . strtoupper(Str::random(6));

        $coupon = Coupon::create([
            'code' => $code,
            'type' => $type,
            'value' => $value,
            'user_id' => $user->id,
            'starts_at' => now(),
            'expires_at' => now()->addDays($days),
            'max_uses' => 1,
            'is_active' => true,
        ]);

        return $coupon;
    }
}
