<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerGroup extends Model
{
    protected $fillable = ['name', 'discount_percentage', 'is_active'];

    public function customers()
    {
        return $this->hasMany(User::class);
    }
}
