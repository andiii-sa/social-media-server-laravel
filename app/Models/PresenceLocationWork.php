<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PresenceLocationWork extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'presence_location_work';

    protected $fillable = [
        'name',
        'clockIn',
        'clockOut',
        'isRequiredLocation',
        'isRequiredPhoto',
    ];

    // realtion
    public function presence_schedule()
    {
        return $this->hasMany(PresenceScheduleEmployee::class, 'locationWorkId', 'id');
    }
}
