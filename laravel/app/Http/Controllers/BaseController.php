<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BaseController extends Controller
{


    function success( $data , $code = 200) {
        return response()->json($data, $code);
    }


    function error( $data , $code = 404) {
        return response()->json($data, $code);
    }


}
