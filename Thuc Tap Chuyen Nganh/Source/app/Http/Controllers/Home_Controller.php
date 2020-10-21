<?php

namespace App\Http\Controllers;
use App\Crops_Model;
use App\Farm_Model;
use Illuminate\Http\Request;
use App\Lands_Model;

class Home_Controller extends Controller 
{
	public function __construct()
   {
       $this->middleware('auth');
   }
    public function Index(Request $request)
    {	
    	$request->user()->authorizeRoles(['employee', 'admin']); // xét quyền ngươi dùng - chỉ có employee và admin được quyền truy cập trang này
       	
    	$crops = Crops_Model::select('*')->orderBy('id')->get()->toArray();
      $lands = Lands_Model::select('*')->Where('deleted','=',0)->orderBy('id','ASC')->get();
    	return view('homeindex', compact('crops', 'lands'));
    }

    public function Admin(Request $request)
    {
    	$request->user()->authorizeRoles(['admin']); // xét quyền người dùng chỉ có admin được quyền truy cập trang này.
      $farms = Farm_Model::select('*')->orderBy('id')->get()->toArray();
    	return view('admin', compact('farms'));
    }
}
