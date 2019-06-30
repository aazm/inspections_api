<?php

namespace App\Http\Controllers;

use App\Services\InspectionService;
use Illuminate\Http\Request;

class InspectionController extends Controller
{
    public function inspect(Request $request)
    {
        $service = new InspectionService();
        $service->fill($request->get('payload'));

        return response()->json($service->inspect());
    }
}
