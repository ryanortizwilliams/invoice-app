<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;

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
}
