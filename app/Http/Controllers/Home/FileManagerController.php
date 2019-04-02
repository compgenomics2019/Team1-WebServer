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

    public function assemble_file_list()
    {
        $assemble_files = Storage::allFiles("assemble");
        return view("assemble")->with("files", $assemble_files);
    }
    public function prediction_file_list()
    {
        $prediction_files = Storage::allFiles("prediction");
        return view("predict")->with("files", $prediction_files);
    }
    public function annotation_file_list()
    {
        $annotation_files = Storage::allFiles("annotation");
        return view("annotation")->with("files", $annotation_files);
    }
    public function comparative_file_list()
    {
        $comparative_files = Storage::allFiles("comparative");
        return view("compare")->with("files", $comparative_files);
    }
}
