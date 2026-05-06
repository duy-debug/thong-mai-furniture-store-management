<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class DesignRequest extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'assigned_staff_id',
        'request_code',
        'customer_name',
        'customer_phone',
        'customer_email',
        'space_address',
        'space_type',
        'space_area',
        'ceiling_height',
        'room_count',
        'style_preference',
        'main_color',
        'budget_amount',
        'desired_completion_date',
        'requirements',
        'status',
        'cancel_reason',
        'contacted_at',
        'surveyed_at',
        'completed_at',
        'cancelled_at',
    ];

    protected function casts(): array
    {
        return [
            'user_id' => 'integer',
            'assigned_staff_id' => 'integer',
            'space_area' => 'decimal:2',
            'ceiling_height' => 'decimal:2',
            'room_count' => 'integer',
            'budget_amount' => 'decimal:2',
            'desired_completion_date' => 'date',
            'contacted_at' => 'datetime',
            'surveyed_at' => 'datetime',
            'completed_at' => 'datetime',
            'cancelled_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function assignedStaff(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_staff_id')->withTrashed();
    }
}
