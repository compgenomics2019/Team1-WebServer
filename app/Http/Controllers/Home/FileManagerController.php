<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class FileManagerController extends Controller
{
    public function index()
    {
        $files = Storage::allFiles("assemble");
//        return view("FileManager", ["param" => $files]);
        return $files;
    }
}
