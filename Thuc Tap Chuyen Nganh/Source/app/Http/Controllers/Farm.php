<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Farm_Model;
use Validator;

class Farm extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function getDetail($id)
    {
        $farms = Farm_Model::select('*')->orderBy('id')->get()->toArray(); // phục vụ cho việc load danh sách lands - load lúc đầu là ở Home_controller
        $farm = Farm_Model::find($id);
        return view('Farm.detail', compact('farm','farms'));
    }

    public function getEdit(Request $request, $id)
    {
        $farms = Farm_Model::select('*')->orderBy('id')->get()->toArray(); // phục vụ cho việc load danh sách lands - load lúc đầu là ở Home_controller
        $request->user()->authorizeRoles(['admin']);
        $farm = Farm_Model::find($id);
        return view('Farm.edit', compact('farm', 'farms'));
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
            "name.required" => "Bạn chưa nhập tên của trang trại",
            "cultivated_area" => "required",
            "cultivated_area.required" => "Bạn chưa nhập diện tích canh tác của trang trại",
            "current_month" => "required",
            "current_month.required" => "Bạn chưa nhập tháng hiện tại của trang trại",
        ];
        $validate = Validator::make($input, $this->rules);
        if($validate->fails()){

            return redirect()->back()->withErrors($validate->errors())->withInput(); // trả về view add với thông báo lỗi
        }
        $farm = Farm_Model::select('*')->Where('id','=',$id)->get();
        //dd($farm);
        foreach ($farm as $value) {
            $value['name'] = $request -> name;
            $value['cultivated_area'] = $request -> cultivated_area;
            $value['current_month'] = $request -> current_month;
            $value -> save();
        }
        return redirect() -> route('adminpage') -> with(['flash_message'=>'Cập nhật trang trại thành công!!!']);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
