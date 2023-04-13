<?php
namespace App\Models;

use App\Exceptions\BusinessException;
use App\Exceptions\SystemException;
use DB;
use Exception;
use DOMDocument;

class Backend
{
    public function sum_deep($array_input,$search_character){
        $search = str_split($search_character); //to split string into character in array
        $sum_deep = array();
        $count = 1;
        foreach($search as $s){
            $sum = $this->recursive_search($array_input,$s,0,1) * $count;
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

    public function get_scheme($html){
        $doc = new DOMDocument();
        $doc->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD); // prevent auto-adding of HTML, BODY tags

        $root = array(); // array to store the tree structure
        $root[] = $this->parse_attributes($doc->documentElement->attributes); // parse attributes of root element

        foreach ($doc->documentElement->childNodes as $node) {
            // only get Element node
            if ($node->nodeType == XML_ELEMENT_NODE) {
                $root[] = $this->parse_node($node); // parse child nodes recursively
            }
        }

        return $root;
    }

    public function parse_node($node) {
        $element = array();
        $element[] = $this->parse_attributes($node->attributes); // parse attributes of node

        foreach ($node->childNodes as $child) {
            if ($child->nodeType == XML_ELEMENT_NODE) {
                $element[] = $this->parse_node($child); // parse child nodes recursively
            }
        }

        return $element;
      }

    public function parse_attributes($attributes) {
        $result = array();
        foreach ($attributes as $attr) {
            $name = $attr->name;
            $value = $attr->value;
            if (strpos($name, 'sc-') === 0) {
                $result[substr($name, 3)] = $value; // strip 'sc-' prefix from attribute name
            }
        }
        return $result;
    }

    public function pattern_count($text,$pattern){
        $text_len = strlen($text);
        $pattern_len = strlen($pattern);
        $count = 0;
        for ($i = 0; $i <= $text_len - $pattern_len; $i++) {
            $substring = substr($text, $i, $pattern_len);
            if ($substring === $pattern) {
                $count++;
            }
        }
        return $count;
    }
}
