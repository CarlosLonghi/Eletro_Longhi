<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    /**
     * The devices that belong to the Customer
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function device()
    {
        return $this->hasMany(Device::class);
    }
}
