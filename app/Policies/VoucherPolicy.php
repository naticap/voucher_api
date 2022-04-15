<?php

namespace App\Policies;

use App\Models\Customer;
use App\Models\Voucher;
use Carbon\Carbon;
use Illuminate\Auth\Access\HandlesAuthorization;

class VoucherPolicy
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
        return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\Customer  $customer
     * @param  \App\Models\Voucher  $voucher
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(Customer $customer, Voucher $voucher)
    {
        return $voucher->customer && $voucher->customer->id === $customer->id;
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
     * @param  \App\Models\Customer  $customer
     * @param  \App\Models\Voucher  $voucher
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(Customer $customer, Voucher $voucher)
    {
        return $voucher->customer && $voucher->customer->id === $customer->id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\Customer  $customer
     * @param  \App\Models\Voucher  $voucher
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(Customer $customer, Voucher $voucher)
    {
        return $voucher->customer && $voucher->customer->id === $customer->id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\Customer  $customer
     * @param  \App\Models\Voucher  $voucher
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(Customer $customer, Voucher $voucher)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\Customer  $customer
     * @param  \App\Models\Voucher  $voucher
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(Customer $customer, Voucher $voucher)
    {
        return false;
    }
}
