<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AmoCrmService;

class AmoWebHookController extends Controller
{
    
    public function handle(Request $request){
        $data = $request->all();
        $service = new AmoCrmService();
        $service->handle($data);

        return response()->json(['status' => 'success']);
    }

}
