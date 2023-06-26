<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\ConsecutiveDocNumber;
use App\Models\PreSaleOrder;
use Egulias\EmailValidator\Result\Reason\ConsecutiveAt;
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

            $current_doc_number = $this->get_current_doc_number($request->serie, 'pre_sales_order') + 1;
            $pre_sale = new PreSaleOrder();
            $pre_sale->transaction_number = $request->serie . '' . $current_doc_number;
            $pre_sale->document_number = $current_doc_number;
            $pre_sale->customer_id = $request->customer_id;
            $pre_sale->amount = $request->amount;
            $pre_sale->tax_amount = $request->tax_amount;
            $pre_sale->total = $request->total;
            $pre_sale->save();

            $items = $request->items;

            foreach ($items as $item) {
                $pre_sale->items()->attach($item['item_id'], array('quantity' => $item['quantity']));
            }

            $this->update_current_doc_number($request->serie, $request->document_type, $current_doc_number);

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
