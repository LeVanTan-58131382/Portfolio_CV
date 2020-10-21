<?php

namespace App\Http\Controllers;
use App\Crops_Model;
use App\Seasons_Model;
use Illuminate\Http\Request;
use App\Farm_Model;

class Seasons_Controller extends Controller 
{
    public function getList(Request $request)
    {
        $farms = Farm_Model::select('*')->orderBy('id')->get()->toArray(); 
        $request->user()->authorizeRoles(['employee','admin']);
        $seasons = Seasons_Model::select('*')->orderBy('id')->paginate(6);;
        $crop = Crops_Model::select('*')->orderBy('id')->get()->toArray();
        return view('Seasons.listSeason', compact('seasons', 'crop', 'farms'));
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
        $crop = Crops_Model::select('*')->orderBy('id','ASC')->get()->toArray();
        return view('Seasons.addSeason', compact('crop','farms'));
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
            "name" => "required",
            'description' => 'required',
            'start_month_planting' => 'required',
            'end_month_planting' => 'required',
        ];
        $validate = Validator::make($input, $this->rules);
        if($validate->fails()){

            return redirect()->back()->withErrors($validate->errors())->withInput(); // trả về view add với thông báo lỗi
        }
        
        $sltType = $request->input('sltType');
        if($sltType == -1){
            $validate->errors()->add('sltType', 'Bạn hãy chọn loại cây trồng !!');
            return redirect()->back()->withErrors($validate->errors())->withInput(); // trả về view add với thông báo lỗi
        }

        $season = new Seasons_Model;
        $season -> name = $request -> name;
        $season -> description = $request -> description;
        $season -> start_month_planting = $request -> start_month_planting;
        $season -> end_month_planting = $request -> end_month_planting;
        $season -> crop_id = $request -> sltType;
        $season->save();
       return redirect() -> route('admin.seasons.getadd') -> with(['flash_message'=>'Thêm mùa vụ thành công!!!']);
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
        $season = Seasons_Model::find($id);
        $crop = Crops_Model::select('*')->orderBy('id','ASC')->get()->toArray();
        return view('Seasons.detailSeason', compact('season','crop', 'farms'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getEdit(Request $request, $id)
    {
        $farms = Farm_Model::select('*')->orderBy('id')->get()->toArray(); 
        $request->user()->authorizeRoles(['admin']);
        $season = Seasons_Model::find($id);
        $crops = Crops_Model::select('*')->orderBy('id','ASC')->get()->toArray();
        return view('Seasons.editSeason', compact('crops','season', 'farms'));
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
            "name" => "required:fertilizers,name",
            'mass' => 'required:fertilizers,mass'
        ];
        $validate = Validator::make($input, $this->rules);
        if($validate->fails()){

            return redirect()->back()->withErrors($validate->errors())->withInput(); // trả về view add với thông báo lỗi
        }
        $fer = Fertilizers_Model::find($id);
        $fer -> name = $request -> name;
        $fer -> mass = $request -> mass;
        $fer -> type_fertilizer_id = $request -> sltType;
        $fer->save();
       return redirect() -> route('admin.fertilizers.getlist') -> with(['flash_message'=>'Cập nhật phân bón thành công!!!']);
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
        $fer = Fertilizers_Model::find($id);
        $fer -> delete($id);
        // không cần xóa record bảng giai đoạn Pt, khi xóa crop thì các giai đoạn pt của crop đó cũng bị xóa
        return redirect() -> route('admin.fertilizers.getlist') -> with(['flash_message'=>'Xóa phân bón thành công!!!']);
    }
}
