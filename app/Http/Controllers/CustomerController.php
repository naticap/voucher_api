<?php

namespace App\Http\Controllers;

use App\Http\Resources\CustomerResource;
use App\Http\Resources\VoucherResource;
use App\Jobs\RollbackReservedVoucher;
use App\Models\Customer;
use App\Models\Voucher;
use Carbon\Carbon;
use Illuminate\Http\Client\Response as ClientResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Customer::class, 'customer');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return CustomerResource::make(Customer::paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $data['password'] = Hash::make($data['password']);
        $customer = Customer::create($data);  
        return new CustomerResource($customer);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        return new CustomerResource($customer);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        $customer->update($request->all());
        return new CustomerResource($customer);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
      $customer->delete();
      return response()->noContent();
    }

     /**
     * Determine whether the user eligible to take a voucher or not
     *
     * @param \Illuminate\Http\Request  $request
     * @return bool
     */
    public function eligible(Request $request)
    {
        $response = $request->user()->can('take-voucher', Customer::class);
        return response()->json($response);        
    }
    /**
     * Reserving voucher for user
     *
     * @param \Illuminate\Http\Request  $request
     * @return bool
     */
    public function reserve(Request $request)
    {
        try {
            $this->authorize('take-voucher', Customer::class);
        
            $max_upload = Carbon::now()->addMinutes(config('app.upload_minutes'));
            $voucher = Voucher::whereNull('customer_id')->first();
            $voucher->customer()->associate($request->user());
            $voucher->reserved_datetime = Carbon::now();
            $voucher->max_upload_datetime = $max_upload;
            $voucher->save();

            RollbackReservedVoucher::dispatch($voucher)->delay($max_upload);

            return response('One step closer, please upload your photo before '. $max_upload);     
        } catch (\Throwable $th) {
            return response($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);     
        }
    }

    public function uploadPhoto(Request $request)
    {
        $this->authorize('upload-photo', Customer::class);
        $voucher = $request->user()->voucher;
        // Check whether user upload the image before or after max_upload_datetime
        if($voucher->max_upload_datetime < Carbon::now()) return response('Upload time has expired', Response::HTTP_BAD_REQUEST);

        $recognized = false;
        $path = null;
        $data = $request->all();

        if($request->hasFile('photo')) {
            //Recognizing image with faker function
            $recognized = $this->recognize($request->file('photo'));
        }

        if($recognized) {
            $path = $request->file('photo')->store('voucher_photos');
            $data['photo'] = $path;
            $data['redeemable'] = '1';
            $voucher->update($data);
        }

        return new VoucherResource($voucher);
    }

     /**
     * Fake image recognition function
     *
     * @param \Illuminate\Http\UploadedFile  $image
     * @return Boolean  true
     */
    public function recognize(\Illuminate\Http\UploadedFile $image)
    {
        return true;
    }
}
