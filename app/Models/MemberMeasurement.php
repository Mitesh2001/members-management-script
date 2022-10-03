<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberMeasurement extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'member_id', 'measurement_type', 'measurement_value', 'measurement_date'
    ];

    /**
     * Static Measure for the Measurement.
     *
     * @var array<int, string>
     */
    public static $measurementTypes = [
        1 => 'Arms',
        2 => 'Chest',
        3 => 'Fat',
        4 => 'Thigh',
        5 => 'Weight',
        6 => 'Waist',
    ];

    /**
     * Returns the measurement types.
     *
     * @var array<int, string>
     */
    public static function getMeasurementTypes()
    {
        return static::$measurementTypes;
    }

    /**
     * Get the Member of the Measurement.
     */
    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
