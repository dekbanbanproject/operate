<?php

namespace App\Http\Controllers;
use Artisan;
use Storage;
use File;
use Illuminate\Http\Request;

class BackupController extends Controller
{
    public function index(){


        return view('backups.index');
    }

    public function listbody(Request $request)
    {
        $allFiles = Storage::allFiles('backupDB');
        $files = array();
        $total = 0;
        $i = 0;
        foreach ($allFiles as $file) {
            $files[] = $this->fileInfo(pathinfo(storage_path() . '/app/' . $file));
            $index = $i++;
            $total += $files[$index]['count'];
        }

        return view('backups.viewbackup', compact('files'))
                ->with('total', formatSizeUnits($total));
    }

    public function fileInfo($filePath)
    {

        $file = array();
            $file['name'] = $filePath['filename'];
            $file['extension'] = $filePath['extension'];
            $file['size'] = formatSizeUnits(filesize($filePath['dirname'] . '/' . $filePath['basename']));
            $file['count'] = filesize($filePath['dirname'] . '/' . $filePath['basename']);

        return $file;
    }

    public function totalUnit()
    {
        $allFiles = Storage::allFiles('backupDB');
        $files = array();
        $total = 0;
        $i = 0;
        foreach ($allFiles as $file) {
            $files[] = $this->fileInfo(pathinfo(storage_path() . '/app/' . $file));
            $index = $i++;
            $total += $files[$index]['count'];
        }
        
        return formatSizeUnits($total);

    }


    public function backupnow(){
        $path = storage_path('app/backupDB');
        if(!File::isDirectory($path)){
            File::makeDirectory($path, 0777, true, true);
        }
        return Artisan::call('database:backup');
    }

    function download($name){
        return Storage::disk('backupDB')->download($name.'.sql');
 
    }

    public function delete(Request $request){
        return response()->json([
            'success' => Storage::delete('backupDB/'.$request->id.'.sql'),
            'message' => $request->id,
        ]);
    }
}