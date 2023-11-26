<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Counter;

class InvoiceController extends Controller
{
    public function get_all_invoice() {
        $invoices = Invoice::all();
        return response()->json([
            'invoices' => $invoices
        ],200); 
    }

    public function search_invoice(Request $request) {
        $search = $request->get('s');
        if($search !== null){
            $invoices = Invoice::with('customer')->where('id','LIKE',"%$search%")->get(); 
            return response()->json([
                'invoices' => $invoices
            ],200);
        }else{
            return $this->get_all_invoice();
        }
    }

    public function create_invoice(Request $request) {
        // Attempt to retrieve the counter or create a new one if it doesn't exist
        $counter = Counter::firstOrCreate(['key' => 'invoice'], ['value' => 0]);
    
        $invoice = Invoice::orderBy('id', 'DESC')->first();
        $counters = $counter->value;
    
        if ($invoice) {
            $counters = $counters + $invoice->id + 1;
        }
    
        // Increment the counter value for the next use
        $counter->incrementValue();
    
        $formData = [
            'number' => $counter->prefix . $counters,
            'customer_id' => null,
            'customer' => null,
            'date' => now()->format('Y-m-d'),
            'due_date' => null,
            'reference' => null,
            'discount' => 0,
            'term_and_conditions' => 'Default Terms and Conditions',
            'items' => [
                [
                    'product_id' => null,
                    'product' => null,
                    'unit_price' => 0,
                    'quantity' => 1
                ]
            ]
        ];
    
        return response()->json($formData);
    }
    
}
