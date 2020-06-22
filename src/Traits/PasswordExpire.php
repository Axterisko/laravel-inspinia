<?php

namespace Axterisko\Inspinia\Traits;

use Carbon\Carbon;

trait PasswordExpire
{
    public static function bootExpiredPassword()
    {
        static::created(function ($item) {
            $item->update([
                'password_changed_at' => Carbon::now(),
            ]);
        });
    }

    /**
     *  Determines if user's password is expired
     *
     * @return bool
     * @throws \Exception
     */
    public function hasExpiredPassword()
    {
        return !$this->hasNoPasswordHistory()
            && (new Carbon($this->attributes['password_changed_at']))->lt(Carbon::now()
                ->subDays(config('inspinia.password_life')));
    }

    /**
     * @return bool
     */
    public function hasNoPasswordHistory()
    {
        return !$this->attributes['password_changed_at'];
    }
}
