<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Http\Requests\InvoiceRequest;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class InvoiceController extends BaseController
{
    public function index()
    {
        $invoices = Invoice::get();
        return view('listing', compact('invoices'));
    }

    public function store(InvoiceRequest $request)
    {
        try{
            DB::beginTransaction();
            $response = Invoice::create($request->all());
            DB::commit();
            return $this->successResponse($response, 'Item added Successfully');

        } catch (Exception $e) {
            report($e);
            return $this->errorResponse('Something Went Wrong', [], 500);
        }
        
    }

    public function generateInvoice()
    {
        try{
            $invoices = Invoice::select('item','quantity','price','tax')->get();
            if($invoices){
                $subtotalWithoutTax = $invoices->sum(function ($invoice) {
                    return $invoice->quantity * $invoice->price;
                });
        
                $subtotalWithTax = $invoices->sum(function ($invoice) {
                    $taxPercentage = intval(str_replace('%', '', $invoice->tax));
                    $taxAmount = ($invoice->quantity * $invoice->price * $taxPercentage) / 100;
        
                    return ($invoice->quantity * $invoice->price) + $taxAmount;
                });
        
                $discount = 250; 
                if ($discountAmount = request()->input('discount_amount')) {
                    $discount = $discountAmount;
                } elseif ($discountPercentage = request()->input('discount_percentage')) {
                    $discount = ($discountPercentage / 100) * $subtotalWithTax;
                }
        
                $totalAmount = $subtotalWithTax - $discount;
        
                return view('invoice', compact('invoices', 'subtotalWithoutTax', 'subtotalWithTax', 'discount', 'totalAmount'));
            } else {
                return $this->errorResponse('Invalid Data', [], 403);
            }
            
            
         } catch (Exception $e) {
            report($e);
            return $this->errorResponse('Something Went Wrong', [], 500);
        }
        
    }
}
