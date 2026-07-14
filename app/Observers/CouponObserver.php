<?php

namespace App\Observers;

use App\Models\Coupon;

class CouponObserver
{
    public function created(Coupon $coupon): void
    {
        logActivity('Created', 'Coupon', "Coupon '{$coupon->code}' was created.");
    }

    public function updated(Coupon $coupon): void
    {
        $changed = $coupon->getChanges();
        unset($changed['updated_at']);
        if (empty($changed)) return;

        $fields = array_keys($changed);
        logActivity('Updated', 'Coupon', "Coupon '{$coupon->code}' was updated. (" . implode(', ', $fields) . ')');
    }

    public function deleted(Coupon $coupon): void
    {
        logActivity('Deleted', 'Coupon', "Coupon '{$coupon->code}' was deleted.");
    }
}
