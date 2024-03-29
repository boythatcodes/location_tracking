<?php

namespace App\Http\Controllers;

use App\Models\LocationTrack;
use Illuminate\Http\Request;
use mysql_xdevapi\Exception;

class LocationTrackController extends Controller
{
    public function create(Request $request, int $node_id)
    {

        $validatedData = $request->validate([
            'latitude' => ['required'],
            'longitude' => ['required'],
        ]);


        LocationTrack::create(["node_id" => $node_id, "latitude" => $request->latitude, "longitude" => $request->longitude]);
        return response()->json(["success"=>"Stored Successfully"]);
    }


    public function show(Request $request, int $node_id)
    {
        if(empty($node_id)){
            return response()->json(["locations"=>LocationTrack::get()]);
        }
        return response()->json(["locations"=>LocationTrack::select("id", "node_id", "latitude", "longitude","created_at")->where(["node_id" => $node_id])->orderBy("id")->get()]);
    }


    public function reset(Request $request, int $node_id)
    {
        if($node_id != 0){
            LocationTrack::where(["node_id" => $node_id])->delete();
        }
        return response()->redirectTo("/".$node_id);
    }
}
