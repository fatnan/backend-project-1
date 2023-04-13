<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Backend;
use App\Models\MotorBoat;
use App\Models\SailBoat;
use App\Models\Yacht;
use DOMDocument;
use DOMText;
use DOMXPath;
use SimpleXMLElement;

class BackendController extends Controller
{
    public function sum_deep(Request $request){
        $validator = \Validator::make($request->all(), [
            'array_input' => 'required',
            'search_character' => 'required'
        ],[
            'array_input.required' => 'Parameter 1 must exist',
            'search_character.required' => 'Parameter 2 must exist'
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        //fix input that contain ""
        $request['array_input']= $this->fix_input($request['array_input']);
        $request['search_character']= $this->fix_input($request['search_character']);

        $sum_deep = (new Backend)->sum_deep($request['array_input'],$request['search_character']);

        return $sum_deep;
    }

    public function get_scheme(Request $request) {
        $validator = \Validator::make($request->all(), [
            'html' => 'required',
        ],[
            'html.required' => 'Parameter 1 must exist'
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $html = $this->fix_input($request['html']);

        $root = (new Backend)->get_scheme($html);

        return json_encode($root);
    }

    public function pattern_count(Request $request) {
        $validator = \Validator::make($request->all(), [
            'text' => 'required',
            'pattern' => 'nullable'
        ],[
            'text.required' => 'Parameter 1 must exist',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $count = (new Backend)->pattern_count($request['text'],$request['pattern']);
        return $count;
    }

    public function fix_input($array){
        $array= str_replace("”","\"",$array);
        $array= str_replace("“","\"",$array);
        return $array;
    }

    public function ship(){
        $objMotorboat = new MotorBoat("Yamaha Boats","500","Diesel");
        $objSailboat = new SailBoat("Mast Boat","400","20 ft");
        $objYacht = new Yacht("Oculus","3000","Super");

        $motorboat = [
            $objMotorboat->getName(), // access protected type via get function
            "Type : ".$objMotorboat->getType(), // polymorphism from ship
            "Fuel Type : ".$objMotorboat->getFuelType(),
        ];

        $sailboat = [
            $objSailboat->getName(),
            "Type : ".$objSailboat->getType(),
            "Mast Height : ".$objSailboat->getMastHeight(),
        ];

        $yacht = [
            $objYacht->getName(),
            "Type : ".$objYacht->getType(),
            "Luxury Level : ".$objYacht->getLuxuryLevel(),
        ];

        $ships = [
            'Motor Boat' => $motorboat,
            'Sail Boat' => $sailboat,
            'Yacht' => $yacht
        ];

        return $ships;
    }
}
