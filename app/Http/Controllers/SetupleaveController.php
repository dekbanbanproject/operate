<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Leavefunction;

class SetupleaveController extends Controller
{
    public function infofunction()
    {
       

        $infoleavefunction = DB::table('gleave_function')->get();

       //dd($infoorg);
        return view('admin.setupleavefunction',[
            'infoleavefunctions' =>$infoleavefunction 
        ]);
    }



    function switchactive(Request $request)
    {  
        //return $request->all(); 
        $id = $request->idfunc;
        $active = Leavefunction::find($id);
        $active->ACTIVE = $request->onoff;
        $active->save();
    }

}
