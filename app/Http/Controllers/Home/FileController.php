<?php
/**
 * Created by PhpStorm.
 * User: hypan599
 * Date: 2019-03-26
 * Time: 21:23
 */

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FileController extends Controller
{
//    public function index()
//    {
//        return view("index");
//    }

    public function upload(Request $request)
    {
        $path = $request->file("testupload")->store("meinv");


//        return $path;
        return view("assemble");
    }
}