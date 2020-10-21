<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SourceOfwater_Model;
use Validator;
use App\Farm_Model;
class SourceOfWater_Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getList()
    {
        $farms = Farm_Model::select('*')->orderBy('id')->get()->toArray();
        $water = SourceOfwater_Model::select('*')->orderBy('id')->paginate(5);
        return view('Water_tank.listWater_tank', compact('water', 'farms'));
    }

    public function getlistByFarm($id)
    {
        $farms = Farm_Model::select('*')->orderBy('id')->get()->toArray();
        $water = SourceOfwater_Model::select('*')->Where('farm_id','=',$id)->orderBy('id')->paginate(5);
        return view('Water_tank.listWater_tank', compact('water', 'farms'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAdd(Request $request)
    {
        $farms = Farm_Model::select('*')->orderBy('id')->get()->toArray();
        $request->user()->authorizeRoles(['admin']);
        return view('Water_tank.addWater_tank', compact('farms'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postAdd(Request $request)
    {
        $input = $request->all(); // lấy tất cả các input đầu vào
        $this->rules =[
            "name" => "required|unique:water_tanks,name",
            'volume' => 'required:fertilizers,mass'
        ];
        $validate = Validator::make($input, $this->rules);
        if($validate->fails()){
            return redirect()->back()->withErrors($validate->errors())->withInput(); // trả về view add với thông báo lỗi
        }

        $water = new SourceOfwater_Model;
        $water -> name = $request -> name;
        $water -> volume = $request -> volume;
        $water->save();
       return redirect() -> route('admin.sourceofwater.getadd') -> with(['flash_message'=>'Success!! Complete Add a Water tank!!!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getDetail($id)
    {
        $farms = Farm_Model::select('*')->orderBy('id')->get()->toArray();
        $water = SourceOfwater_Model::find($id);
        return view('Water_tank.detailWater_tank', compact('water', 'farms'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getEdit($id)
    {
        $farms = Farm_Model::select('*')->orderBy('id')->get()->toArray();
        $water = SourceOfwater_Model::find($id);
        return view('Water_tank.editWater_tank', compact('water', 'farms'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function postEdit(Request $request, $id)
    {
        $input = $request->all(); // lấy tất cả các input đầu vào
        $this->rules =[
            "name" => "required",
            'volume' => 'required'
        ];
        $validate = Validator::make($input, $this->rules);
        if($validate->fails()){
            return redirect()->back()->withErrors($validate->errors())->withInput(); // trả về view add với thông báo lỗi
        }
        $water = SourceOfwater_Model::find($id);
        $water -> name = $request -> name;
        $water -> volume = $request -> volume;
        $water->save();
       return redirect() -> route('admin.sourceofwater.getlist') -> with(['flash_message'=>'Success!! Complete Edit a Water tank!!!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getDelete(Request $request, $id)
    {
        $request->user()->authorizeRoles(['admin']);
        $fer = SourceOfwater_Modelv::find($id);
        $fer -> delete($id);
        return redirect() -> route('admin.sourceofwater.getlist') -> with(['flash_message'=>'Success!! Complete Delete a Water tank!!!']);
    }
}