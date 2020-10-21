<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Fertilizers_Model;
use App\Type_Fertilizers_Model;
use Validator;
use App\Farm_Model;
class Fertilizers_Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getList(Request $request)
    {
        $farms = Farm_Model::select('*')->orderBy('id')->get()->toArray(); 
        $request->user()->authorizeRoles(['employee','admin']);
        $type_fer = Type_Fertilizers_Model::select('*')->orderBy('id')->get()->toArray();
        $fer = Fertilizers_Model::select('*')->orderBy('id')->paginate(5);
        return view('Fertilizers.listFeryilizers', compact('type_fer','fer', 'farms'));
    }

    public function getlistByFarm($id)
    {
        $farms = Farm_Model::select('*')->orderBy('id')->get()->toArray(); 
        $type_fer = Type_Fertilizers_Model::select('*')->orderBy('id')->get()->toArray();
        $fer = Fertilizers_Model::select('*')->Where('farm_id','=',$id)->orderBy('id')->paginate(5);
        return view('Fertilizers.listFeryilizers', compact('type_fer','fer', 'farms'));
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
        $type_fer = Type_Fertilizers_Model::select('*')->orderBy('id','DESC')->get()->toArray();
        return view('Fertilizers.addFeryilizers', compact('type_fer','farms'));
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
            "name" => "required:fertilizers,name",
            'mass' => 'required:fertilizers,mass'
        ];
        $validate = Validator::make($input, $this->rules);
        if($validate->fails()){

            return redirect()->back()->withErrors($validate->errors())->withInput(); // trả về view add với thông báo lỗi
        }
        
        $sltType = $request->input('sltType');
        if($sltType == -1){
            $validate->errors()->add('sltType', 'Bạn hãy chọn loại của phân bón !!');
            return redirect()->back()->withErrors($validate->errors())->withInput(); // trả về view add với thông báo lỗi
        }

        $fer = new Fertilizers_Model;
        $fer -> name = $request -> name;
        $fer -> mass = $request -> mass;
        $fer -> type_fertilizer_id = $request -> sltType;
        if($request -> mass30){
            $fer -> mass_suiable_30_m = $request -> mass30;
        }
        if($request -> time){
            $fer -> effective_time = $request -> time;
        }
        $fer->save();
       return redirect() -> route('admin.fertilizers.getadd') -> with(['flash_message'=>'Thêm phân bón thành công!!!']);
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
        $fer = Fertilizers_Model::find($id);
        $type_fer = Type_Fertilizers_Model::select('*')->get()->toArray();
        return view('Fertilizers.detailFeryilizers', compact('fer','type_fer', 'farms'));
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
        $fer = Fertilizers_Model::find($id);
        $type_fer = Type_Fertilizers_Model::select('*')->get()->toArray();
        return view('Fertilizers.editFeryilizers', compact('fer','type_fer', 'farms'));
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
        $fer -> mass_suiable_30_m = $request -> mass30;
        $fer -> effective_time = $request -> time;
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