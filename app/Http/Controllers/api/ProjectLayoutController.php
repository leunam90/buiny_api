<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\ProjectLayout;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProjectLayoutController extends Controller
{
    public function index(Request $request){
        $query = ProjectLayout::query()->orderBy('name');

        if($request->has('id')){

        }

        $project_layouts = $query->get();

        $data = [];
        foreach ($project_layouts as $project_layout) {
            $data[] = [
                'id' => $project_layout->id,
                'name' => $project_layout->name,
                'subtotal' => $project_layout->subtotal,
                'vat' => $project_layout->vat,
                'discount' => $project_layout->discount,
                'total' => $project_layout->total,
                'indirect_subtotal' => $project_layout->indirect_subtotal,
                'indirect_vat' => $project_layout->indirect_vat,
                'indirect_discount' => $project_layout->indirect_discount,
                'indirect_total' => $project_layout->indirect_total,
                'number_stages' => $project_layout->stages->count(),
                'stages' => $project_layout->stages
            ];
        }

        return response()->json($data, Response::HTTP_OK);
    }
}
