<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class SubscriptionPlan extends Model
{
    use HasFactory;

    public function plan()
    {
        return $this->belongsTo(Plan::class, 'plan_id','id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id','id');
    }

    protected $appends = ['is_subscription'];
    
    public function getIsSubscriptionAttribute()
    {
        //dd($this);
        $plan=$this->plan()->where('id',$this->plan_id)->first();
        $user=$this->user()->where('id',$this->user_id)->first();
        if(!empty($plan) && !empty($user)){
            $totalPropertyOffered=9;
            if($user->role_id==2){
                if ($plan->offered_property > $totalPropertyOffered) 
                {
                    $startDate = Carbon::parse($this->start_date);
                    $endDate = Carbon::parse($this->expiry_date);
                    $today = Carbon::parse(now()->format('Y-m-d'));
                    if($today->gte($startDate) && $today->lte($endDate)) return true;
                }
            }elseif($user->role_id==3){
                $startDate = Carbon::parse($this->start_date);
                $endDate = Carbon::parse($this->expiry_date);
                $today = Carbon::parse(now()->format('Y-m-d'));
                if($today->gte($startDate) && $today->lte($endDate)) return true;
            }
            return false;
        }
        return false;
    }
}
