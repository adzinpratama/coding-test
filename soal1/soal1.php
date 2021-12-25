<?php


function searchFirstDuplicat($value)
{
    $temp = [];
    foreach (str_split($value) as $str) {
        if (isset($temp[$str])) {
            return $str;
        } else {
            $temp[$str] = 1;
        }
    }
    return false;
}

var_dump(searchFirstDuplicat('CABDEBEC'));
