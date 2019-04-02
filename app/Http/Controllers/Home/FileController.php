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


    public function upload(Request $request)
    {
        $category = $request->input('fileCategory');
        $newFileName = $request->input('newFileName');
        $file = $request->file("filename");
//        $path = $file->store("assemble", 'newfile');
        $file->storePubliclyAs($category[0], $newFileName, ['disk' => 'uploads']);

//        return $path;
//        return view("assemble");
        return redirect("/");
    }
}