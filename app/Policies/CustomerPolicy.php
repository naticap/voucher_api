<?php

namespace App\Policies;

use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Http\Response as HttpResponse;

class CustomerPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(Customer $customer)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\Customer  $user
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(Customer $user, Customer $customer)
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(Customer $customer)
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\Customer  $user
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(Customer $user, Customer $customer)
    {
        return $user->id === $customer->id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\Customer  $user
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(Customer $user, Customer $customer)
    {
        return $user->id === $customer->id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\Customer  $user
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(Customer $user, Customer $customer)
    {
        return $user->id === $customer->id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\Customer  $user
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(Customer $user, Customer $customer)
    {
        return $user->id === $customer->id;
    }

     /**
     * Determine whether the user eligible to take a voucher or not.
     *
     * @param  \App\Models\Customer  $user
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function takeVoucher(Customer $user)
    {   
        $eligible = 0;
        $trxs = $user->purchaseTransactions->whereBetween('created_at', [Carbon::now()->addDays(-30), now()]);
        if($trxs->count() >= 3) $eligible++;
        if($trxs->sum('total_spent') >= 100) $eligible++;
        if(!$user->voucher) $eligible++;
        return $eligible === 3;
    }

    /**
     * Determine whether the user still can upload 
     * photo or not
     *
     * @param  \App\Models\Customer  $user
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function uploadPhoto(Customer $user)
    {   
        return $user->voucher->max_upload_datetime > Carbon::now() 
                & !$user->voucher->redeemable
                ? true 
                : Response::deny("You're late, try again later");
    }
}
