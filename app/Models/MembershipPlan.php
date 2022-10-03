<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembershipPlan extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name', 'price', 'plan'];

    /**
     * Static options for the plan.
     *
     * @var array<int, string>
     */
    public static $planOptions = [
        1 => 'Monthly',
        2 => 'Quarterly',
        3 => 'Half-yearly',
        4 => 'Yearly',
    ];

    /**
     * Returns the plan options.
     *
     * @var array<int, string>
     */
    public static function getPlanOptions()
    {
        return static::$planOptions;
    }

    /**
     * Get the Members of the MembershipPlans.
     */
    public function members()
    {
        return $this->hasMany(Member::class);
    }
}
