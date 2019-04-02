<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class FileManagerController extends Controller
{
    public function index()
    {
        $assemble_files = Storage::allFiles("assemble");
        $prediction_files = Storage::allFiles("prediction");
        $annotation_files = Storage::allFiles("annotation");
        $comparative_files = Storage::allFiles("comparative");
        return view("FileManager", compact("assemble_files", "prediction_files", "annotation_files", "comparative_files"));
    }

    public function upload(Request $request)
    {
        $category = $request->input('fileCategory');
        $newFileName = $request->input('newFileName');
        $file = $request->file("filename");
        $file->storePubliclyAs($category[0], $newFileName, ['disk' => 'uploads']);

//        return $path;
//        return view("assemble");
        return redirect("FileManager");
    }

    public function download(Request $request)
    {
        $category = $request->input('fileCategory');
        $fileName = $request->input('fileName');
        return Storage::download($category."/".$fileName);
    }

}
