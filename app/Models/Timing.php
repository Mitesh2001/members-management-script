<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timing extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'start_time', 'end_time', 'notes'
    ];

    /**
     * Static options for timings.
     *
     * @var array
     */
    public static $timingOptions = [
        '05:00:00' => '5:00 AM',
        '05:30:00' => '5:30 AM',
        '06:00:00' => '6:00 AM',
        '06:30:00' => '6:30 AM',
        '07:00:00' => '7:00 AM',
        '07:30:00' => '7:30 AM',
        '08:00:00' => '8:00 AM',
        '08:30:00' => '8:30 AM',
        '09:00:00' => '9:00 AM',
        '09:30:00' => '9:30 AM',
        '10:00:00' => '10:00 AM',
        '10:30:00' => '10:30 AM',
        '11:00:00' => '11:00 AM',
        '11:30:00' => '11:30 AM',
        '12:00:00' => '12:00 PM',
        '12:30:00' => '12:30 PM',
        '13:00:00' => '1:00 PM',
        '13:30:00' => '1:30 PM',
        '14:00:00' => '2:00 PM',
        '14:30:00' => '2:30 PM',
        '15:00:00' => '3:00 PM',
        '15:30:00' => '3:30 PM',
        '16:00:00' => '4:00 PM',
        '16:30:00' => '4:30 PM',
        '17:00:00' => '5:00 PM',
        '17:30:00' => '5:30 PM',
        '18:00:00' => '6:00 PM',
        '18:30:00' => '6:30 PM',
        '19:00:00' => '7:00 PM',
        '19:30:00' => '7:30 PM',
        '20:00:00' => '8:00 PM',
        '20:30:00' => '8:30 PM',
        '21:00:00' => '9:00 PM',
        '21:30:00' => '9:30 PM',
        '22:00:00' => '10:00 PM',
        '22:30:00' => '10:30 PM',
        '23:00:00' => '11:00 PM',
        '23:30:00' => '11:30 PM',
        '00:00:00' => '12:00 AM',
    ];

    /**
     * Return the timing options.
     *
     * @return array
     */
    public static function getTimingOptions()
    {
        return static::$timingOptions;
    }

    /**
     * Get the members of the timing/batch.
     */
    public function members()
    {
        return $this->belongsToMany(Member::class);
    }

    /**
     * Get the trainers of the timing/batch.
     */
    public function trainers()
    {
        return $this->belongsToMany(Trainer::class);
    }

    /**
     * Returns the action column html for datatables.
     *
     * @param \App\Timing $timing
     * @return \Illuminate\Http\Response
     */
    public static function laratablesCustomAction($timing)
    {
        return view('admin.timings.action', compact('timing'))->render();
    }

    /**
     * Returns the members count column html for datatables.
     *
     * @param \App\Timing $timing
     * @return int count of members
     */
    public static function laratablesCustomMembersCount($timing)
    {
        return $timing->members_count;
    }

    /**
     * Returns the trainers count column html for datatables.
     *
     * @param \App\Timing $timing
     * @return int count of trainers
     */
    public static function laratablesCustomTrainersCount($timing)
    {
        return $timing->trainers_count;
    }

    /**
     * Fetches count of the members of the timing for datatables.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function laratablesQueryConditions($query)
    {
        return $query->withCount('members')
            ->withCount('trainers')
        ;
    }
}
