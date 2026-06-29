<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = ['title', 'image', 'status'];

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    protected static function booted(): void
    {
        static::saving(function ($banner) {
            if ($banner->status) {
                static::where('id', '!=', $banner->id)->update(['status' => false]);
            }
        });
    }
}
