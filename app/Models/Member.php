<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Member extends Authenticatable implements HasMedia
{
    use Notifiable, SoftDeletes, LogsActivity, InteractsWithMedia, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name', 'last_name', 'date_of_birth', 'email', 'stripe_id', 'phone', 'emergency_number', 'address', 'status', 'member_since', 'notes', 'referred_by','validity_date', 'height', 'membership_plan_id', 'gender'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnlyDirty();
    }

    /**
     * Get the timings/batches of the member.
     */
    public function timings()
    {
        return $this->belongsToMany(Timing::class);
    }

    /**
     * Get the referrer detail.
     */
    public function referents()
    {
        return $this->hasMany(Member::class, 'referred_by', 'id');
    }
    /**
     * Get the Membership plan detail.
     */
    public function membershipPlan()
    {
        return $this->belongsTo(MembershipPlan::class);
    }

    /**
     * Get the Measurements of the member.
     */
    public function memberMeasurements()
    {
        return $this->hasMany(MemberMeasurement::class);
    }

    /**
     * Get the payments of the member.
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Returns the full name of the member.
     *
     * @return string
     **/
    public function getName()
    {
        return $this->first_name.' '.$this->last_name;
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
     * Specify collection and conversion for spatie media library.
     *
     * @return void
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('members')
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
     * Returns full name for the datatables.
     *
     * @param \App\Member $member
     * @return \Illuminate\Http\Response
     */
    public static function laratablesFirstName($member)
    {
        $name = $member->getName();
        $id = $member->id;

        return view('admin.members.name', compact('name', 'id'))->render();
    }

    /**
     * Returns the status column text for datatables.
     *
     * @param \App\Member $member
     * @return \Illuminate\Http\Response
     */
    public static function laratablesStatus($member)
    {
        return $member->status ? '<span class="text-success">Active</span>' : '<span class="text-danger">Inactive</span>';
    }

    /**
     * Returns the action column html for datatables.
     *
     * @param \App\Member $member
     * @return \Illuminate\Http\Response
     */
    public static function laratablesCustomAction($member)
    {
        return view('admin.members.action', compact('member'))->render();
    }

    /**
     * Returns the action column html for datatables.
     *
     * @param \App\Member $member
     * @return \Illuminate\Http\Response
     */
    public static function laratablesCustomAvatar($member)
    {
        $avatar = getAvatarUrl($member, 'members', 'thumb');

        return view('admin.members.avatar', compact('avatar'))->render();
    }

    /**
     * Adds the condition for searching the name of the user in the query.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $searchValue
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function laratablesSearchFirstName($query, $searchValue)
    {
        return $query->orWhere('first_name', 'like', '%'. $searchValue. '%')
            ->orWhere('last_name', 'like', '%'. $searchValue. '%')
        ;
    }
}
