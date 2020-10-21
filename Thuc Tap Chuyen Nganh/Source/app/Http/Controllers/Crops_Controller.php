<?php
 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Crops_Model;
use App\Lands_Model;
use App\Stages_dev_Model;
use App\Climatic_Condition_Details_Model;
use App\Seasons_Details_Model;
use App\Http\Requests\Crops_Request;
use File, Input;
use App\Farm_Model;
 
class Crops_Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response 
     */
    public function getList(Request $request)
    {
        $farms = Farm_Model::select('*')->orderBy('id')->get()->toArray(); 
        $request->user()->authorizeRoles(['admin']);
        $data = Crops_Model::select('*')->orderBy('id','ASC')->get()->toArray();
        return view('Crops.listCrops', compact('data', 'farms'));
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
        return view('Crops.addCrops', compact('farms'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postAdd(Request $request)
    {
        $this -> validate($request,
                ["name" => "required",
                    "name.required" => "Bạn chưa nhập tên cây trồng",
                    'density' => 'required:crops,density',
                    'density.required' => 'Bạn chưa nhập mật độ cây trồng!',
                    'quanty_stages_dev' => "required",
                    'quanty_stages_dev.required' => 'Bạn chưa nhập tổng số giai đoạn phát triển của cây trồng!',
                ],
        );
        $file_image = $request->file('image')->getClientOriginalName();
        $crop = new Crops_Model;
        $crop -> name = $request -> name;
        $crop -> density = $request -> density;
        $crop -> description = $request -> description;
        $crop -> image = $file_image;
        $crop -> ph_from = $request -> ph_from;
        $crop -> ph_to = $request -> ph_to;
        $crop -> quantity_max_stages_dev = $request -> quanty_stages_dev;
        
        $request->file('image')->move('resources/upload/', $file_image);
        $crop->save();
        $crop_id = $crop-> id; // phục vụ cho việc lưu nhiều giai đoạn phát triển
        // kiểm tra người dùng có insert các giai đoạn vào thêm không, nếu có thì lưu, không thì thôi
        // Nếu có giai đoạn 1
        if($request -> input('stage.0')){
            $stage_0 = $request -> input('stage.0');
            $nameStage = $stage_0['nameStage'];
            $starday = $stage_0['starday'];
            $endday = $stage_0['endday'];
            $fertilizer_needed =  $stage_0['fertilizer_needed'];
            $mass_fertilizer_needed = $stage_0['mass_fertilizer_needed'];
            $volume_water_needed =  $stage_0['volume_water_needed'];
            $description = $stage_0['description'];
            $suitable_light = $stage_0['suitable_light'];
            $suitable_temperature_from = $stage_0['suitable_temperature_from'];
            $suitable_temperature_to = $stage_0['suitable_temperature_to'];
            $suitable_ph_from = $stage_0['suitable_ph_from'];
            $suitable_ph_to = $stage_0['suitable_ph_to'];
            $suitable_humidity_from = $stage_0['suitable_humidity_from'];
            $suitable_humidity_to = $stage_0['suitable_humidity_to'];

            $stages_crop = new Stages_dev_Model;
            $stages_crop -> numerical_order = 1;
            $stages_crop -> name = $nameStage;
            $stages_crop -> start_day = $starday;
            $stages_crop -> end_day = $endday;
            $stages_crop -> fertilizer = $fertilizer_needed;
            $stages_crop -> fertilizer_mass = $mass_fertilizer_needed;
            $stages_crop -> water_volume = $volume_water_needed;
            $stages_crop -> crop_id = $crop_id;
            $stages_crop -> description = $description;
            $stages_crop -> suitable_light = $suitable_light;
            $stages_crop -> suitable_temperature_from = $suitable_temperature_from;
            $stages_crop -> suitable_temperature_to = $suitable_temperature_to;
            $stages_crop -> suitable_ph_from = $suitable_ph_from;
            $stages_crop -> suitable_ph_to = $suitable_ph_to;
            $stages_crop -> suitable_humidity_from = $suitable_humidity_from;
            $stages_crop -> suitable_humidity_to = $suitable_humidity_to;
            $stages_crop -> save();
        }
        // Nếu có giai đoạn 2
        if($request -> input('stage.1')){
            $stage_1 = $request -> input('stage.1');
            $nameStage = $stage_1['nameStage'];
            $starday = $stage_1['starday'];
            $endday = $stage_1['endday'];
            $fertilizer_needed =  $stage_1['fertilizer_needed'];
            $mass_fertilizer_needed = $stage_1['mass_fertilizer_needed'];
            $volume_water_needed =  $stage_1['volume_water_needed'];
            $description = $stage_1['description'];
            $suitable_light = $stage_1['suitable_light'];
            $suitable_temperature_from = $stage_1['suitable_temperature_from'];
            $suitable_temperature_to = $stage_1['suitable_temperature_to'];
            $suitable_ph_from = $stage_1['suitable_ph_from'];
            $suitable_ph_to = $stage_1['suitable_ph_to'];
            $suitable_humidity_from = $stage_1['suitable_humidity_from'];
            $suitable_humidity_to = $stage_1['suitable_humidity_to'];

            $stages_crop_1 = new Stages_dev_Model;
            $stages_crop_1 -> numerical_order = 2;
            $stages_crop_1 -> name = $nameStage;
            $stages_crop_1 -> start_day = $starday;
            $stages_crop_1 -> end_day = $endday;
            $stages_crop_1 -> fertilizer = $fertilizer_needed;
            $stages_crop_1 -> fertilizer_mass = $mass_fertilizer_needed;
            $stages_crop_1 -> water_volume = $volume_water_needed;
            $stages_crop_1 -> crop_id = $crop_id;
            $stages_crop_1 -> description = $description;
            $stages_crop_1 -> suitable_light = $suitable_light;
            $stages_crop_1 -> suitable_temperature_from = $suitable_temperature_from;
            $stages_crop_1 -> suitable_temperature_to = $suitable_temperature_to;
            $stages_crop_1 -> suitable_ph_from = $suitable_ph_from;
            $stages_crop_1 -> suitable_ph_to = $suitable_ph_to;
            $stages_crop_1 -> suitable_humidity_from = $suitable_humidity_from;
            $stages_crop_1 -> suitable_humidity_to = $suitable_humidity_to;
            $stages_crop_1 -> save();
        }
        // Nếu có giai đoạn 3
        if($request -> input('stage.2')){
            $stage_2 = $request -> input('stage.2');
            $nameStage = $stage_2['nameStage'];
            $starday = $stage_2['starday'];
            $endday = $stage_2['endday'];
            $fertilizer_needed =  $stage_2['fertilizer_needed'];
            $mass_fertilizer_needed = $stage_2['mass_fertilizer_needed'];
            $volume_water_needed =  $stage_2['volume_water_needed'];
            $description = $stage_2['description'];
            $suitable_light = $stage_2['suitable_light'];
            $suitable_temperature_from = $stage_2['suitable_temperature_from'];
            $suitable_temperature_to = $stage_2['suitable_temperature_to'];
            $suitable_ph_from = $stage_2['suitable_ph_from'];
            $suitable_ph_to = $stage_2['suitable_ph_to'];
            $suitable_humidity_from = $stage_2['suitable_humidity_from'];
            $suitable_humidity_to = $stage_2['suitable_humidity_to'];

            $stages_crop_2 = new Stages_dev_Model;
            $stages_crop_2 -> numerical_order = 3;
            $stages_crop_2 -> name = $nameStage;
            $stages_crop_2 -> start_day = $starday;
            $stages_crop_2 -> end_day = $endday;
            $stages_crop_2 -> fertilizer = $fertilizer_needed;
            $stages_crop_2 -> fertilizer_mass = $mass_fertilizer_needed;
            $stages_crop_2 -> water_volume = $volume_water_needed;
            $stages_crop_2 -> crop_id = $crop_id;
            $stages_crop_2 -> description = $description;
            $stages_crop_2 -> suitable_light = $suitable_light;
            $stages_crop_2 -> suitable_temperature_from = $suitable_temperature_from;
            $stages_crop_2 -> suitable_temperature_to = $suitable_temperature_to;
            $stages_crop_2 -> suitable_ph_from = $suitable_ph_from;
            $stages_crop_2 -> suitable_ph_to = $suitable_ph_to;
            $stages_crop_2 -> suitable_humidity_from = $suitable_humidity_from;
            $stages_crop_2 -> suitable_humidity_to = $suitable_humidity_to;
            $stages_crop_2 -> save();
        }
        // Nếu có giai đoạn 4
        if($request -> input('stage.3')){
            $stage_3 = $request -> input('stage.3');
            $nameStage = $stage_3['nameStage'];
            $starday = $stage_3['starday'];
            $endday = $stage_3['endday'];
            $fertilizer_needed =  $stage_3['fertilizer_needed'];
            $mass_fertilizer_needed = $stage_3['mass_fertilizer_needed'];
            $volume_water_needed =  $stage_3['volume_water_needed'];
            $description = $stage_3['description'];
            $suitable_light = $stage_3['suitable_light'];
            $suitable_temperature_from = $stage_3['suitable_temperature_from'];
            $suitable_temperature_to = $stage_3['suitable_temperature_to'];
            $suitable_ph_from = $stage_3['suitable_ph_from'];
            $suitable_ph_to = $stage_3['suitable_ph_to'];
            $suitable_humidity_from = $stage_3['suitable_humidity_from'];
            $suitable_humidity_to = $stage_3['suitable_humidity_to'];

            $stages_crop_3 = new Stages_dev_Model;
            $stages_crop_3 -> numerical_order = 4;
            $stages_crop_3 -> name = $nameStage;
            $stages_crop_3 -> start_day = $starday;
            $stages_crop_3 -> end_day = $endday;
            $stages_crop_3 -> fertilizer = $fertilizer_needed;
            $stages_crop_3 -> fertilizer_mass = $mass_fertilizer_needed;
            $stages_crop_3 -> water_volume = $volume_water_needed;
            $stages_crop_3 -> crop_id = $crop_id;
            $stages_crop_3 -> description = $description;
            $stages_crop_3 -> suitable_light = $suitable_light;
            $stages_crop_3 -> suitable_temperature_from = $suitable_temperature_from;
            $stages_crop_3 -> suitable_temperature_to = $suitable_temperature_to;
            $stages_crop_3 -> suitable_ph_from = $suitable_ph_from;
            $stages_crop_3 -> suitable_ph_to = $suitable_ph_to;
            $stages_crop_3 -> suitable_humidity_from = $suitable_humidity_from;
            $stages_crop_3 -> suitable_humidity_to = $suitable_humidity_to;
            $stages_crop_3 -> save();
        }
        // Nếu có giai đoạn 5
        if($request -> input('stage.4')){
            $stage_4 = $request -> input('stage.4');
            $nameStage = $stage_4['nameStage'];
            $starday = $stage_4['starday'];
            $endday = $stage_4['endday'];
            $fertilizer_needed =  $stage_4['fertilizer_needed'];
            $mass_fertilizer_needed = $stage_4['mass_fertilizer_needed'];
            $volume_water_needed =  $stage_4['volume_water_needed'];
            $description = $stage_4['description'];
            $suitable_light = $stage_4['suitable_light'];
            $suitable_temperature_from = $stage_4['suitable_temperature_from'];
            $suitable_temperature_to = $stage_4['suitable_temperature_to'];
            $suitable_ph_from = $stage_4['suitable_ph_from'];
            $suitable_ph_to = $stage_4['suitable_ph_to'];
            $suitable_humidity_from = $stage_4['suitable_humidity_from'];
            $suitable_humidity_to = $stage_4['suitable_humidity_to'];

            $stages_crop_4 = new Stages_dev_Model;
            $stages_crop_4 -> numerical_order = 5;
            $stages_crop_4 -> name = $nameStage;
            $stages_crop_4 -> start_day = $starday;
            $stages_crop_4 -> end_day = $endday;
            $stages_crop_4 -> fertilizer = $fertilizer_needed;
            $stages_crop_4 -> fertilizer_mass = $mass_fertilizer_needed;
            $stages_crop_4 -> water_volume = $volume_water_needed;
            $stages_crop_4 -> crop_id = $crop_id;
            $stages_crop_4 -> description = $description;
            $stages_crop_4 -> suitable_light = $suitable_light;
            $stages_crop_4 -> suitable_temperature_from = $suitable_temperature_from;
            $stages_crop_4 -> suitable_temperature_to = $suitable_temperature_to;
            $stages_crop_4 -> suitable_ph_from = $suitable_ph_from;
            $stages_crop_4 -> suitable_ph_to = $suitable_ph_to;
            $stages_crop_4 -> suitable_humidity_from = $suitable_humidity_from;
            $stages_crop_4 -> suitable_humidity_to = $suitable_humidity_to;
            $stages_crop_4 -> save();
        }
        
        return redirect() -> route('admin.crops.getadd') -> with(['flash_message'=>'Thêm cây trồng thành công!!!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getDetail(Request $request, $id)
    {
        $farms = Farm_Model::select('*')->orderBy('id')->get()->toArray(); 
        $request->user()->authorizeRoles(['employee','admin']);
        $crop = Crops_Model::select('*')->Where('id','=',$id)->get()->toArray();
        $stages_dev = Stages_dev_Model::select('*')->Where('crop_id','=',$id)->orderBy('numerical_order')->get()->toArray();
        return view('Crops.detail', compact('crop','stages_dev', 'farms'));
        
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
        $crop = Crops_Model::select('*')->Where('id','=',$id)->get()->toArray();
        $stages_dev = Stages_dev_Model::select('*')->Where('crop_id','=',$id)->orderBy('numerical_order')->get()->toArray();
        
        return view('Crops.editCrops', compact('crop','stages_dev', 'farms'));
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
        $this -> validate($request,
                ["name" => "required",
                    "name.required" => "Bạn chưa nhập tên cây trồng",
                    'density' => 'required:crops,density',
                    'density.required' => 'Bạn chưa nhập mật độ cây trồng!',
                    'quanty_stages_dev' => "required",
                    'quanty_stages_dev.required' => 'Bạn chưa nhập tổng số giai đoạn phát triển của cây trồng!',
                ],
        );
        $crop = Crops_Model::find($id);
        $img_current = 'resources/upload/'.$request->img_old; // ảnh cũ
        if(!empty($request->file('image'))){ // nếu thay ảnh mới
            $file_image = $request->file('image')->getClientOriginalName(); // ảnh mới

            
            $crop -> image = $file_image;
            $request->file('image')->move('resources/upload/', $file_image);
            if(File::exists($img_current)){
                File::delete($img_current);
            }
        }
        else {
            $file_image = $request-> img_old; // nếu giữ lại ảnh cũ
            $crop -> image = $file_image;
            //$request->file('image')->move('resources/upload/', $file_image);
        }
        
        
        $crop -> name = $request -> name;
        $crop -> density = $request -> density;
        $crop -> description = $request -> description;
        $crop -> ph_from = $request -> ph_from;
        $crop -> ph_to = $request -> ph_to;
        $crop -> quantity_max_stages_dev = $request -> quanty_stages_dev;
        
        $crop->save();
        $crop_id = $crop-> id; // phục vụ cho việc lưu nhiều giai đoạn phát triển
        // kiểm tra người dùng có insert các giai đoạn vào thêm không, nếu có thì lưu, không thì thôi
        // Nếu có giai đoạn 1
        if($request -> input('stage.0')){
            $stage_0 = $request -> input('stage.0');
            $nameStage = $stage_0['nameStage'];
            $starday = $stage_0['starday'];
            $endday = $stage_0['endday'];
            $fertilizer_needed =  $stage_0['fertilizer_needed'];
            $mass_fertilizer_needed = $stage_0['mass_fertilizer_needed'];
            $volume_water_needed =  $stage_0['volume_water_needed'];
            $description = $stage_0['description'];

            $suitable_light = $stage_0['suitable_light'];
            $suitable_temperature_from = $stage_0['suitable_temperature_from'];
            $suitable_temperature_to = $stage_0['suitable_temperature_to'];
            $suitable_ph_from = $stage_0['suitable_ph_from'];
            $suitable_ph_to = $stage_0['suitable_ph_to'];
            $suitable_humidity_from = $stage_0['suitable_humidity_from'];
            $suitable_humidity_to = $stage_0['suitable_humidity_to'];

            $stages_crop_old = Stages_dev_Model::select('*')->Where('crop_id','=',$id)->Where('numerical_order','=','1')->delete(); // truy xuất và xóa giai đoạn 1
             //***** Ở đây gặp phải vấn đề về lưu dữ liệu xuống model với dạng mảng, nên ta sẽ tìm và xóa cái record cũ đi thêm vào cái record mới
            $stages_crop = new Stages_dev_Model;
            $stages_crop -> numerical_order = 1;
            $stages_crop -> name = $nameStage;
            $stages_crop -> start_day = $starday;
            $stages_crop -> end_day = $endday;
            $stages_crop -> fertilizer = $fertilizer_needed;
            $stages_crop -> fertilizer_mass = $mass_fertilizer_needed;
            $stages_crop -> water_volume = $volume_water_needed;
            $stages_crop -> crop_id = $crop_id;
            $stages_crop -> description = $description;
            $stages_crop -> suitable_light = $suitable_light;
            $stages_crop -> suitable_temperature_from = $suitable_temperature_from;
            $stages_crop -> suitable_temperature_to = $suitable_temperature_to;
            $stages_crop -> suitable_ph_from = $suitable_ph_from;
            $stages_crop -> suitable_ph_to = $suitable_ph_to;
            $stages_crop -> suitable_humidity_from = $suitable_humidity_from;
            $stages_crop -> suitable_humidity_to = $suitable_humidity_to;
            $stages_crop -> save();
        }
        //Nếu có giai đoạn 2
        if($request -> input('stage.1')){
            $stage_1 = $request -> input('stage.1');
            $nameStage = $stage_1['nameStage'];
            $starday = $stage_1['starday'];
            $endday = $stage_1['endday'];
            $fertilizer_needed =  $stage_1['fertilizer_needed'];
            $mass_fertilizer_needed = $stage_1['mass_fertilizer_needed'];
            $volume_water_needed =  $stage_1['volume_water_needed'];
            $description = $stage_1['description'];
            $suitable_light = $stage_1['suitable_light'];
            $suitable_temperature_from = $stage_1['suitable_temperature_from'];
            $suitable_temperature_to = $stage_1['suitable_temperature_to'];
            $suitable_ph_from = $stage_1['suitable_ph_from'];
            $suitable_ph_to = $stage_1['suitable_ph_to'];
            $suitable_humidity_from = $stage_1['suitable_humidity_from'];
            $suitable_humidity_to = $stage_1['suitable_humidity_to'];

            $stages_crop_1_old = Stages_dev_Model::select('*')->Where('crop_id','=',$id)->Where('numerical_order','=','2')->delete(); // truy xuất và xóa giai đoạn 2
            $stages_crop_1 = new Stages_dev_Model;
            $stages_crop_1 -> numerical_order = 2;
            $stages_crop_1 -> name = $nameStage;
            $stages_crop_1 -> start_day = $starday;
            $stages_crop_1 -> end_day = $endday;
            $stages_crop_1 -> fertilizer = $fertilizer_needed;
            $stages_crop_1 -> fertilizer_mass = $mass_fertilizer_needed;
            $stages_crop_1 -> water_volume = $volume_water_needed;
            $stages_crop_1 -> crop_id = $crop_id;
            $stages_crop_1 -> description = $description;
            $stages_crop_1 -> suitable_light = $suitable_light;
            $stages_crop_1 -> suitable_temperature_from = $suitable_temperature_from;
            $stages_crop_1 -> suitable_temperature_to = $suitable_temperature_to;
            $stages_crop_1 -> suitable_ph_from = $suitable_ph_from;
            $stages_crop_1 -> suitable_ph_to = $suitable_ph_to;
            $stages_crop_1 -> suitable_humidity_from = $suitable_humidity_from;
            $stages_crop_1 -> suitable_humidity_to = $suitable_humidity_to;
            $stages_crop_1 -> save();
        }
        // Nếu có giai đoạn 3
        if($request -> input('stage.2')){
            $stage_2 = $request -> input('stage.2');
            $nameStage = $stage_2['nameStage'];
            $starday = $stage_2['starday'];
            $endday = $stage_2['endday'];
            $fertilizer_needed =  $stage_2['fertilizer_needed'];
            $mass_fertilizer_needed = $stage_2['mass_fertilizer_needed'];
            $volume_water_needed =  $stage_2['volume_water_needed'];
            $description = $stage_2['description'];
            $suitable_light = $stage_2['suitable_light'];
            $suitable_temperature_from = $stage_2['suitable_temperature_from'];
            $suitable_temperature_to = $stage_2['suitable_temperature_to'];
            $suitable_ph_from = $stage_2['suitable_ph_from'];
            $suitable_ph_to = $stage_2['suitable_ph_to'];
            $suitable_humidity_from = $stage_2['suitable_humidity_from'];
            $suitable_humidity_to = $stage_2['suitable_humidity_to'];

            $stages_crop_2_old = Stages_dev_Model::select('*')->Where('crop_id','=',$id)->Where('numerical_order','=','3')->delete(); // truy xuất và xóa giai đoạn 3
            $stages_crop_2 = new Stages_dev_Model;
            $stages_crop_2 -> numerical_order = 3;
            $stages_crop_2 -> name = $nameStage;
            $stages_crop_2 -> start_day = $starday;
            $stages_crop_2 -> end_day = $endday;
            $stages_crop_2 -> fertilizer = $fertilizer_needed;
            $stages_crop_2 -> fertilizer_mass = $mass_fertilizer_needed;
            $stages_crop_2 -> water_volume = $volume_water_needed;
            $stages_crop_2 -> crop_id = $crop_id;
            $stages_crop_2 -> description = $description;
            $stages_crop_2 -> suitable_light = $suitable_light;
            $stages_crop_2 -> suitable_temperature_from = $suitable_temperature_from;
            $stages_crop_2 -> suitable_temperature_to = $suitable_temperature_to;
            $stages_crop_2 -> suitable_ph_from = $suitable_ph_from;
            $stages_crop_2 -> suitable_ph_to = $suitable_ph_to;
            $stages_crop_2 -> suitable_humidity_from = $suitable_humidity_from;
            $stages_crop_2 -> suitable_humidity_to = $suitable_humidity_to;
            $stages_crop_2 -> save();
        }
        // Nếu có giai đoạn 4
        if($request -> input('stage.3')){
            $stage_3 = $request -> input('stage.3');
            $nameStage = $stage_3['nameStage'];
            $starday = $stage_3['starday'];
            $endday = $stage_3['endday'];
            $fertilizer_needed =  $stage_3['fertilizer_needed'];
            $mass_fertilizer_needed = $stage_3['mass_fertilizer_needed'];
            $volume_water_needed =  $stage_3['volume_water_needed'];
            $description = $stage_3['description'];
            $suitable_light = $stage_3['suitable_light'];
            $suitable_temperature_from = $stage_3['suitable_temperature_from'];
            $suitable_temperature_to = $stage_3['suitable_temperature_to'];
            $suitable_ph_from = $stage_3['suitable_ph_from'];
            $suitable_ph_to = $stage_3['suitable_ph_to'];
            $suitable_humidity_from = $stage_3['suitable_humidity_from'];
            $suitable_humidity_to = $stage_3['suitable_humidity_to'];

            $stages_crop_3_old = Stages_dev_Model::select('*')->Where('crop_id','=',$id)->Where('numerical_order','=','4')->delete(); // truy xuất và xóa giai đoạn 2
            $stages_crop_3 = new Stages_dev_Model;
            $stages_crop_3 -> numerical_order = 4;
            $stages_crop_3 -> name = $nameStage;
            $stages_crop_3 -> start_day = $starday;
            $stages_crop_3 -> end_day = $endday;
            $stages_crop_3 -> fertilizer = $fertilizer_needed;
            $stages_crop_3 -> fertilizer_mass = $mass_fertilizer_needed;
            $stages_crop_3 -> water_volume = $volume_water_needed;
            $stages_crop_3 -> crop_id = $crop_id;
            $stages_crop_3 -> description = $description;
            $stages_crop_3 -> suitable_light = $suitable_light;
            $stages_crop_3 -> suitable_temperature_from = $suitable_temperature_from;
            $stages_crop_3 -> suitable_temperature_to = $suitable_temperature_to;
            $stages_crop_3 -> suitable_ph_from = $suitable_ph_from;
            $stages_crop_3 -> suitable_ph_to = $suitable_ph_to;
            $stages_crop_3 -> suitable_humidity_from = $suitable_humidity_from;
            $stages_crop_3 -> suitable_humidity_to = $suitable_humidity_to;
            $stages_crop_3 -> save();
        }
        // Nếu có giai đoạn 5
        if($request -> input('stage.4')){
            $stage_4 = $request -> input('stage.4');
            $nameStage = $stage_4['nameStage'];
            $starday = $stage_4['starday'];
            $endday = $stage_4['endday'];
            $fertilizer_needed =  $stage_4['fertilizer_needed'];
            $mass_fertilizer_needed = $stage_4['mass_fertilizer_needed'];
            $volume_water_needed =  $stage_4['volume_water_needed'];
            $description = $stage_4['description'];
            $suitable_light = $stage_4['suitable_light'];
            $suitable_temperature_from = $stage_4['suitable_temperature_from'];
            $suitable_temperature_to = $stage_4['suitable_temperature_to'];
            $suitable_ph_from = $stage_4['suitable_ph_from'];
            $suitable_ph_to = $stage_4['suitable_ph_to'];
            $suitable_humidity_from = $stage_4['suitable_humidity_from'];
            $suitable_humidity_to = $stage_4['suitable_humidity_to'];

            $stages_crop_4_old = Stages_dev_Model::select('*')->Where('crop_id','=',$id)->Where('numerical_order','=','5')->delete(); // truy xuất và xóa giai đoạn 2
            $stages_crop_4 = new Stages_dev_Model;
            $stages_crop_4 -> numerical_order = 5;
            $stages_crop_4 -> name = $nameStage;
            $stages_crop_4 -> start_day = $starday;
            $stages_crop_4 -> end_day = $endday;
            $stages_crop_4 -> fertilizer = $fertilizer_needed;
            $stages_crop_4 -> fertilizer_mass = $mass_fertilizer_needed;
            $stages_crop_4 -> water_volume = $volume_water_needed;
            $stages_crop_4 -> crop_id = $crop_id;
            $stages_crop_4 -> description = $description;
            $stages_crop_4 -> suitable_light = $suitable_light;
            $stages_crop_4 -> suitable_temperature_from = $suitable_temperature_from;
            $stages_crop_4 -> suitable_temperature_to = $suitable_temperature_to;
            $stages_crop_4 -> suitable_ph_from = $suitable_ph_from;
            $stages_crop_4 -> suitable_ph_to = $suitable_ph_to;
            $stages_crop_4 -> suitable_humidity_from = $suitable_humidity_from;
            $stages_crop_4 -> suitable_humidity_to = $suitable_humidity_to;
            $stages_crop_4 -> save();
        }
        return redirect() -> route('admin.crops.getadd') -> with(['flash_message'=>'Cập nhật cây trồng thành công!!!']);
    }
    public function postSearch(Request $request)
    {
        $keyword = $request->input('keyword');
        $crops = Crops_Model::select('*')->Where('name','LIKE', '%' . $keyword . '%')->get()->toArray();
        $lands = Lands_Model::select('*')->Where('name','LIKE', '%' . $keyword . '%')->get()->toArray();
        return view('Crops.search', compact('crops','lands'));
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
        $crop = Crops_Model::find($id);
        $crop -> delete($id);
        // không cần xóa record bảng giai đoạn Pt, khi xóa crop thì các giai đoạn pt của crop đó cũng bị xóa
        return redirect() -> route('admin.crops.getlist') -> with(['flash_message'=>'Xóa cây trồng thành công!!!']);
    }
}
