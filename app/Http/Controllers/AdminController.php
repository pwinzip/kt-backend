<?php

namespace App\Http\Controllers;

use App\Models\Enterprise;
use App\Models\Farmer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function addEnterprise(Request $request) {
        // $auth = $request->user();
        // if ($auth->tokenCan("0")) {
            $fields = $request->validate([
                'registNo' => 'required|string|unique:enterprises,regist_no',
                'enterpriseName' => 'required|string',
                'enterpriseAddress' => 'required|string',
                'agentName' => 'required|string',
                'agentTel' => 'required|string|unique:users,tel',
                'agentPassword' => 'required|string',
                'isActive' => 'required|integer',
            ]);
            $user = User::create([
                "name" => $fields['agentName'],
                "tel" => $fields['agentTel'],
                "password" => Hash::make($fields['agentPassword']),
                "is_active" => $fields['isActive'],
                "role" => 1, // enterprise
            ]);
            $enterprise = Enterprise::create([
                "regist_no" => $fields['registNo'],
                "enterprise_name" => $fields['enterpriseName'],
                "address" => $fields['enterpriseAddress'],
                "agent_id" => $user->id,
                "is_active" => $fields['isActive'],
                
            ]);
            return response("New Enterprise Added", 200);
        // } else {
        //     return response('Permission Denied.', 403);
        // }
    }

    public function addFarmer(Request $request) {
        // $auth = $request->user();
        // if ($auth->tokenCan("0")) {
            $fields = $request->validate([
                'farmerName' => 'required|string',
                'farmerTel' => 'required|string|unique:users,tel',
                'farmerPassword' => 'required|string',
                'farmerAddress' => 'required|string',
                'farmerArea' => 'required|numeric',
                'farmerLat' => 'required|numeric',
                'farmerLong' => 'required|numeric',
                'farmerReceived' => 'required|integer',
                'enterpriseId' => 'required|integer',
                'isActive' => 'required|integer',
            ]);
            $user = User::create([
                "name" => $fields['farmerName'],
                "tel" => $fields['farmerTel'],
                "password" => Hash::make($fields['farmerPassword']),
                "is_active" => $fields['isActive'],
                "role" => 2, // farmer
            ]);
            $farmer = Farmer::create([
                "user_id" => $user->id,
                "address" => $fields['farmerAddress'],
                "area" => $fields['farmerArea'],
                "lat" => $fields['farmerLat'],
                "long" => $fields['farmerLong'],            
                "received_amount" => $fields['farmerReceived'],            
                "enterprise_id" => $fields['enterpriseId'],            
            ]);   
            return response("New Farmer Added", 200);
        // } else {
        //     return response('Permission Denied.', 403);
        // }
    }

    public function addAdmin(Request $request) {
        // $auth = $request->user();
        // if ($auth->tokenCan("0")) {
            $fields = $request->validate([
                'name' => 'required|string',
                'tel' => 'required|string',
                'password' => 'required|string',
                'isActive' => 'required|interger',
            ]);
            $user = User::create([
                "name" => $fields['agentName'],
                "tel" => $fields['agentTel'],
                "password" => $fields['agentPassword'],
                "is_active" => $fields['isActive'],
                "role" => 0, // admin
            ]);
            return response("New Admin Added", 200);
        // } else {
        //     return response('Permission Denied.', 403);
        // }
    }

    public function countAllEnterprisesAndMembers(Request $request) {
        $countEnterprise = Enterprise::all()->count();
        $countFarmer = Farmer::all()->count();
        $data = [
            "countEnterprise" => $countEnterprise,
            "countFarmer" => $countFarmer,
        ];
        return response($data, 200);
    }

    public function getAllEnterprises(Request $request) {
        // check admin permission
        // $auth = $request->user();
        // if ($auth->tokenCan("0")) {
            $enterprises = Enterprise::all();
            $agent = array();
            foreach ($enterprises as $value) {
                $data = [
                    "enterprise" => $value,
                    "agent" => Enterprise::find($value['id'])->users,
                ];
                array_push($agent, $data);
            }

            // array_push($agent, []);
            return response($agent, 200);
        // } else {
        //     return response('Permission Denied.', 403);
        // }
    }

    public function getAllMembers(Request $request, $enterprise_id) {
        // $auth = $request->user();
        // if ($auth->tokenCan("0")) {
            $farmers = Enterprise::find($enterprise_id)->farmers;
            $users = array();
            foreach ($farmers as $key => $value) {
               $data = [
                //    "farmer" => $value,
                   "user" => Farmer::find($value['id'])->users,
               ];
               array_push($users, $data);
            }
            
            return response($users, 200);
        // } else {
        //     return response('Permission Denied.', 403);
        // }
    }

    public function getMember(Request $request,$farmer_id) {
        // $auth = $request->user();
        // if ($auth->tokenCan("0")) {
            $farmer = Farmer::find($farmer_id);
            $user = Farmer::find($farmer_id)->users;
            $enterprise = Farmer::find($farmer_id)->enterprises;
            $agent = Enterprise::find($enterprise['id'])->users;
            $plants = Farmer::find($farmer_id)->plants;
            $remain = $farmer->received_amount;
            $addon = 0;
            if ($plants->count() > 0) {
                $remain = $plants->first()->remain_plant;
                $addon = $plants->first()->addon_plant;
            }
            $data = [
                "farmer" => $farmer,
                "user" => $user,
                "enterprise" => $enterprise,
                "agent" => $agent,
                "plants" => $plants,
                "remain" => $remain,
                "addon" => $addon,
            ];
            return response($data, 200);
        // } else {
        //     return response('Permission Denied.', 403);
        // }
    }
    


}
