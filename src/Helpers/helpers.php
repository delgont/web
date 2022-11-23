<?php


if(!function_exists('url_format')){
    function url_format($value, $delimiter = null){
        return ($delimiter) ? str_replace(' ', $delimiter, $value) : str_replace(' ', '-', $value);
    }
}
