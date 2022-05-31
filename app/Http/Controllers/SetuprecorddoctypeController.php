<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Recorddoctype;

class SetuprecorddoctypeController extends Controller
{
    public function inforecorddoctype()
    {
       
        $infodoctype = Recorddoctype::orderBy('RECODE_DOCTYPE_ID', 'asc')  
                                     ->get();

       //dd($infoeducation);
        return view('admin_develop.setupdoctype',[
            'infodoctypes' => $infodoctype 
        ]);
    }

    public function create(Request $request)
    {
       //dd($infoeducation);
        return view('admin_develop.setupdoctype_add');

    }

    public function save(Request $request)
    {

            $adddoctype = new Recorddoctype(); 
          
            $adddoctype->RECODE_DOCTYPE_NAME = $request->RECODE_DOCTYPE_NAME;
 
            $adddoctype->save();


            return redirect()->route('setup.indexdoctype'); 
    }

    public function edit(Request $request,$id)
    {
    //return $request->all();

   $id_in= $request->id;
 
   $infodoctype = Recorddoctype::where('RECODE_DOCTYPE_ID','=',$id_in)
   ->first();


   return view('admin_develop.setupdoctype_edit',[
    'infodoctype' => $infodoctype 
]);
    }

    public function update(Request $request)
    {
        $id = $request->RECODE_DOCTYPE_ID; 

        $updatedoctype = Recorddoctype::find($id);
        $updatedoctype->RECODE_DOCTYPE_NAME = $request->RECODE_DOCTYPE_NAME;
       
        $updatedoctype->save();
        
        
            return redirect()->route('setup.indexdoctype'); 
    }

    
    public function destroy($id) { 
                
        Recorddoctype::destroy($id);         
        //return redirect()->action('ChangenameController@infouserchangename');  
        return redirect()->route('setup.indexdoctype');   
    }
}
