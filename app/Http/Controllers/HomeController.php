<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function getDistrict($id){
        $districts = \DB::table('districts')
                    ->where('districts.city', '=', $id)
                    ->where('districts.active', '=', 1)
                    ->get();   
        $html = "";
        $html .= '<option value="0">Chọn Quận / Huyện</option>';
        foreach ($districts as $district) {
            $html .= '<option value="'.$district->id.'">'.$district->name.'</option>';
        }
        return $html;
    }

    public function getDistrictApi($id){
        $districts = \DB::table('districts')
                    ->where('districts.city', '=', $id)
                    ->where('districts.active', '=', 1)
                    ->get();
        return \Response::json(array('code' => '200', 'message' => 'success', 'districts' => $districts));
    }

    public function getTown($id){
        $towns = \DB::table('towns')
                    ->where('towns.district', '=', $id)
                    ->where('towns.active', '=', 1)
                    ->get();   
        $html = "";
        $html .= '<option value="0">Chọn Phường / Xã</option>';
        foreach ($towns as $town) {
            $html .= '<option value="'.$town->id.'">'.$town->name.'</option>';
        }
        return $html;
    }

    public function getTownApi($id){
        $towns = \DB::table('towns')
                    ->where('towns.district', '=', $id)
                    ->where('towns.active', '=', 1)
                    ->get();   
        return \Response::json(array('code' => '200', 'message' => 'success', 'towns' => $towns));
    }

    public function getHotelInTownBK(Request $request){
        $input = $request->all();
        if ($input['city'] == null){
            $input['city'] = 1;
        }
        if ($input['district'] == null){
            $input['district'] = 1;
        }
        if ($input['town'] == null){
            $input['town'] = 1;
        }
        if ($input['from'] == null){
            $input['from'] = 0;
        }
        if ($input['number_get'] == null){
            $input['number_get'] = 10;
        }

        $sql = "SELECT 
                    users.id, 
                    users.name as hotelName,
                    users.images as images,
                    cities.name as cityName,
                    districts.name as districtName,
                    towns.name as townName,
                    users.address as address,
                    users.phone as phone,
                    room_type.name as rtName,
                    room_type.priceinroom as rtP1,
                    room_type.priceovernight as rtP2,
                    room_type.priceaday as rtP3
                FROM 
                    users ";
        $sql .= "JOIN 
                    room_type ON users.id = room_type.created_by ";
        $sql .= "JOIN 
                    cities ON users.city = cities.id ";
        $sql .= "JOIN 
                    districts ON users.district = districts.id ";
        $sql .= "JOIN 
                    towns ON users.town = towns.id ";
        $sql .= "WHERE 
                    1 = 1 ";
        if($input['city'] > 0){
            if($input['district'] > 0){
                if($input['town'] > 0){
                    $sql .= " AND users.town = " . $input['town'];
                }else{
                    $sql .= " AND users.district = " . $input['district'];
                }
            }else{
                $sql .= " AND users.city = " . $input['city'];
            }
        }
        $sql .= " ORDER BY users.id DESC";
        $sql .= " LIMIT " . $input['from'] . ", " . $input['number_get'];

        $dataReturn = \DB::select($sql);

        return \Response::json(array('code' => '200', 'message' => 'success', 'dataReturn' => $dataReturn));
    }

    public function postHotelInTown(Request $request){
        $input = $request->all();
        if ($input['city'] == null){
            $input['city'] = 1;
        }
        if ($input['district'] == null){
            $input['district'] = 1;
        }
        if ($input['town'] == null){
            $input['town'] = 1;
        }
        if ($input['from'] == null){
            $input['from'] = 0;
        }
        if ($input['number_get'] == null){
            $input['number_get'] = 10;
        }

        $sql = "SELECT 
                    users.id, 
                    users.name as hotelName,
                    users.images as images,
                    users.lat as lat,
                    users.lng as lng,
                    cities.name as cityName,
                    districts.name as districtName,
                    towns.name as townName,
                    users.address as address,
                    users.phone as phone,
                    room_type.name as rtName,
                    room_type.priceinroom as rtP1,
                    room_type.priceovernight as rtP2,
                    room_type.priceaday as rtP3
                FROM 
                    users ";
        $sql .= "JOIN 
                    room_type ON users.id = room_type.created_by ";
        $sql .= "JOIN 
                    cities ON users.city = cities.id ";
        $sql .= "JOIN 
                    districts ON users.district = districts.id ";
        $sql .= "JOIN 
                    towns ON users.town = towns.id ";
        $sql .= "WHERE 
                    1 = 1 ";
        if($input['city'] > 0){
            if($input['district'] > 0){
                if($input['town'] > 0){
                    $sql .= " AND users.town = " . $input['town'];
                }else{
                    $sql .= " AND users.district = " . $input['district'];
                }
            }else{
                $sql .= " AND users.city = " . $input['city'];
            }
        }
        $sql .= " ORDER BY users.id DESC";
        $sql .= " LIMIT " . $input['from'] . ", " . $input['number_get'];

        $dataReturn = \DB::select($sql);
        $ret = array();
        foreach ($dataReturn as $data) {
            if(!isset($ret[$data->id])){
                $ret[$data->id] = $data;
                $ret[$data->id]->images = explode(";", rtrim($data->images, ';'));
                $ret[$data->id]->room_type[] = array('name'=>$data->rtName, 'rtP1' => $data->rtP1, 'rtP2' => $data->rtP2, 'rtP3' => $data->rtP3);
            }else{
                $ret[$data->id]->room_type[] = array('name'=>$data->rtName, 'rtP1' => $data->rtP1, 'rtP2' => $data->rtP2, 'rtP3' => $data->rtP3);
            }
        }

        return \Response::json(array('code' => '200', 'message' => 'success', 'dataReturn' => $ret));
    }

    public function getHotelInTown(Request $request){
        $input = $request->all();
        if ($input['city'] == null){
            $input['city'] = 1;
        }
        if ($input['district'] == null){
            $input['district'] = 1;
        }
        if ($input['town'] == null){
            $input['town'] = 1;
        }
        if ($input['from'] == null){
            $input['from'] = 0;
        }
        if ($input['number_get'] == null){
            $input['number_get'] = 10;
        }

        $sql = "SELECT 
                    users.id, 
                    users.name as hotelName,
                    users.images as images,
                    users.lat as lat,
                    users.lng as lng,
                    cities.name as cityName,
                    districts.name as districtName,
                    towns.name as townName,
                    users.address as address,
                    users.phone as phone,
                    room_type.name as rtName,
                    room_type.priceinroom as rtP1,
                    room_type.priceovernight as rtP2,
                    room_type.priceaday as rtP3
                FROM 
                    users ";
        $sql .= "JOIN 
                    room_type ON users.id = room_type.created_by ";
        $sql .= "JOIN 
                    cities ON users.city = cities.id ";
        $sql .= "JOIN 
                    districts ON users.district = districts.id ";
        $sql .= "JOIN 
                    towns ON users.town = towns.id ";
        $sql .= "WHERE 
                    1 = 1 ";
        if($input['city'] > 0){
            if($input['district'] > 0){
                if($input['town'] > 0){
                    $sql .= " AND users.town = " . $input['town'];
                }else{
                    $sql .= " AND users.district = " . $input['district'];
                }
            }else{
                $sql .= " AND users.city = " . $input['city'];
            }
        }
        $sql .= " ORDER BY users.id DESC";
        $sql .= " LIMIT " . $input['from'] . ", " . $input['number_get'];

        $dataReturn = \DB::select($sql);
        $ret = array();
        foreach ($dataReturn as $data) {
            if(!isset($ret[$data->id])){
                $ret[$data->id] = $data;
                $ret[$data->id]->images = explode(";", rtrim($data->images, ';'));
                $ret[$data->id]->room_type[] = array('name'=>$data->rtName, 'rtP1' => $data->rtP1, 'rtP2' => $data->rtP2, 'rtP3' => $data->rtP3);
            }else{
                $ret[$data->id]->room_type[] = array('name'=>$data->rtName, 'rtP1' => $data->rtP1, 'rtP2' => $data->rtP2, 'rtP3' => $data->rtP3);
            }
        }

        return \Response::json(array('code' => '200', 'message' => 'success', 'dataReturn' => $ret));
    }
}
