<?php


$arrayScore = array(null,null,null,null,null); 


$checkScore = count(array_filter($arrayScore,function ($item_values) {
    if ($item_values === null)
    {
        return false;
    }
        return true;
}));

echo $checkScore;