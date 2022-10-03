<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'member_id', 'amount', 'payment_date', 'membership_plan_id', 'status', 'new_validity_date'
    ];

    public const STATUS_DRAFT = 1;
    public const STATUS_OPEN = 2;
    public const STATUS_PAID = 3;
    public const STATUS_NONCOLLECTABLE = 4;

    /**
     * Get the member of the payment.
     */
    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    /**
     * Get the membership plan of the payment.
     */
    public function membershipPlan()
    {
        return $this->belongsTo(MembershipPlan::class);
    }

    public static $paymentStatuses = [
        self::STATUS_DRAFT => 'Draft',
        self::STATUS_OPEN => 'Open',
        self::STATUS_PAID => 'Paid',
        self::STATUS_NONCOLLECTABLE => 'Noncollectable'
    ];

    /**
     * Returns the status column text for datatables.
     *
     * @param \App\Payment $payment
     * @return string
     */
    public static function laratablesStatus($payment)
    {
        $paymentStatus = static::$paymentStatuses;

        return $paymentStatus[$payment->status];
    }

    /**
     * Returns the action column html for datatables.
     *
     * @param \App\Payment $payment
     * @return \Illuminate\Http\Response
     */
    public static function laratablesCustomAction($payment)
    {
        return view('admin.payments.action', compact('payment'))->render();
    }

    /**
     * Returns full member name for the datatables.
     *
     * @param \App\Payment $payment
     * @return string
     */
    public static function laratablesMemberFirstName($payment)
    {
        return $payment->member->getName();
    }

    /**
     * Returns the action column html for datatables.
     *
     * @param \App\Payment $payment
     * @return \Illuminate\Http\Response
     */
    public static function laratablesCustomAvatar($payment)
    {
        $avatar =  getAvatarUrl($payment->member, 'members', 'thumb');

        return view('admin.members.avatar', compact('avatar'))->render();
    }

    /**
     * Adds the condition for searching the name of the member in the query.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $searchValue
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function laratablesSearchMemberFirstName($query, $searchValue)
    {
        return $query->orWhereHas('member', function ($q) use ($searchValue) {
            $q->where('first_name', 'like', '%'. $searchValue. '%')
                ->orWhere('last_name', 'like', '%'. $searchValue. '%')
            ;
        });
    }
}
