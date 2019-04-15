<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class FileManagerController extends Controller
{
    public function index($status)
    {
        $files = Storage::allFiles("/");
        switch ($status) {
            case "ready":
                $prompt = "please choose an action";
                break;

            case "fail":
                $prompt = "bad file! please check your input";
                break;

            case "pass":
                $prompt = "upload successful! please choose another action";
                break;
        }
        return view("FileManager", compact("files", "prompt"));
    }

    // todo: robust
    public function upload(Request $request)
    {
        $file = $request->file("filename");
        $category = $request->input('fileCategory')[0];
        $newFileName = $request->input('newFileName');
        $file->storePubliclyAs($category, $newFileName, ['disk' => 'uploads']); // todo: save large files
        $output = exec('python3 ../web_src/scripts/filecheck.py ../web_src/storage/app/uploads/' . $category . "/" . $newFileName); // relative path different on server
        $output = exec('python3 -c import os;print(os.getcwd())'); // relative path different on server
        if ($output == "fail") {
            Storage::delete($category . "/" . $newFileName);
            return redirect("FileManager/fail");
        } elseif ($output == "pass") {
            return redirect("FileManager/pass");
        } else {
            return redirect("FileManager/ready");
        }
    }

    public function get_file_list()
    {
        $files = Storage::allFiles("/");
        return view("analysis", compact("files"));
    }

    // todo: robust
    public function downloadOrDelete(Request $request)
    {
        $category = $request->input('fileCategory')[0];
        $fileName = $request->input('fileName');
        switch ($request->btn) {
            case "download":
                return Storage::download($category . "/" . $fileName);  // todo: test download
                break;

            case "delete":
                Storage::delete($category . "/" . $fileName);
                return redirect("FileManager/ready");
        }
    }

    public function start_analysis(Request $request)
    {
        echo("your script is running<br>");
//        $output = exec('../scripts/wrapper.sh', $array, $return);
        $output = exec('../../t1g5/bin/python3 ../scripts/main.py', $array, $return);
        echo("<script>console.log('".$output."');</script>");
        echo("<br>".$return);
        echo("<br>please check your email for further info. redirecting to home page now...<br>");
//        sleep(2);
        return view('index');
//        return redirect("/");
    }
}
