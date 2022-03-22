<?php

namespace App\Http\Controllers;

use App\Models\Farmer;
use App\Models\Plant;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PlantController extends Controller
{
    public function addPlants(Request $request, $id) {
        $fields = $request->validate([
            'remain' => 'required|integer',
            'addonAmount' => 'required|integer',
            'addonSpecies' => 'required|string',
            'expectedDate' => 'required|string',
            'expectedAmount' => 'required|numeric',
        ]);
        $plant = Plant::create([
            'farmer_id' => $id,
            'remain_plant' => $fields['remain'],
            'addon_plant' => $fields['addonAmount'],
            'addon_species' => $fields['addonSpecies'],
            'date_for_sale' => Carbon::createFromFormat('d/m/Y', $fields['expectedDate'])->format('Y-m-d'),
            'quantity_for_sale' => $fields['expectedAmount'],
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        return response("New Plant Added", 200);
    }

    
 
}
