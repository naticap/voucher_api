<?php

namespace App\Http\Controllers;

use App\Http\Resources\PurchaseTransactionResource;
use App\Models\PurchaseTransaction;
use Illuminate\Http\Request;

class PurchaseTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return PurchaseTransactionResource::make(PurchaseTransaction::paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PurchaseTransaction  $purchaseTransaction
     * @return \Illuminate\Http\Response
     */
    public function show(PurchaseTransaction $purchaseTransaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PurchaseTransaction  $purchaseTransaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PurchaseTransaction $purchaseTransaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PurchaseTransaction  $purchaseTransaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(PurchaseTransaction $purchaseTransaction)
    {
        //
    }
}
