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

            case "badname":
                $prompt = "bad file name. must be fastq format.";
        }
        return view("FileManager", compact("files", "prompt"));
    }

    // todo: robust
    public function upload(Request $request)
    {
        $file = $request->file("filename");
        $category = $request->input('fileCategory')[0];
        $newFileName = $request->input('newFileName');
        $file_name_len = strlen($newFileName);
        if (substr_compare($newFileName, '.fastq', $file_name_len-6) != 0){
            return redirect("FileManager/badname");
        }
        $disk = Storage::disk('uploads');
        $disk -> putFileAs($category, $file, $newFileName);
        //$disk -> putFileAs($category, fopen($file, 'r+'), $newFileName);
//        $file->storePubliclyAs($category, $newFileName, ['disk' => 'uploads']); // todo: save large files
        $output = exec('../../t1g5/bin/python3 ../scripts/filecheck.py ../storage/app/uploads/'.$category.'/'.$newFileName);
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
        return view("index", compact("files"));
    }

    // todo: robust
    public function downloadOrDelete(Request $request)
    {
        $category = $request->input('fileCategory')[0];
        $fileName = $request->input('fileName');
        switch ($request->btn) {
            case "download":
                return Storage::download($category . "/" . $fileName);  // todo: test download

            case "delete":
                Storage::delete($category . "/" . $fileName);
                return redirect("FileManager/ready");
        }
    }

    public function start_analysis(Request $request)
    {
        $input = $request->all();
//        dd($input);
        // check input
        // todo: check if job name exists
        if ($request->input('inputFile1') == $request->input('inputFile2')){
            return redirect("analysis/dupin");
        }elseif (empty($request->input('inputFile1'))) {
            return redirect("analysis/noinput");
        }elseif (empty($request->input('jobName'))) {
            return redirect("analysis/nojob");
        }else{
            // pass all pre check
            $base_cmd = '../../t1g5/bin/python3 ../scripts/main.py -j '.$request->input('jobName');
            if (!empty($request->input('doAssemble'))){
                $base_cmd = $base_cmd." -a";
                $input_file = " --infastq ".$request->input('inputFile1')." ".$request->input('inputFile2');
            }
            if (!empty($request->input('doPrediction'))){
                $base_cmd = $base_cmd." -b";
                if (!isset($input_file)){
                    $input_file = " --infasta ".$request->input('inputFile1');
                }
            }
            if (!empty($request->input('doAnnotation'))){
                $base_cmd = $base_cmd." -c -f ".$request->input('annotationRadio');
            }
            if (!empty($request->input('doComparative'))){
                $base_cmd = $base_cmd." -d";
            }
            $base_cmd = $base_cmd.$input_file;

        }
//        dd($base_cmd);
        echo("<script>console.log('your script is running');</script>");
        exec($base_cmd." 2>&1", $array, $return);
        echo("<script>console.log('".$return."');</script>");
        dd($array);
        return view('about');
    }

    public function start_analysis_ajax(Request $request)
    {
        $input = $request->all();
        dd($input);
        // check input
        // todo: check if job name exists
        if ($request->input('inputFile1') == $request->input('inputFile2')){
            return redirect("analysis/dupin");
        }elseif (empty($request->input('inputFile1'))) {
            return redirect("analysis/noinput");
        }elseif (empty($request->input('jobName'))) {
            return redirect("analysis/nojob");
        }else{
            // pass all pre check
            $base_cmd = '../../t1g5/bin/python3 ../scripts/main.py -j '.$request->input('jobName');
            if (!empty($request->input('doAssemble'))){
                $base_cmd = $base_cmd." -a";
                $input_file = " --infastq ".$request->input('inputFile1')." ".$request->input('inputFile2');
            }
            if (!empty($request->input('doPrediction'))){
                $base_cmd = $base_cmd." -b";
                if (!isset($input_file)){
                    $input_file = " --infasta ".$request->input('inputFile1');
                }
            }
            if (!empty($request->input('doAnnotation'))){
                $base_cmd = $base_cmd." -c -f ".$request->input('annotationRadio');
            }
            if (!empty($request->input('doComparative'))){
                $base_cmd = $base_cmd." -d";
            }
            $base_cmd = $base_cmd.$input_file;

        }
//        dd($base_cmd);
        echo("<script>console.log('your script is running');</script>");
        exec($base_cmd." 2>&1", $array, $return);
        echo("<script>console.log('".$return."');</script>");
        dd($array);
        return view('about');
    }

}
