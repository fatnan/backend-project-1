<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function sum_deep(){
        // $validator = \Validator::make([
        //     'array_input'=>$array_input,
        //     'search_character' => $search_character
        // ], [
        //     'array_input' => 'required',
        //     'search_character' => 'required'
        // ],[
        //     'array_input.exists' => 'Parameter 1 must exist',
        //     'search_character.exists' => 'Parameter 2 must exist'
        // ]);

        // if ($validator->fails()) {
        //     return $validator->errors();
        // }

        // return "A";
        // $array =  [
        //     "X",
        //     [
        //         "",
        //         [
        //             "",
        //             ["Y"],
        //             ["X"]
        //         ]
        //     ], [
        //         "X",
        //         [
        //             "",
        //             ["Y"],
        //             ["Z"]
        //         ]
        //     ]
        // ];
        // $array = ["X", [""], ["X"], ["X"], ["Y", [""]], ["X"]];
        $array= ["AB", ["XY"], ["YP"]];
        // $array = ["ABAH", ["CIRCA"], ["CRUMP", ["IRA"]], ["ALI"]];
        $search = str_split("Y");
        $sum_deep = array();
        $count = 1;
        foreach($search as $s){
            $sum = $this->recursive_search($array,$s,0,1) * $count;
            array_push($sum_deep,$sum);
            $count++;
        }

        return array_sum($sum_deep);
    }

    public function recursive_search($array,$search,$sum=0,$deep=1){
        if(is_array($array)){
            foreach($array as $arr){
                if(!is_array($arr)){
                    if(strpos($arr,$search) !== false){
                        $sum = $sum+$deep;
                    }
                } else {
                    $sum =+ $this->recursive_search($arr,$search,$sum,$deep+1);
                }
            }
        }
        return $sum;

    }

    public function get_scheme(Request $request){
        $validator = \Validator::make($request->all(), [
            'html' => 'required',
        ],[
            'html.exists' => 'Parameter 1 must exist'
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $request['html']= $this->fix_input($request['html']);

        $scheme=array();
        $dom = new DOMDocument();
        $dom->loadHTML($request['html']);
        $a = $dom->saveXml($dom);
        $products = new SimpleXMLElement($a);
        $nodes = $dom->getElementsByTagName("*");
        foreach($nodes as $node){
            $attributes=array();
            foreach ($node->attributes as $attr) {
                if(strpos($attr->nodeName,"sc-") !== false){
                    $name = str_replace("sc-","",$attr->nodeName);
                    $value = $attr->nodeValue;
                    $attributes[$name]=$value;
                }
            }
            if($attributes == array()){
                continue;
            }
            array_push($scheme,$attributes);
        }
        return $scheme;
    }
}
