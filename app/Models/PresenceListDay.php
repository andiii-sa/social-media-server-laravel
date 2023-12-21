<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PresenceListDay extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'presence_list_day';

    protected $fillable = [
        'name',
        'sequence',
    ];

    // realtion
    public function presence_employee()
    {
        return $this->hasMany(PresenceEmployee::class, 'dayId', 'id');
    }

    public function presence_schedule()
    {
        return $this->hasMany(PresenceScheduleEmployee::class, 'dayId', 'id');
    }
}
