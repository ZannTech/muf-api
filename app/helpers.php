<?php

use Illuminate\Http\Request;


function apiResponse(String $message, Bool $success, int $statusCode)
{
    return response()->json(["message" => $message, "success" => $success], $statusCode);
}
function xssclean($post)
{
    $rtn = true;
    if ($post) {
        foreach ($post as $key => $data) {
            if (preg_match("/</i", $data, $match)) {
                $rtn = false;
            }
        }
    }
    return $rtn;
}
