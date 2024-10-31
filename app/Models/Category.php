<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    /**
     * The service that belong to the category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function service()
    {
        return $this->hasMany(Service::class);
    }
}
