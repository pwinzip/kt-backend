<?php

namespace App\Http\Controllers;

use App\Models\Enterprise;
use App\Models\Farmer;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Http\Request;

use Carbon\Carbon;

class EnterpriseController extends Controller
{
    public function getMembers($id) {
        $members = Enterprise::find($id)->farmers;
        $users = [];
        foreach ($members as $m) {
            $user = Farmer::find($m->id)->users;
            $plants = Farmer::find($m->id)->plants;
            if($plants->count() > 0) {
                $remain = $plants->first()->remain_plant;
            }
            else {
                $remain = $m->received_amount;
            }
            $new_arr = [
                "id" => $m->id,
                "address" => $m->address,
                "area" => $m->area,
                "lat" => $m->lat,
                "long" => $m->long,
                "userid" => $user->id,
                "name" => $user->name,
                "tel" => $user->tel,
                "remain" => $remain,
                "created_at" => $user->created_at,
            ];
            array_push($users, $new_arr);
        }

        $data = [
            "payload" =>  $users,
        ];

        return response($data, 200);
    }

    public function getSales($id) {
        $sales = Enterprise::find($id)->sales;
        $data = [
            "payload" =>  $sales,
        ];

        return response($data, 200);
    }

    public function addSales(Request $request, $id) {
        $fields = $request->validate([
            'saleDate' => 'required|string',
            'saleAmount' => 'required|numeric',
        ]);
        $sale = Sale::create([
            'enterprise_id' => $id,
            'date_for_sale' => Carbon::createFromFormat('d/m/Y', $fields['saleDate'])->format('Y-m-d'),
            'quantity_for_sale' => $fields['saleAmount'],
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        return response("New Sale Added", 200);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Enterprise::find(1)->farmers;
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
                'registNo' => 'required|string',
                'enterpriseName' => 'required|numeric',
                'address' => 'required|string',
            ]);

            $user = User::create([
                'name' => $fields['name'],
                'tel' => $fields['tel'],
                'password' => $fields['password'],
                'role' => 1,
            ]);

            $enterprise = Enterprise::create([
                'agent_id' => $user->id,
                'regist_no' => $fields['registNo'],
                'enterprise_name' => $fields['enterpriseName'],
                'address' => $fields['address'],

            ]);
            return response('New Enterprise Created', 201);
        } else {
            return response('Permission Denied.', 403);
        }
    }

    public function countAllPlants(Request $request, $id) {
        $farmers = Enterprise::find($id)->farmers;
        $count_plant = 0;
        foreach ($farmers as $value) {
            $count = Farmer::find($value['id'])->plants->first();
            if ($count) {
                $count_plant = $count_plant + $count['remain_plant'];
            } else {
                $count_plant = $count_plant + $value['received_amount'];
            }
        }
        $data = [
            "farmers" => $farmers->count(),
            "plants" => $count_plant,
        ];

        return response($data, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Enterprises  $enterprises
     * @return \Illuminate\Http\Response
     */
    public function show(Enterprise $enterprises)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Enterprises  $enterprises
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Enterprise $enterprises)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Enterprises  $enterprises
     * @return \Illuminate\Http\Response
     */
    public function destroy(Enterprise $enterprises)
    {
        //
    }
}
