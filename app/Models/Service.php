<?php

namespace App\Models;

use App\ServiceStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    /**
     * Get the category associated with the service.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the casts array.
     *
     * @return array<string, string>
     */
    public function casts()
    {
        return [
            'status' => ServiceStatus::class,
            'device_accessories' => 'array',
        ];
    }
}
