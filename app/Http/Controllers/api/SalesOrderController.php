<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\ConsecutiveDocNumber;
use App\Models\SalesOrder;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SalesOrderController extends Controller
{
    public function index(Request $request){
        $sales_orders = SalesOrder::all();

        $data = [];

        foreach($sales_orders as $sales_order){
            $data[] = [
                'id' => $sales_order->id,
                'customer' => $sales_order->customer,
                'trandate' => $sales_order->transaction_date,
                'transaction_number' => $sales_order->transaction_number,
                'document_number' => $sales_order->document_number,
                'internal_status' => $sales_order->internal_status,
                'status' => $sales_order->status,
                'items' => $sales_order->items
            ];
        }
        return response()->json($data, Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        try {

            $current_doc_number = $this->get_current_doc_number($request->serie, 'sales_order') + 1;
            $sales_order = new SalesOrder();
            $sales_order->transaction_number = $request->serie . '' . $current_doc_number;
            $sales_order->document_number = $current_doc_number;
            $sales_order->customer_id = $request->customer_id;
            $sales_order->amount = $request->amount;
            $sales_order->tax_amount = $request->tax_amount;
            $sales_order->total = $request->total;
            $sales_order->save();

            $items = $request->items;

            foreach ($items as $item) {
                $sales_order->items()->attach($item['item_id'], array('quantity' => $item['quantity']));
            }

            $this->update_current_doc_number($request->serie, $request->document_type, $current_doc_number);

            $data = [
                'message' => 'Successfully created',
                'sales_orders' => $sales_order
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

    public function get_current_doc_number($serie, $document_type)
    {
        $current_doc_number = ConsecutiveDocNumber::where('serie', $serie)->where('document_type', $document_type)->first();

        if (!$current_doc_number) {
            $current_doc_number = new ConsecutiveDocNumber();
            $current_doc_number->serie = $serie;
            $current_doc_number->document_number = 1;
            $current_doc_number->document_type = $document_type;
            $current_doc_number->save();
        }
        return $current_doc_number->document_number;
    }

    public function update_current_doc_number($serie, $document_type, $current_number){
        $current_doc_number = ConsecutiveDocNumber::where('serie', $serie)->where('document_type', $document_type)->first();
        $current_doc_number->current_doc_number = $current_number;
        $current_doc_number->save();

        return true;
    }
}
