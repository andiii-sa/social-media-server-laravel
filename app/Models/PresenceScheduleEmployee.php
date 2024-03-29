<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PresenceScheduleEmployee extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'presence_schedule_employee';

    protected $fillable = [
        'employeeId',
        'dayId',
        'locationWorkId',
    ];

    // realtion
    public function employee()
    {
        return $this->belongsTo(User::class, 'employeeId', 'id')->select('id', 'username', 'email', 'name');
    }

    public function day()
    {
        return $this->belongsTo(PresenceListDay::class, 'dayId', 'id')->select('id', 'name');
    }

    public function location_work()
    {
        return $this->belongsTo(PresenceLocationWork::class, 'locationWorkId', 'id')->select('id', 'name', 'clockIn', 'clockOut', 'isRequiredLocation', 'isRequiredPhoto');
    }
}
