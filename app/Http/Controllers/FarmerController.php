<?php

namespace App\Http\Controllers;

use App\Models\Farmer;
use App\Models\Plant;
use App\Models\User;
use Illuminate\Http\Request;

class FarmerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Farmer::find(2)->users;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $auth = $request->user();

        if ( $auth->tokenCan("0")) { // admin permission allowed
            $fields = $request->validate([
                'name' => 'required|string',
                'tel' => 'required|string|unique:users,tel',
                'password' => 'required|string',
                'address' => 'required|string',
                'growingArea' => 'required|numeric',
                'latPlot' => 'required|numeric',
                'longPlot' => 'required|numeric',
                'receivedAmount' => 'required|integer',
                'enterpriseId' => 'required|integer',
            ]);

            $user = User::create([
                'name' => $fields['name'],
                'tel' => $fields['tel'],
                'password' => $fields['password'],
                'role' => 2,
            ]);

            $farmer = Farmer::create([
                'user_id' => $user->id,
                'address' => $fields['address'],
                'growing_area' => $fields['growingArea'],
                'lat_plot' => $fields['latPlot'],
                'long_plot' => $fields['longPlot'],
                'received_amount' => $fields['receivedAmount'],
                'enterprise_id' => $fields['enterpriseId'],

            ]);
            return response('New Farmer Created', 201);
        } else {
            return response('Permission Denied.', 403);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Farmer  $farmers
     * @return \Illuminate\Http\Response
     */
    public function show(Farmer $farmers)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Farmers  $farmers
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Farmer $farmers)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Farmers  $farmers
     * @return \Illuminate\Http\Response
     */
    public function destroy(Farmer $farmers)
    {
        //
    }

    public function getInfo($id) {
        $farmer = Farmer::find($id);
        $remain_amount = $farmer->received_amount;
        $plant = Farmer::find($id)->getCurrentPlants;
        if(count($plant) > 0) {
            $remain_amount = $plant->first()->remain_plant;
        }

        $data = [
            "remain" => $remain_amount,
        ];

        return response($data, 200);
    }

    public function getPlants($id) {
        $plant = Farmer::find($id)->plants;
        $data = [
            "payload" => $plant,
        ];

        return response($data, 200);
    }
}
