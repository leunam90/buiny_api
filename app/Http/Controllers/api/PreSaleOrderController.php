<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\PreSaleOrder;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PreSaleOrderController extends Controller
{
    public function index(Request $request)
    {
        $pre_sales = PreSaleOrder::all();

        $data = [];

        foreach ($pre_sales as $pre_sale) {
            $data[] = [
                'id' => $pre_sale->id,
                'customer' => $pre_sale->customer,
                'trandate' => $pre_sale->transaction_date,
                'transaction_number' => $pre_sale->transaction_number,
                'document_number' => $pre_sale->document_number,
                'internal_status' => $pre_sale->internal_status,
                'status' => $pre_sale->status,
                'items' => $pre_sale->items
            ];
        }

        return response()->json($data, Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        try {
            $pre_sale = new PreSaleOrder();
            $pre_sale->transaction_number = $request->transaction_number;
            $pre_sale->document_number = $request->document_number;
            $pre_sale->customer_id = $request->customer_id;
            $pre_sale->amount = $request->amount;
            $pre_sale->tax_amount = $request->tax_amount;
            $pre_sale->total = $request->total;

            $pre_sale->save();

            $items = $request->items;

            foreach($items as $item){

                $pre_sale->items()->attach($item['item_id'], array('quantity' => $item['quantity']));
            }



            $data = [
                'message' => 'Successfully created',
                'pre_sales' => $pre_sale
            ];

            return response()->json($data, Response::HTTP_OK);
        } catch (\Exception $ex) {
            $data = [
                'error' => true,
                'message' => $ex->getMessage()
            ];

            return response()->json($data, Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
