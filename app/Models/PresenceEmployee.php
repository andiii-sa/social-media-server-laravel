<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PresenceEmployee extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'presence_employee';

    protected $fillable = [
        'employeeId',
        'dayId',
        'dayName',
        'clockIn',
        'clockOut',
        'image',
        'longitude',
        'latitude',
    ];

    // realtion
    public function employee()
    {
        return $this->belongsTo(User::class, 'employeeId', 'id');
    }

    public function day()
    {
        return $this->belongsTo(PresenceListDay::class, 'dayId', 'id');
    }
}
