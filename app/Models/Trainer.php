<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Trainer extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia, LogsActivity, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name','last_name','gender','mobile_no','phone','email','address'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnlyDirty();
    }

    /**
     * Get the timings/batches of the trainer.
     */
    public function timings()
    {
        return $this->belongsToMany(Timing::class);
    }

    /**
     * Specify collection and conversion for spatie media library.
     *
     * @return void
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('trainers')
            ->singleFile()
            ->registerMediaConversions(function () {
                $this->addMediaConversion('thumb')
                    ->width(100)
                    ->height(100)
                ;
            })
        ;
    }

    /**
     * Additional columns to be loaded for datatables.
     *
     * @return array
     */
    public static function laratablesAdditionalColumns()
    {
        return ['last_name'];
    }

    /**
     * Returns the full name of the trainer.
     *
     * @return string
     **/
    public function getName()
    {
        return $this->first_name.' '.$this->last_name;
    }

    /**
     * Returns full name for the datatables.
     *
     * @param \App\Trainer $trainer
     * @return string
     */
    public static function laratablesFirstName($trainer)
    {
        return $trainer->getName();
    }

    /**
     * Returns the status column text for datatables.
     *
     * @param \App\Trainer $trainer
     * @return string
     */
    public static function laratablesGender($trainer)
    {
        return $trainer->gender == 1  ? 'Male' : 'Female';
    }

    /**
     * Returns the action column html for datatables.
     *
     * @param \App\Trainer $trainer
     * @return \Illuminate\Http\Response
     */
    public static function laratablesCustomAction($trainer)
    {
        return view('admin.trainers.action', compact('trainer'))->render();
    }

    /**
     * Returns the action column html for datatables.
     *
     * @param \App\Trainer $trainer
     * @return \Illuminate\Http\Response
     */
    public static function laratablesCustomAvatar($trainer)
    {
        $avatar = getAvatarUrl($trainer, 'trainers', 'thumb');

        return view('admin.trainers.avatar', compact('avatar'))->render();
    }

    /**
     * Adds the condition for searching the name of the trainer in the query.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $searchValue
     * @param \Illuminate\Database\Eloquent\Builder
     */
    public static function laratablesSearchFirstName($query, $searchValue)
    {
        return $query->orWhere('first_name', 'like', '%'. $searchValue. '%')
            ->orWhere('last_name', 'like', '%'. $searchValue. '%')
        ;
    }
}
