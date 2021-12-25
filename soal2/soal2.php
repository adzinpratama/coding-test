<?php


function steps($number)
{
    $first = 0;
    $second = 1;
    for ($i = 0; $i < $number; $i++) {
        $third = $first + $second;
        $first = $second;
        $second = $third;
    }
    return $third;
}

function probability($number)
{
    if ($number <= 1) {
        return 1;
    } else if ($number >= 1) {
        return steps($number - 1) + steps($number - 2);
    }
}

var_dump(probability(5));
