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
     * Get the device associated with the service.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function device()
    {
        return $this->belongsTo(Device::class);
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
        ];
    }
}
