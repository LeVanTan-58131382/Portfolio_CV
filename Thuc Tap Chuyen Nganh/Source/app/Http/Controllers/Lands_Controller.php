<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Crops_Model;
use App\Lands_Model;
use App\Weather_Conditions_Model;
use App\Stages_dev_Model;
use App\SourceOfwater_Model;
use App\Watering_Details_Model;
use App\Fertilizers_Model;
use App\Fertilizer_Details_Model;
use App\Follow_Model;
use App\Method_watering_Model;
use App\Follow_fer_Model;
use Validator;
use Auth;
use App\Farm_Model;

class Lands_Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     *///->paginate(5)
    public function getList()
    {
        $farms = Farm_Model::select('*')->orderBy('id')->get()->toArray();
        $crops = Crops_Model::select('*')->orderBy('id','ASC')->get()->toArray();
        $lands = Lands_Model::select('*')->Where('deleted','=',0)->orderBy('id','ASC')->paginate(5);
        $weather = Weather_Conditions_Model::select('*')->orderBy('id','ASC')->get()->toArray();
        $stage = Stages_dev_Model::select('*')->get();
        $follow_fer = Follow_fer_Model::select('*')->get();

        // lấy chi tiết bón các loại phụ gia tăng hoặc giảm độ ph
        $fer_detail = Fertilizer_Details_Model::select('*')->get();
        // lấy các loại phân
        $fer = Fertilizers_Model::select('*')->get();

        return view('Lands.listLands', compact('lands','crops','weather','stage', 'farms','follow_fer', 'fer_detail', 'fer'));
    }

    public function getlistByFarm($id)
    {
        $farms = Farm_Model::select('*')->orderBy('id')->get()->toArray();
        $crops = Crops_Model::select('*')->orderBy('id','ASC')->get()->toArray();
        $lands = Lands_Model::select('*')->Where('deleted','=',0)->Where('farm_id','=',$id)->orderBy('id','ASC')->paginate(5);
        $weather = Weather_Conditions_Model::select('*')->orderBy('id','ASC')->get()->toArray();//->lastInsertId();
        $stage = Stages_dev_Model::select('*')->orderBy('numerical_order','DESC')->get();
        return view('Lands.listLands', compact('lands','crops','weather','stage', 'farms'));
    }

    public function getlistHarvestHarvest()
    {
        $farms = Farm_Model::select('*')->orderBy('id')->get()->toArray();
        $harvest = Follow_Model::select('*')->orderBy('id','ASC')->get()->toArray();
        $lands = Lands_Model::select('*')->Where('deleted','=',0)->orderBy('id','ASC')->get()->toArray();
        // lấy ra số lần tưới nước và số lần bón phân
        $number_war = Watering_Details_Model::select('*');
        $number_fer = Fertilizer_Details_Model::select('*');
        return view('Lands.harvest_statistical', compact('harvest','lands', 'farms'));
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
        $crops = Crops_Model::select('*')->orderBy('id','ASC')->get()->toArray();
        return view('Lands.addLands', compact('crops', 'farms'));
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
            "name" => "required|unique:lands,name",
            'square' => 'required',
            'quanty_crops' => 'required'
        ];
        $validate = Validator::make($input, $this->rules);
        if($validate->fails()){

            return redirect()->back()->withErrors($validate->errors())->withInput(); // trả về view add với thông báo lỗi
        }

        $sltType = $request->input('sltType');
        if($sltType == -1){
            $validate->errors()->add('sltType', 'Bạn hãy chọn một loại cây trồng!!!');
            return redirect()->back()->withErrors($validate->errors())->withInput(); // trả về view add với thông báo lỗi
        }

        $sltTypeFarm = $request->input('sltTypeFarm');
        if($sltType == -1){
            $validate->errors()->add('sltType', 'Bạn hãy chọn một trang trại!!!');
            return redirect()->back()->withErrors($validate->errors())->withInput(); // trả về view add với thông báo lỗi
        }

        $cultivated_area = 0; // tổng diện tích của các land
        $square_land_able = 0; // diện tích mà land có thể dùng dc
        $lands = Lands_Model::select('*')->Where('farm_id','=',$sltTypeFarm)->get();
        foreach ($lands as $value) {
            $cultivated_area += $value['square'];
        }

        $farm = Farm_Model::select("*")->Where('id','=',$sltTypeFarm)->get();
        foreach ($farm as $value) {
            $square_land_able = $value['cultivated_area'] - $cultivated_area;
        }
        if($request -> square > $square_land_able){
            $validate->errors()->add('water_volume', 'Diện tích của land bạn muốn tạo lớn hơn diện tích sẵn có, hãy nhập lại!!!');
            return redirect()->back()->withErrors($validate->errors())->withInput();
        }

        $land = new Lands_Model;
        $land -> name = $request -> name;
        $land -> square = $request -> square;
        $land -> crop_id = $request -> sltType;
        $land -> farm_id = $request -> sltTypeFarm;
        $land -> quanty_crops = $request -> quanty_crops;
        $land -> dev_days = 0;
        $land -> have_watered = 0;
        $land -> have_fertilized = 0;
        $land -> deleted = 0;
        $land->save();

        $follow = new Follow_Model;
        $follow -> id_land = $land -> id;
        $follow -> total_water = 0;
        $follow -> total_fer = 0;
        $follow -> day_harvest = 0;
        $follow -> save();

        // tạo ra bảng theo dõi bón phân cho land
        // + ta lấy ra số giai đoạn phát triển của cây mà người dùng chọn trồng
        $stage_number = Stages_dev_Model::select('*')->Where('crop_id', '=', $sltType)->count();
        for($i = 1; $i <= $stage_number; $i++){
            $follow_fer = new Follow_fer_Model;
            $follow_fer -> id_land = $land -> id;
            $follow_fer -> numerical_order = $i;
            $follow_fer -> have_fer = 0;
            $follow_fer -> save();
        }
        // lưu lại diện tích đất canh tác và diện tích đất trống của farm
        foreach ($farm as $value) {
            $value['planted_area'] += $request -> square;
            $value['vacant_area'] -= $request -> square;
            $value -> save();
        }
        return redirect() -> route('admin.lands.getadd') -> with(['flash_message'=>'Thêm một land thành công!!!']);
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
        $land = Lands_Model::select('*')->Where('id','=',$id)->get()->toArray();
        $crops = Crops_Model::select('*')->get()->toArray();
        foreach ($land as $value) {
            $dev_days = $value['dev_days'];
            $crop_id = $value['crop_id'];
        }
        $crops = Crops_Model::select('*')->get()->toArray();
        $stages = Stages_dev_Model::select('*')->get();
        // lấy ra giai đoạn của cây trồng từ id cây trồng và số ngày phát triển của cây trồng
        $stage = Stages_dev_Model::select('*')->Where('crop_id','=',$crop_id)->Where('start_day','<=',$dev_days)->Where('end_day','>=',$dev_days)->get()->toArray();

        // lấy ra lịch sử tưới nước và bón phân của land (delete = 0)
        $water_detali = Watering_Details_Model::select('*')->Where('land_id','=',$id)->Where('deleted','=',0)->get()->toArray();
        // lấy ra phương thức tưới nước của land
        $method_watering = Method_watering_Model::select('*')->get();

        $fer_detali = Fertilizer_Details_Model::select('*')->Where('land_id','=',$id)->Where('deleted','=',0)->get()->toArray();
        // lấy loại phân đã bón và bồn nước đã sử dụng
        $fers = Fertilizers_Model::select('*')->get()->toArray();
        $water_tank = SourceOfwater_Model::select('*')->get()->toArray();
        return view('Lands.detailLands', compact('land','crops','stage','water_detali','fer_detali','fers','water_tank', 'farms', 'method_watering','stages'));
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
        $land = Lands_Model::select('*')->Where('id','=',$id)->get();
        $crops = Crops_Model::select('*')->get();
        return view('Lands.editLands', compact('land','crops', 'farms'));
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
            "name.required" => "Bạn chưa nhập tên land",
        ];
        $validate = Validator::make($input, $this->rules);
        if($validate->fails()){
            return redirect()->back()->withErrors($validate->errors())->withInput(); // trả về view add với thông báo lỗi
        }
        $sltType = $request->input('sltType');
        if($sltType == -1){
            $validate->errors()->add('sltType', 'Bạn hãy chọn một loại cây trồng bạn muốn trồng !!');
            return redirect()->back()->withErrors($validate->errors())->withInput(); // trả về view add với thông báo lỗi
        }
        $sltTypeFarm = $request->input('sltTypeFarm');
        if($sltType == -1){
            $validate->errors()->add('sltType', 'Bạn hãy chọn một trang trại!!!');
            return redirect()->back()->withErrors($validate->errors())->withInput(); // trả về view add với thông báo lỗi
        }
        $land = Lands_Model::select('*')->Where('id','=',$id)->get();
        foreach ($land as $value) {
            $value['name'] = $request -> name;
            $value['farm_id'] = $request -> sltTypeFarm;
            $value['square'] = $value['square'];
            $value['crop_id'] = $sltType;
            $value['quanty_crops'] = $request -> quanty_crops;
            $value['dev_days'] = 0;
            $value['have_watered'] = 0;
            $value['have_fertilized'] = 0;
            $value['deleted'] = 0;
            $value -> save();
        }
        return redirect() -> route('admin.lands.getlist') -> with(['flash_message'=>'Cập nhật land thành công!!!']);
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
        $land = Lands_Model::select('*')->Where('id','=',$id)->get()->toArray();
    }

    public function getWatering($id)
    {
        $method = Method_watering_Model::select('*')->get();
        $farms = Farm_Model::select('*')->orderBy('id')->get()->toArray();
        $land = Lands_Model::select('*')->Where('id','=',$id)->get()->toArray();
        $crops = Crops_Model::select('*')->get()->toArray();
        $stages = Stages_dev_Model::select('*')->get();
        foreach ($land as $value) {
            $dev_days = $value['dev_days'];
            $virtual_dev_days = $value['virtual_dev_days'];
            $crop_id = $value['crop_id'];
            $farm_id = $value['farm_id'];
            $square = $value['square'];
        }
        // lấy ra chi tiết tưới nước (nếu có) để kiểm tra xem ngày tưới nước có trùng với ngày hôm nay hay không, nếu có thì xuất thông báo cho người dùng
        $watering_detail = Watering_Details_Model::select('*')->Where('land_id','=',$id)->get();
        // ta sẽ lấy ra lần tưới nước gần đây nhất (max của day_watering)
        $max_day_watering = 0;
        foreach ($watering_detail as $value) {
            if($value['day_water'] >= $max_day_watering){
                $max_day_watering = $value['day_water'];
            }
        }
        $watering_detail_need = Watering_Details_Model::select('*')->Where('land_id','=',$id)->Where('day_water','=',$max_day_watering)->get();

        $water_tank = SourceOfwater_Model::select('*')->Where('farm_id','=',$farm_id)->get()->toArray();
        // lấy ra giai đoạn của cây trồng từ id cây trồng và số ngày phát triển của cây trồng
        if($virtual_dev_days == 0)
        {
            $stage = Stages_dev_Model::select('*')->Where('crop_id','=',$crop_id)->Where('start_day','<=',$dev_days)->Where('end_day','>=',$dev_days)->get()->toArray();
        }

        if($virtual_dev_days != 0)
        {
            $stage = Stages_dev_Model::select('*')->Where('crop_id','=',$crop_id)->Where('start_day','<=',$virtual_dev_days)->Where('end_day','>=',$virtual_dev_days)->get()->toArray();
        }
        // lấy ra các điều kiện tự nhiên thích hợp trong giai đoạn này
        foreach ($stage as $value) {
            $suitable_temperature_from = $value['suitable_temperature_from'];
            $suitable_temperature_to = $value['suitable_temperature_to'];
            $suitable_humidity_from = $value['suitable_humidity_from'];
            $suitable_humidity_to = $value['suitable_humidity_to'];
        }

        // ta tiến hành lấy ra thông tin của điều kiện môi trường để xem độ ph của đất cao hơn hay thấp hơn mức thích hợp, nhiệt độ cao hơn hay thấp hơn mức cho phép để đưa ra lời khuyên và yêu cầu dùng chất phụ gia đối với việc thay đổi độ ph và phương thức tưới nước đối với việc làm giảm nhiệt độ môi trường.

        $weather = Weather_Conditions_Model::select('*')->Where('land_id','=',$id)->get();

        return view('Lands.watering', compact('land','water_tank', 'farms','method', 'suitable_temperature_from', 'suitable_temperature_to', 'suitable_humidity_from', 'suitable_humidity_to', 'weather', 'watering_detail_need', 'stage', 'crops', 'square', 'stages'));
    }
    public function postWatering(Request $request, $id)
    {
        $user = Auth::user()->name;
        $input = $request->all(); // lấy tất cả các input đầu vào
        $this->rules =[
            'water_volume' => 'required'
        ];
        $validate = Validator::make($input, $this->rules);
        if($validate->fails()){
            return redirect()->back()->withErrors($validate->errors())->withInput(); // trả về view add với thông báo lỗi
        }
        $sltType = $request->input('sltType');
        $sltTypeMethod = $request->input('sltTypeMethod');
        if($sltType == -1){
            $validate->errors()->add('sltType', 'Bạn hãy chọn một bồn nước bạn muốn dùng !!');
            return redirect()->back()->withErrors($validate->errors())->withInput(); // trả về view add với thông báo lỗi
        }
        if($sltTypeMethod == -1){
            $validate->errors()->add('sltTypeMethod', 'Bạn hãy chọn một phương thức tưới !!');
            return redirect()->back()->withErrors($validate->errors())->withInput(); // trả về view add với thông báo lỗi
        }
        $land = Lands_Model::select('*')->Where('id','=',$id)->get();
        // lấy ra ngày phát triển của land
        foreach ($land as $value) {
            $dev_days = $value['dev_days'];
            $square = $value['square'];
        }

        // kiểm tra người dùng có check vào checkbox bỏ qua cảnh báo lượng phân cần thiết hay không
            if(!$request -> checkbox) // nếu người dùng không check - kiểm tra lượng phân người dùng nhập vào
            {
                if($request -> water_volume > ((int)($square/30)))
                  {$validate->errors()->add('water_volume', 'Lượng nước bạn nhập lớn hơn lượng nước cần thiết cho cây, hãy nhập lại!!!');
              return redirect()->back()->withErrors($validate->errors())->withInput(); }
              if($request -> water_volume < ((int)($square/30)))
                  {$validate->errors()->add('water_volume', 'Lượng nước bạn nhập thấp hơn lượng nước cần thiết cho cây, hãy nhập lại!!!');
              return redirect()->back()->withErrors($validate->errors())->withInput(); }
          }
          $water_tank = SourceOfwater_Model::find($request -> sltType);
        if($request -> water_volume > $water_tank -> volume){
            $validate->errors()->add('water_volume', 'Lượng nước bạn nhập lớn hơn lượng nước có trong bồn, hãy nhập lại!!! !!');
            return redirect()->back()->withErrors($validate->errors())->withInput();
        }
        // tạo chi tiết tưới nước
          $watering = new Watering_Details_Model;
          $watering -> water_volume = $request -> water_volume;
          $watering -> land_id = $id;
          $watering -> water_tank_id = $request -> sltType;
          $watering -> day_water = $dev_days;
          $watering -> implementer = $user;
          $watering -> method_id = $sltTypeMethod;
          $watering->save();
        // cập nhật tình trạng tưới nước của land
          $land = Lands_Model::find($id);
          $land -> have_watered = 1;
          if($sltTypeMethod == 1 || $sltTypeMethod == 2)
          {
            $land -> have_drip_irrigation = 1;
        }
        if($sltTypeMethod == 3)
        {
            $land -> have_watering_misting = 1;
        }
        $land -> save();
        // cập nhật lượng nước của bồn nước đã sử dụng
        $water_tank -> volume = $water_tank -> volume - $request -> water_volume;
        $water_tank -> save();

        // cập nhật bảng theo dõi
        $follow = Follow_Model::select('*')->Where('id_land','=',$id)->get();
        foreach ($follow as $value) {
            $value['total_water'] += $request -> water_volume;
            $value['total_fer'] = $value['total_fer'];
            $value -> save();
        }

        return redirect() -> route('admin.lands.getlist') -> with(['flash_message'=>'Tưới nước thành công!!!']);
    }
    public function getFer($id)
    {
        $farms = Farm_Model::select('*')->orderBy('id')->get()->toArray();
        $land = Lands_Model::select('*')->Where('id','=',$id)->get()->toArray();
        // lấy ra ngày phát triển của land
        foreach ($land as $value) {
            $dev_days = $value['dev_days'];
            $crop_id = $value['crop_id'];
            $farm_id = $value['farm_id'];
            $square = $value['square'];
        }
        $fers = Fertilizers_Model::select('*')->Where('farm_id','=',$farm_id)->get()->toArray();
        $crops = Crops_Model::select('*')->get()->toArray();
        $stages = Stages_dev_Model::select('*')->get();
        // lấy ra giai đoạn của cây trồng từ id cây trồng và số ngày phát triển của cây trồng
        $stage = Stages_dev_Model::select('*')->Where('crop_id','=',$crop_id)->Where('start_day','<=',$dev_days)->Where('end_day','>=',$dev_days)->get()->toArray();
        // lấy ra các điều kiện tự nhiên thích hợp trong giai đoạn này
        foreach ($stage as $value) {
            $suitable_ph_from = $value['suitable_ph_from'];
            $suitable_ph_to = $value['suitable_ph_to'];
        }
        return view('Lands.fer', compact('land','fers','crops','stage', 'farms', 'square','stages'));
    }
    public function postFer(Request $request, $id)
    {
        $user = Auth::user()->name;
        $input = $request->all(); // lấy tất cả các input đầu vào

        $land = Lands_Model::select('*')->Where('id','=',$id)->get();
        // lấy ra ngày phát triển của land
        foreach ($land as $value) {
            $dev_days = $value['dev_days'];
            $crop_id = $value['crop_id'];
            $farm_id = $value['farm_id'];
            $square = $value['square'];
        }
        $fers = Fertilizers_Model::select('*')->Where('farm_id','=',$farm_id)->get()->toArray();
        $this->rules =[
            "mass" => "required",
            "mass.required" => "Bạn chưa nhập khối lượng phân bón",
        ];
        $validate = Validator::make($input, $this->rules);
        if($validate->fails()){
            return redirect()->back()->withErrors($validate->errors())->withInput(); // trả về view add với thông báo lỗi
        }
        $sltType = $request->input('sltType');
        if($sltType == -1){
            $validate->errors()->add('sltType', 'Bạn hãy chọn một loại phân bón bạn muốn dùng !!');
            return redirect()->back()->withErrors($validate->errors())->withInput(); // trả về view add với thông báo lỗi
        }

        // cập nhật bảng giai đoạn
        $stage_curent = Stages_dev_Model::select('*')->Where('crop_id','=',$crop_id)->Where('start_day','<=',$dev_days)->Where('end_day','>=',$dev_days)->get();
        // foreach ($stage_curent as $value) {
        //     $value['have_fertilized'] = 1;
        //     $value -> save();}

        // kiểm tra người dùng có check vào checkbox bỏ qua cảnh báo lượng phân cần thiết hay không
            if(!$request -> checkbox) // nếu người dùng không check - kiểm tra lượng phân người dùng nhập vào
            {
                foreach ($fers as $value) {
                    if($value['id'] == $sltType){
                        if($request -> mass > ((int)(($square * $value['mass_suiable_30_m'])/30)))
                          {$validate->errors()->add('water_volume', 'Lượng phân bón bạn nhập lớn hơn lượng phân bón cần thiết cho cây, hãy nhập lại!!!');
                      return redirect()->back()->withErrors($validate->errors())->withInput(); }
                      if($request -> mass < ((int)(($square * $value['mass_suiable_30_m'])/30)))
                          {$validate->errors()->add('water_volume', 'Lượng phân bón bạn nhập thấp hơn lượng phân bón cần thiết cho cây, hãy nhập lại!!!');
                      return redirect()->back()->withErrors($validate->errors())->withInput(); }
                  }
              }
          }

        // kiểm tra lượng phân người dùng nhập vào đồng thời cập nhật lượng phân còn lại sau khi sử dụng
          $fer = Fertilizers_Model::select('*')->Where("id", '=', $sltType)->Where('farm_id','=',$farm_id)->get();
          foreach ($fer as $value) {
            $mass = $value['mass'];
            $type_fertilizer_id = $value['type_fertilizer_id'];

            if($request -> mass > $mass){
                $validate->errors()->add('water_volume', 'Lượng phân bón bạn nhập lớn hơn lượng phân bón có trong kho, hãy nhập lại!!!');
                return redirect()->back()->withErrors($validate->errors())->withInput();
            }
         // end for
            $value['mass'] = $value['mass'] - $request -> mass;
            $value -> save();
        }

        // tạo chi tiết bón phân
        $fering = new Fertilizer_Details_Model;
        $fering -> land_id = $id;
        $fering -> fertilizer_id = $sltType;
        $fering -> type_fertilizer_id = $type_fertilizer_id;
        $fering -> day_fer = $dev_days;
        $fering -> mass = $request -> mass;
        $fering -> implementer = $user;
        $fering -> save();
        // cập nhật tình trạng bón phân của của land
        foreach ($land as $value) {
            $value['have_fertilized'] = 1;
            $value -> save();
        }
        // cập nhật bảng theo dõi (lượng phân bón đã dùng)
        $follow = Follow_Model::select('*')->Where('id_land','=',$id)->get();
        foreach ($follow as $value) {
            $value['total_water'] = $value['total_water'];
            $value['total_fer'] += $request -> mass;
            $value -> save();
        }
        $follow_fer = Follow_fer_Model::select('*')->get();
        // cập nhật bảng theo dõi bón phân
        foreach ($stage_curent as $valu){
            foreach ($follow_fer as $val) {
                if(($val['id_land'] == $id) && ($valu['numerical_order'] == $val['numerical_order']))
                {
                   $val['have_fer'] = 1;
                   $val -> save();
               }
           }}
           return redirect() -> route('admin.lands.getlist') -> with(['flash_message'=>'Bón phân thành công!!!']);
       }

       public function getchangePH($id)
       {
        $farms = Farm_Model::select('*')->orderBy('id')->get()->toArray();
        $land = Lands_Model::select('*')->Where('id','=',$id)->get()->toArray();
        $stages = Stages_dev_Model::select('*')->get();
        // lấy ra ngày phát triển của land
        foreach ($land as $value) {
            $dev_days = $value['dev_days'];
            $crop_id = $value['crop_id'];
            $farm_id = $value['farm_id'];
            $square = $value['square'];
        }
        $fers = Fertilizers_Model::select('*')->Where('farm_id','=',$farm_id)->get()->toArray();
        // các loại phụ gia dùng để tăng độ ph
        $fer_increase_ph = Fertilizers_Model::select('*')->Where('farm_id','=',$farm_id)->Where('type_fertilizer_id','=',4)->get();

        // Do các loại phụ gia sẽ cần sử dụng một cách có liều lượng nên ta cần tính toán lượng phân cần dùng để người dùng bón trên diện tích land

        // các loại phụ gia dùng để giảm độ ph
        $fer_decrease_ph = Fertilizers_Model::select('*')->Where('farm_id','=',$farm_id)->Where('type_fertilizer_id','=',5)->get();
        $crops = Crops_Model::select('*')->get()->toArray();
        // lấy ra giai đoạn của cây trồng từ id cây trồng và số ngày phát triển của cây trồng
        $stage = Stages_dev_Model::select('*')->Where('crop_id','=',$crop_id)->Where('start_day','<=',$dev_days)->Where('end_day','>=',$dev_days)->get()->toArray();
        // lấy ra các điều kiện tự nhiên thích hợp trong giai đoạn này
        foreach ($stage as $value) {
            $suitable_ph_from = $value['suitable_ph_from'];
            $suitable_ph_to = $value['suitable_ph_to'];
        }

        // ta tiến hành lấy ra thông tin của điều kiện môi trường để xem độ ph của đất cao hơn hay thấp hơn mức thích hợp, nhiệt độ cao hơn hay thấp hơn mức cho phép để đưa ra lời khuyên và yêu cầu dùng chất phụ gia đối với việc thay đổi độ ph và phương thức tưới nước đối với việc làm giảm nhiệt độ môi trường.

        $weather = Weather_Conditions_Model::select('*')->Where('land_id','=',$id)->get();
        foreach ($weather as $value) {
            $ph = $value['ph'];
        }
        //lấy ra độ lệch ph (của môi trường) thấp hơn hay cao hơn với độ ph thích hợp với giai đoạn của cây
        $deviation_ph = 0;
        foreach ($stage as $value) {
            if( $ph < $value['suitable_ph_from']){
                $deviation_ph = $value['suitable_ph_from'] - $ph;
                if($ph > $value['suitable_ph_to'])
                {
                    $deviation_ph = $value['suitable_ph_to'] - $ph;
                }
            }
        }

        // lấy ra chi tiết bón chất phụ gia
        $fer_increase_ph_Detail = Fertilizer_Details_Model::select('*')->Where('land_id','=',$id)->Where('type_fertilizer_id','=',4)->get();
        // + lấy bản ghi của lần bón gần đây nhất - ngày bón lớn nhất
        $max_day_fer_increase = 0;
        foreach ($fer_increase_ph_Detail as $value) {
            if($value['day_fer'] >= $max_day_fer_increase){
                $max_day_fer_increase = $value['day_fer'];
                $fer_increase_id = $value['fertilizer_id'];
            }
        }
        $fer_increase_ph_Detail_need = Fertilizer_Details_Model::select('*')->Where('land_id','=',$id)->Where('type_fertilizer_id','=',4)->Where('day_fer','=',$max_day_fer_increase)->get();
        // + lấy khoảng cách ngày mà loại phụ gia bón có hiệu quả
        // $fer_increase_ph_time = Fertilizers_Model::select('*')->Where('farm_id','=',$farm_id)->Where('fertilizer_id','=',$fer_increase_id)->get();


        $fer_decrease_ph_Detail = Fertilizer_Details_Model::select('*')->Where('land_id','=',$id)->Where('type_fertilizer_id','=',5)->get();
        // + lấy bản ghi của lần bón gần đây nhất - ngày bón lớn nhất
        $max_day_fer_decrease = 0;
        foreach ($fer_decrease_ph_Detail as $value) {
            if($value['day_fer'] >= $max_day_fer_decrease){
                $max_day_fer_decrease = $value['day_fer'];
                $fer_decrease_id = $value['fertilizer_id'];
            }
        }
        $fer_decrease_ph_Detail_need = Fertilizer_Details_Model::select('*')->Where('land_id','=',$id)->Where('type_fertilizer_id','=',5)->Where('day_fer','=',$max_day_fer_decrease)->get();
        // + lấy khoảng cách ngày mà loại phụ gia bón có hiệu quả
        // $fer_decrease_ph_time = Fertilizers_Model::select('*')->Where('farm_id','=',$farm_id)->Where('fertilizer_id','=',$fer_decrease_id)->get();

        return view('Lands.changeph', compact('stages','land','fers','crops','stage', 'farms', 'suitable_ph_from', 'suitable_ph_to', 'ph', 'fer_increase_ph', 'fer_decrease_ph', 'square','fer_increase_ph_Detail_need', 'fer_decrease_ph_Detail_need','deviation_ph'));
    }
    public function postchangePH(Request $request, $id)
    {
        $user = Auth::user()->name;
        $land = Lands_Model::select('*')->Where('id','=',$id)->get();
        foreach ($land as $value) {
            $dev_days = $value['dev_days'];
            $crop_id = $value['crop_id'];
            $square = $value['square'];
        }
        $fers = Fertilizers_Model::select('*')->get();
        $weather = Weather_Conditions_Model::select('*')->Where('land_id','=',$id)->get();
        foreach ($weather as $value) {
            $ph = $value['ph'];
        }
        $stage = Stages_dev_Model::select('*')->Where('crop_id','=',$crop_id)->Where('start_day','<=',$dev_days)->Where('end_day','>=',$dev_days)->get()->toArray();
            //lấy ra độ lệch ph (của môi trường) thấp hơn hay cao hơn với độ ph thích hợp với giai đoạn của cây
        $deviation_ph = 0;
        foreach ($stage as $value) {
            if( $ph < $value['suitable_ph_from']){
                $deviation_ph = $value['suitable_ph_from'] - $ph;
                if($ph > $value['suitable_ph_to'])
                {
                    $deviation_ph = $value['suitable_ph_to'] - $ph;
                }
            }
        }
        $input = $request->all(); // lấy tất cả các input đầu vào
        // lấy ra ngày phát triển của land
        foreach ($land as $value) {
            $dev_days = $value['dev_days'];
            $crop_id = $value['crop_id'];
        }
        //Nếu người dùng chọn bón các loại phụ gia để tăng hoặc giảm độ ph của đât
        if ( $request->ph == 1) { // hành động: tăng độ ph của đất
           $this->rules =[
            "mass_increase_ph" => "required",
            "mass_increase_ph.required" => "Bạn chưa nhập khối lượng phụ gia!",
        ];
        $validate = Validator::make($input, $this->rules);
        if($validate->fails()){
            return redirect()->back()->withErrors($validate->errors())->withInput();} // trả về view add với thông báo lỗi
            if(($request -> sltTypeIncreasePH) != -1) // nếu người dùng có chọn loại phụ gia để tăng độ ph của đất
            {
                $fer = Fertilizers_Model::select('*')->Where("id", '=', $request -> sltTypeIncreasePH)->get(); // find($request -> sltTypeIncreasePH);
                foreach ($fer as $value) {
                    $mass = $value['mass'];
                    $type_fertilizer_id = $value['type_fertilizer_id'];
                }
                if($request -> mass_increase_ph > $mass){
                    $validate->errors()->add('water_volume', 'Lượng phụ gia bạn nhập lớn hơn lượng phụ gia có trong kho, hãy nhập lại!!!');
                    return redirect()->back()->withErrors($validate->errors())->withInput();
                }
                if(!$request->checkbox)// nếu người dùng không check vào checkbox bỏ qua kiểm tra khối lượng phụ gia
                {
                    $id_fer_chosse = $request->sltTypeIncreasePH;
                    foreach ($fers as $value) {
                        if($value['id'] == $id_fer_chosse)
                        {
                            if($request -> mass_increase_ph > (int)($value['mass_increase_1_pH_above_30_m']*$square/30*$deviation_ph))
                                {$validate->errors()->add('mass_increase_ph', 'Lượng phụ gia bạn nhập lớn hơn lượng phụ gia cần thiết cho land, hãy nhập lại!!!');
                      return redirect()->back()->withErrors($validate->errors())->withInput(); }
                      elseif($request -> mass_increase_ph < (int)($value['mass_increase_1_pH_above_30_m']*$square/30*$deviation_ph))
                                {$validate->errors()->add('mass_increase_ph', 'Lượng phụ gia bạn nhập thấp hơn lượng phụ gia cần thiết cho land, hãy nhập lại!!!');
                      return redirect()->back()->withErrors($validate->errors())->withInput(); }
                        }
                    }
                }
                // cập nhật lượng phân
                foreach ($fer as $value) {
                    $value['mass'] = $value['mass'] - $request -> mass_increase_ph;
                    $value -> save();
                }
                // tạo chi tiết bón phân (phụ gia)
                $fering = new Fertilizer_Details_Model;
                $fering -> land_id = $id;
                $fering -> fertilizer_id = $request -> sltTypeIncreasePH;
                $fering -> type_fertilizer_id = $type_fertilizer_id;
                $fering -> day_fer = $dev_days;
                $fering -> mass = $request -> mass_increase_ph;
                $fering -> implementer = $user;
                $fering->save();

                // đánh dấu là land dã bón phụ gia tăng độ ph
                foreach ($land as $value) {
                    $value['have_increased_pH'] = 1;
                    $value -> save();
                }
            }
        }
        if ( $request->ph == 0) { // hành động: giảm độ ph của đất
           $this->rules =[
            "mass_decrease_ph" => "required",
            "mass_decrease_ph.required" => "Bạn chưa nhập khối lượng phụ gia!",
        ];
        $validate = Validator::make($input, $this->rules);
        if($validate->fails()){
            return redirect()->back()->withErrors($validate->errors())->withInput();} // trả về view add với thông báo lỗi
            if(($request -> sltTypeDecreasePH) != -1) // nếu người dùng có chọn loại phụ gia để giảm độ ph của đất
            {

                $fer = Fertilizers_Model::select('*')->Where("id", '=', $request -> sltTypeDecreasePH)->get(); // find($request -> sltTypeIncreasePH);

                foreach ($fer as $value) {
                    $mass = $value['mass'];
                    $type_fertilizer_id = $value['type_fertilizer_id'];
                }
                if($request -> mass_decrease_ph > $mass){
                    $validate->errors()->add('water_volume', 'Lượng phụ gia bạn nhập lớn hơn lượng phụ gia có trong kho, hãy nhập lại!!!');
                    return redirect()->back()->withErrors($validate->errors())->withInput();
                }
                if(!$request->checkbox)// nếu người dùng không check vào checkbox bỏ qua kiểm tra khối lượng phụ gia
                {
                    $id_fer_chosse = $request->sltTypeIncreasePH;
                    foreach ($fers as $value) {
                        //echo $value['mass_reduces_1_pH_above_30_m']; die();
                        if($value['id'] == $id_fer_chosse)
                        {
                            if($request -> mass_increase_ph > (int)($value['mass_reduces_1_pH_above_30_m']*$square/30*$deviation_ph))
                                {$validate->errors()->add('mass_increase_ph', 'Lượng phụ gia bạn nhập lớn hơn lượng phụ gia cần thiết cho land, hãy nhập lại!!!');
                      return redirect()->back()->withErrors($validate->errors())->withInput(); }
                      elseif($request -> mass_increase_ph < (int)($value['mass_reduces_1_pH_above_30_m']*$square/30*$deviation_ph))
                                {$validate->errors()->add('mass_increase_ph', 'Lượng phụ gia bạn nhập thấp hơn lượng phụ gia cần thiết cho land, hãy nhập lại!!!');
                      return redirect()->back()->withErrors($validate->errors())->withInput(); }
                        }
                    }
                }
                // cập nhật lượng phân
                foreach ($fer as $value) {
                    $value['mass'] = $value['mass'] - $request -> mass_decrease_ph;
                    $value -> save();
                }

                // tạo chi tiết bón phân (phụ gia)
                $fering = new Fertilizer_Details_Model;
                $fering -> land_id = $id;
                $fering -> fertilizer_id = $request -> sltTypeDecreasePH;
                $fering -> type_fertilizer_id = $type_fertilizer_id;
                $fering -> day_fer = $dev_days;
                $fering -> mass = $request -> mass_decrease_ph;
                $fering -> implementer = $user;
                $fering->save();

                // đánh dấu là land dã bón phụ gia giảm độ ph
                foreach ($land as $value) {
                    $value['have_decreased_pH'] = 1;
                    $value -> save();}
                }
            }
            return redirect() -> route('admin.lands.getlist') -> with(['flash_message'=>'Bón phụ gia thành công!!!']);
        }

    // function xử lý chức năng thu hoạch
        public function getHarvest(Request $request, $id)
        {
            $farms = Farm_Model::select('*')->orderBy('id')->get()->toArray();
            $request->user()->authorizeRoles(['admin']);
            $total_water = 0;
            $total_fer = 0;
            $land = Lands_Model::select('*')->Where('id','=',$id)->get()->toArray();
            foreach ($land as $value) {
                $crop_id = $value['crop_id'];
                $dev_day = $value['dev_days'];
            }
            $crop = Crops_Model::select('*')->get()->toArray();
            $water_detali = Watering_Details_Model::select('*')->Where('land_id','=',$id)->get()->toArray();
            //$stage = Stages_dev_Model::select('*')->Where('crop_id','=',$crop_id)->Where('start_day','<=',$dev_day)->Where('end_day','>=',$dev_day)->get(); // cái này là lấy ra giai đoạn hiện tại
            $stage = Stages_dev_Model::select('*')->Where('crop_id','=',$crop_id)->Where('numerical_order','>=',2)->Where('end_day','<=',$dev_day)->get(); // điều kiện ở đây là không phải giai đoạn 1 và giai đoạn hiện tại.
            foreach ($water_detali as $value) {
                $total_water += $value['water_volume'];
            }
            $fer_detali = Fertilizer_Details_Model::select('*')->Where('land_id','=',$id)->get()->toArray();
            foreach ($fer_detali as $value) {
                $total_fer += $value['mass'];
            }
            return view('Lands.harvestLands', compact('land','crop','total_water','total_fer', 'farms','stage'));
    }

    public function postHarvest(Request $request, $id)
    {
        $land = Lands_Model::select('*')->Where('id','=',$id)->get();
        foreach ($land as $value) {
            $crop_id = $value['crop_id'];
            $dev_day = $value['dev_days'];
        }
        $harvest = Follow_Model::select('*')->Where('id_land','=',$id)->get();
        $total_water = 0;
        $total_fer = 0;
        $day_harvest = 0;
        $water_detali = Watering_Details_Model::select('*')->Where('land_id','=',$id)->get();
        foreach ($water_detali as $value) {
            $total_water += $value['water_volume'];
            //$value['deleted'] = 1; // cập nhật status delete =1
            $value -> save();
        }
        $fer_detali = Fertilizer_Details_Model::select('*')->Where('land_id','=',$id)->get();
        foreach ($fer_detali as $value) {
            $total_fer += $value['mass'];
            //$value['deleted'] = 1; // cập nhật status delete =1
            $value -> save();
        }
        $input = $request->all(); // lấy tất cả các input đầu vào
        $this->rules =[
            'sltChoose' => 'required'
        ];
        $validate = Validator::make($input, $this->rules);
        $sltChoose = $request->input('sltChoose');
        if($sltChoose == -1){
            $validate->errors()->add('sltChoose', 'Bạn hãy chọn một phương thức xử lý sau khi thu hoạch land !!!');
            return redirect()->back()->withErrors($validate->errors())->withInput(); // trả về view add với thông báo lỗi
        }

        if($sltChoose == 0){
            // nếu người dùng muốn duy trì land và chăm sóc cây trồng
            $this->rules =[
                'sltChooseStage' => 'required'
            ];
            $validate = Validator::make($input, $this->rules);
            $sltChooseStage = $request->input('sltChooseStage');
            if($sltChooseStage == -1){
                $validate->errors()->add('sltChooseStage', 'Bạn hãy chọn một giai đoạn phát triển của cây sau khi thu hoạch land !!!');
            return redirect()->back()->withErrors($validate->errors())->withInput(); // trả về view add với thông báo lỗi
        }
        $stage_return = $sltChooseStage;
        foreach ($land as $value) {
            $day_harvest = $value['dev_days'];
            $value['crop_id'] = $value['crop_id'];
            $value['have_fertilized'] = 0;
            $value['have_watered'] = 0;
            $value['dev_days'] = $value['dev_days'];
            $value['square'] = $value['square'];
            $value['quanty_crops'] = $value['quanty_crops'];
            $stage = Stages_dev_Model::select('*')->Where('crop_id','=',$crop_id)->Where('numerical_order','=',$stage_return)->get();
            foreach ($stage as $valu) {
                $value['virtual_dev_days'] = $valu['start_day'];
            }
            $value -> save();
            foreach ($harvest as $value) {
                $total_water_1 = 0;
                $total_fer_1 = 0;
                if($value['old'] == 0){
                    $value['day_harvest'] = $day_harvest;
                    $value['old'] = 1;
                    $value->save();
                    break;
                }
                elseif($value['old'] == 1){
                    $watering_detail = Watering_Details_Model::select('*')->Where('land_id','=',$id)->Where('day_water','>',$value['day_harvest'])->get();
                    foreach ($watering_detail as $valu) {
                        $total_water_1 += $valu['water_volume'];
                    }
                    $fer_detali = Fertilizer_Details_Model::select('*')->Where('land_id','=',$id)->Where('day_fer','>',$value['day_harvest'])->get();
                    foreach ($fer_detali as $val) {
                        $total_fer_1 += $val['mass'];
                    }
                    $follow = new Follow_Model;
                    $follow -> id_land = $id;
                    $follow -> total_water = $total_water_1;
                    $follow -> total_fer = $total_fer_1;
                    $follow -> day_harvest = $day_harvest;
                    //$follow -> old = 1;
                    $follow -> save();
                    //dd($follow);
                }
            }
        }
    }
    if($sltChoose == 1){
        foreach ($land as $value) {
            $day_harvest = $value['dev_days'];
            $value['crop_id'] = 0;
            $value['have_fertilized'] = 0;
            $value['have_watered'] = 0;
            $value['dev_days'] = 0;
            $value['square'] = $value['square'];
            $value['quanty_crops'] = 0;
            $value -> save();
        }
        foreach ($harvest as $value) {
            $value['total_water'] = $total_water;
            $value['total_fer'] = $total_fer;
            $value['day_harvest'] = $day_harvest;
            $value -> save();
        }
        return redirect() -> route('admin.lands.getEdit',$id) -> with(['flash_message'=>'Thu hoạch thành công. Giờ bạn hãy lựa chọn cây trồng mới cho land !!!']);
    }
    if($sltChoose == 2){
            // vẫn giữ lại land nhưng chưa trồng cây trồng nào
        foreach ($land as $value) {
            $day_harvest = $value['dev_days'];
            $value['crop_id'] = 0;
            $value['have_fertilized'] = 0;
            $value['have_watered'] = 0;
            $value['dev_days'] = 0;
            $value['square'] = $value['square'];
            $value['quanty_crops'] = 0;
            $value -> save();
        }
        foreach ($harvest as $value) {
            $value['total_water'] = $total_water;
            $value['total_fer'] = $total_fer;
            $value['day_harvest'] = $day_harvest;
            $value -> save();
        }

    }
    if($sltChoose == 3){
            // xóa land sau khi thu hoạch
        foreach ($land as $value) {
            $day_harvest = $value['dev_days'];
            $value['deleted'] = 1;
            $value -> save();
        }
        foreach ($harvest as $value) {
            $value['total_water'] = $total_water;
            $value['total_fer'] = $total_fer;
            $value['day_harvest'] = $day_harvest;
            $value -> save();
        }
        // cập nhật lại diện tích đất canh đã canh tác và đất trống của land
    }
    // đưa các thông số của land về ban đầu = 0 hết
    foreach ($land as $value) {
        $value['have_watered'] = 0;
        $value['have_drip_irrigation'] = 0;
        $value['have_watering_misting'] = 0;
        $value['have_fertilized'] = 0;
        $value['have_decreased_pH'] = 0;
        $value['have_increased_pH'] = 0;
        $value->save();
    }
    return redirect() -> route('admin.lands.getlist') -> with(['flash_message'=>'Thu hoạch thành công!!!']);
}
    // function tăng ngày phát triển của cây trồng trong land
public function increase_Day_dev()
{
       $lands = Lands_Model::select('*')->get(); // không toArray() để nhận dữ liệu là kiểu collection

        // cập nhật điều kiện thời tiết
        $light_total_arr = array("Yếu","Tốt","Mạnh"); // Ánh sáng chung cho các land
        $random_keys=array_rand($light_total_arr,1);
        $light_total = $light_total_arr[$random_keys];
        Weather_Conditions_Model::truncate();
        foreach ($lands as $key => $value) {
            // Xóa điều kiện thời tiết cũ
            if($light_total == "Yếu") // ánh sáng yếu => độ ẩm cao, nhiệt độ thấp
            {
                $humidity_hight = rand(70,95);
                $temperature_low = rand(20,25);
                $ph = rand(4,7);
                // Tạo điều kiện mới
                $weather = new Weather_Conditions_Model;
                $weather -> light = $light_total;
                $weather -> humidity_from = $humidity_hight;
                $weather -> humidity_to = $humidity_hight + 5;
                $weather -> temperature_from = $temperature_low;
                $weather -> temperature_to = $temperature_low + 1;
                $weather -> land_id = $value['id'];
                $weather -> ph = $ph;
            }
            if($light_total == "Tốt") // ánh sáng yếu => độ ẩm cao, nhiệt độ thấp
            {
                $humidity_average = rand(60,70);
                $temperature_average = rand(25,30);
                $ph = rand(4,7);
                // Tạo điều kiện mới
                $weather = new Weather_Conditions_Model;
                $weather -> light = $light_total;
                $weather -> humidity_from = $humidity_average;
                $weather -> humidity_to = $humidity_average + 5;
                $weather -> temperature_from = $temperature_average;
                $weather -> temperature_to = $temperature_average + 1;
                $weather -> land_id = $value['id'];
                $weather -> ph = $ph;
            }
            if($light_total == "Mạnh") // ánh sáng yếu => độ ẩm cao, nhiệt độ thấp
            {
                $humidity_low = rand(50,60); // độ ẩm
                $temperature_hight = rand(30,35);
                $ph = rand(4,7);
                $weather = new Weather_Conditions_Model;
                $weather -> light = $light_total;
                $weather -> humidity_from = $humidity_low;
                $weather -> humidity_to = $humidity_low + 5;
                $weather -> temperature_from = $temperature_hight;
                $weather -> temperature_to = $temperature_hight + 1;
                $weather -> land_id = $value['id'];
                $weather -> ph = $ph;
            }
            $weather -> save();
        } // end foreach

        // thay đổi thuộc tính dev_days của các land với giá trị +10 ngày
        foreach ($lands as $value) {
            $value['dev_days'] += 1;
            if($value['virtual_dev_days'] != 0){
                $value['virtual_dev_days'] += 1;
            }
            $dev_days = $value['dev_days'];
            // Sau khi tăng lên một ngày thì return have_watered của land về 0;
            $value['have_watered'] = 0;
            //$value['have_fertilized'] = 0;
            $value['have_drip_irrigation'] = 0;
            $value['have_watering_misting'] = 0;
            $value -> save();
        }
        // Cập nhật lại tình trạng sử dụng các loại phụ gia tăng hoặc giảm độ ph
        // lấy chi tiết bón các loại phụ gia tăng hoặc giảm độ ph
        $fer_detail = Fertilizer_Details_Model::select('*')->get();
        // lấy các loại phân
        $fer = Fertilizers_Model::select('*')->get();
        foreach ($lands as $value) {
            foreach ($fer_detail as $valu) {
                foreach ($fer as $val) {
                    if($value['id'] == $valu['land_id'] && $valu['type_fertilizer_id'] == 4) // kiểm tra cái lần bón phụ gia tăng độ ph của đất
                    {
                        if($val['id'] == $valu['fertilizer_id']) // lấy chi tiết phụ gia
                        {
                            if(($value['dev_days'] - 1) < ($valu['day_fer'] + $val['effective_time']))
                            {
                                $value['have_increased_pH'] = 1;
                            }
                            else $value['have_increased_pH'] = 0;
                        }
                    }
                    if($value['id'] == $valu['land_id'] && $valu['type_fertilizer_id'] == 5) // kiểm tra cái lần bón phụ gia giảm độ ph của đất
                    {
                        if($val['id'] == $valu['fertilizer_id']) // lấy chi tiết phụ gia
                        {
                            if(($value['dev_days'] - 1) < ($valu['day_fer'] + $val['effective_time']))
                            {
                                $value['have_decreased_pH'] = 1;
                            }
                            else $value['have_increased_pH'] = 0;
                        }
                    }
                }
            }
            $value -> save();
        }
        return redirect() -> route('admin.lands.getlist') -> with(['flash_message'=>'Đã tăng ngày phát triển của land lên 1 ngày!!!']);
    }

    public function increase_Day_dev10()
    {
        $lands = Lands_Model::select('*')->get(); // không toArray() để nhận dữ liệu là kiểu collection
        // cập nhật điều kiện thời tiết
        $light_total_arr = array("Yếu","Tốt","Mạnh"); // Ánh sáng chung cho các land
        $random_keys=array_rand($light_total_arr,1);
        $light_total = $light_total_arr[$random_keys];
        Weather_Conditions_Model::truncate();
        foreach ($lands as $key => $value) {
            // Xóa điều kiện thời tiết cũ
            if($light_total == "Yếu") // ánh sáng yếu => độ ẩm cao, nhiệt độ thấp
            {
                $humidity_hight = rand(70,95);
                $temperature_low = rand(20,25);
                $ph = rand(4,7);
                // Tạo điều kiện mới
                $weather = new Weather_Conditions_Model;
                $weather -> light = $light_total;
                $weather -> humidity_from = $humidity_hight;
                $weather -> humidity_to = $humidity_hight + 5;
                $weather -> temperature_from = $temperature_low;
                $weather -> temperature_to = $temperature_low + 1;
                $weather -> land_id = $value['id'];
                $weather -> ph = $ph;
            }
            if($light_total == "Tốt") // ánh sáng yếu => độ ẩm cao, nhiệt độ thấp
            {
                $humidity_average = rand(60,70);
                $temperature_average = rand(25,30);
                $ph = rand(4,7);
                // Tạo điều kiện mới
                $weather = new Weather_Conditions_Model;
                $weather -> light = $light_total;
                $weather -> humidity_from = $humidity_average;
                $weather -> humidity_to = $humidity_average + 5;
                $weather -> temperature_from = $temperature_average;
                $weather -> temperature_to = $temperature_average + 1;
                $weather -> land_id = $value['id'];
                $weather -> ph = $ph;
            }
            if($light_total == "Mạnh") // ánh sáng yếu => độ ẩm cao, nhiệt độ thấp
            {
                $humidity_low = rand(50,60); // độ ẩm
                $temperature_hight = rand(30,35);
                $ph = rand(4,7);
                $weather = new Weather_Conditions_Model;
                $weather -> light = $light_total;
                $weather -> humidity_from = $humidity_low;
                $weather -> humidity_to = $humidity_low + 5;
                $weather -> temperature_from = $temperature_hight;
                $weather -> temperature_to = $temperature_hight + 1;
                $weather -> land_id = $value['id'];
                $weather -> ph = $ph;
            }
            $weather -> save();
        } // end foreach
        // thay đổi thuộc tính dev_days của các land với giá trị +10 ngày
        foreach ($lands as $value) {
            $value['dev_days'] += 10;
            if($value['virtual_dev_days'] != 0){
                $value['virtual_dev_days'] += 10;
            }
            $dev_days = $value['dev_days'];
            // Sau khi tăng lên một ngày thì return have_watered của land về 0;
            $value['have_watered'] = 0;
            //$value['have_fertilized'] = 0;
            $value['have_drip_irrigation'] = 0;
            $value['have_watering_misting'] = 0;
            $value -> save();
        }
        // Cập nhật lại tình trạng sử dụng các loại phụ gia tăng hoặc giảm độ ph
        // lấy chi tiết bón các loại phụ gia tăng hoặc giảm độ ph
        $fer_detail = Fertilizer_Details_Model::select('*')->get();
        // lấy các loại phân
        $fer = Fertilizers_Model::select('*')->get();
        foreach ($lands as $value) {
            foreach ($fer_detail as $valu) {
                foreach ($fer as $val) {
                    if($value['id'] == $valu['land_id'] && $valu['type_fertilizer_id'] == 4) // kiểm tra cái lần bón phụ gia tăng độ ph của đất
                    {
                        if($val['id'] == $valu['fertilizer_id']) // lấy chi tiết phụ gia
                        {
                            if(($value['dev_days'] - 1) < ($valu['day_fer'] + $val['effective_time']))
                            {
                                $value['have_increased_pH'] = 1;
                            }
                            else $value['have_increased_pH'] = 0;
                        }
                    }
                    if($value['id'] == $valu['land_id'] && $valu['type_fertilizer_id'] == 5) // kiểm tra cái lần bón phụ gia giảm độ ph của đất
                    {
                        if($val['id'] == $valu['fertilizer_id']) // lấy chi tiết phụ gia
                        {
                            if(($value['dev_days'] - 1) < ($valu['day_fer'] + $val['effective_time']))
                            {
                                $value['have_decreased_pH'] = 1;
                            }
                            else $value['have_increased_pH'] = 0;
                        }
                    }
                }
            }
            $value -> save();
        }
        return redirect() -> route('admin.lands.getlist') -> with(['flash_message'=>'Đã tăng ngày phát triển của land lên 10 ngày!!!']);
    }
    public function increase_Day_dev20()
    {
        $lands = Lands_Model::select('*')->get(); // không toArray() để nhận dữ liệu là kiểu collection
        // cập nhật điều kiện thời tiết
        $light_total_arr = array("Yếu","Tốt","Mạnh"); // Ánh sáng chung cho các land
        $random_keys=array_rand($light_total_arr,1);
        $light_total = $light_total_arr[$random_keys];
        Weather_Conditions_Model::truncate();
        foreach ($lands as $key => $value) {
            // Xóa điều kiện thời tiết cũ
            if($light_total == "Yếu") // ánh sáng yếu => độ ẩm cao, nhiệt độ thấp
            {
                $humidity_hight = rand(70,95);
                $temperature_low = rand(20,25);
                $ph = rand(4,7);
                // Tạo điều kiện mới
                $weather = new Weather_Conditions_Model;
                $weather -> light = $light_total;
                $weather -> humidity_from = $humidity_hight;
                $weather -> humidity_to = $humidity_hight + 5;
                $weather -> temperature_from = $temperature_low;
                $weather -> temperature_to = $temperature_low + 1;
                $weather -> land_id = $value['id'];
                $weather -> ph = $ph;
            }
            if($light_total == "Tốt") // ánh sáng yếu => độ ẩm cao, nhiệt độ thấp
            {
                $humidity_average = rand(60,70);
                $temperature_average = rand(25,30);
                $ph = rand(4,7);
                // Tạo điều kiện mới
                $weather = new Weather_Conditions_Model;
                $weather -> light = $light_total;
                $weather -> humidity_from = $humidity_average;
                $weather -> humidity_to = $humidity_average + 5;
                $weather -> temperature_from = $temperature_average;
                $weather -> temperature_to = $temperature_average + 1;
                $weather -> land_id = $value['id'];
                $weather -> ph = $ph;
            }
            if($light_total == "Mạnh") // ánh sáng yếu => độ ẩm cao, nhiệt độ thấp
            {
                $humidity_low = rand(50,60); // độ ẩm
                $temperature_hight = rand(30,35);
                $ph = rand(4,7);
                $weather = new Weather_Conditions_Model;
                $weather -> light = $light_total;
                $weather -> humidity_from = $humidity_low;
                $weather -> humidity_to = $humidity_low + 5;
                $weather -> temperature_from = $temperature_hight;
                $weather -> temperature_to = $temperature_hight + 1;
                $weather -> land_id = $value['id'];
                $weather -> ph = $ph;
            }
            $weather -> save();
        } // end foreach
        // thay đổi thuộc tính dev_days của các land với giá trị +10 ngày
        foreach ($lands as $value) {
            $value['dev_days'] += 20;
            if($value['virtual_dev_days'] != 0){
                $value['virtual_dev_days'] += 20;
            }
            $dev_days = $value['dev_days'];
            // Sau khi tăng lên một ngày thì return have_watered của land về 0;
            $value['have_watered'] = 0;
            //$value['have_fertilized'] = 0;
            $value['have_drip_irrigation'] = 0;
            $value['have_watering_misting'] = 0;
            $value -> save();
        }
        // Cập nhật lại tình trạng sử dụng các loại phụ gia tăng hoặc giảm độ ph
        // lấy chi tiết bón các loại phụ gia tăng hoặc giảm độ ph
        $fer_detail = Fertilizer_Details_Model::select('*')->get();
        // lấy các loại phân
        $fer = Fertilizers_Model::select('*')->get();
        foreach ($lands as $value) {
            foreach ($fer_detail as $valu) {
                foreach ($fer as $val) {
                    if($value['id'] == $valu['land_id'] && $valu['type_fertilizer_id'] == 4) // kiểm tra cái lần bón phụ gia tăng độ ph của đất
                    {
                        if($val['id'] == $valu['fertilizer_id']) // lấy chi tiết phụ gia
                        {
                            if(($value['dev_days'] - 1) < ($valu['day_fer'] + $val['effective_time']))
                            {
                                $value['have_increased_pH'] = 1;
                            }
                            else $value['have_increased_pH'] = 0;
                        }
                    }
                    if($value['id'] == $valu['land_id'] && $valu['type_fertilizer_id'] == 5) // kiểm tra cái lần bón phụ gia giảm độ ph của đất
                    {
                        if($val['id'] == $valu['fertilizer_id']) // lấy chi tiết phụ gia
                        {
                            if(($value['dev_days'] - 1) < ($valu['day_fer'] + $val['effective_time']))
                            {
                                $value['have_decreased_pH'] = 1;
                            }
                            else $value['have_increased_pH'] = 0;
                        }
                    }
                }
            }
            $value -> save();
        }
        return redirect() -> route('admin.lands.getlist') -> with(['flash_message'=>'Đã tăng ngày phát triển của land lên 20 ngày!!!']);
    }

    public function getResetDevDay()
    {
         $lands = Lands_Model::select('*')->get(); // không toArray() để nhận dữ liệu là kiểu collection

        // thay đổi thuộc tính dev_days của các land với giá trị +1 ngày
         foreach ($lands as $value) {
            $value['dev_days'] = 1;
            if($value['virtual_dev_days'] != 0){
                $value['virtual_dev_days'] = 1;
            }
            // Sau khi tăng lên một ngày thì return have_watered của land về 0;
            $value['have_watered'] = 0;
            $value['have_fertilized'] = 0;
            $value['have_drip_irrigation'] = 0;
            $value['have_watering_misting'] = 0;
            $stage_curent = Stages_dev_Model::select('*')->get();
            foreach ($stage_curent as $val2) {
                $val2['have_fertilized'] = 0;
                $val2 -> save();
            }
            $value -> save();
        }

        // xóa các chi tiết bón phân và chi tiết tưới nước của land đó
        $fering = Fertilizer_Details_Model::select('*')->get();
        foreach ($fering as $value) {
            $value -> delete();
        }

        $watering = Watering_Details_Model::select('*')->get();
        foreach ($watering as $value) {
           $value -> delete();
       }
     // xóa bản theo dõi bón phân
       $follow_fer = Follow_fer_Model::select('*')->get();
       foreach ($follow_fer as $value) {
           $value['have_fer'] = 0;
           $value -> save();
       }


       return redirect() -> route('admin.lands.getlist') -> with(['flash_message'=>'Đã reset ngày phát triển thành công!!!']);
   }

   public function Create_weather_condition()
   {
    $lands = Lands_Model::select('*')->get(); // không toArray() để nhận dữ liệu là kiểu collection

        // cập nhật điều kiện thời tiết
        $light_total_arr = array("Yếu","Tốt","Mạnh"); // Ánh sáng chung cho các land
        $random_keys=array_rand($light_total_arr,1);
        $light_total = $light_total_arr[$random_keys];
        Weather_Conditions_Model::truncate();
        foreach ($lands as $key => $value) {
            // Xóa điều kiện thời tiết cũ
            if($light_total == "Yếu") // ánh sáng yếu => độ ẩm cao, nhiệt độ thấp
            {
                $humidity_hight = rand(70,95);
                $temperature_low = rand(20,25);
                $ph = rand(4,7);
                // Tạo điều kiện mới
                $weather = new Weather_Conditions_Model;
                $weather -> light = $light_total;
                $weather -> humidity_from = $humidity_hight;
                $weather -> humidity_to = $humidity_hight + 5;
                $weather -> temperature_from = $temperature_low;
                $weather -> temperature_to = $temperature_low + 1;
                $weather -> land_id = $value['id'];
                $weather -> ph = $ph;
            }
            if($light_total == "Tốt") // ánh sáng yếu => độ ẩm cao, nhiệt độ thấp
            {
                $humidity_average = rand(60,70);
                $temperature_average = rand(25,30);
                $ph = rand(4,7);
                // Tạo điều kiện mới
                $weather = new Weather_Conditions_Model;
                $weather -> light = $light_total;
                $weather -> humidity_from = $humidity_average;
                $weather -> humidity_to = $humidity_average + 5;
                $weather -> temperature_from = $temperature_average;
                $weather -> temperature_to = $temperature_average + 1;
                $weather -> land_id = $value['id'];
                $weather -> ph = $ph;
            }
            if($light_total == "Mạnh") // ánh sáng yếu => độ ẩm cao, nhiệt độ thấp
            {
                $humidity_low = rand(50,60); // độ ẩm
                $temperature_hight = rand(30,35);
                $ph = rand(4,7);
                $weather = new Weather_Conditions_Model;
                $weather -> light = $light_total;
                $weather -> humidity_from = $humidity_low;
                $weather -> humidity_to = $humidity_low + 5;
                $weather -> temperature_from = $temperature_hight;
                $weather -> temperature_to = $temperature_hight + 1;
                $weather -> land_id = $value['id'];
                $weather -> ph = $ph;
            }
            $weather -> save();
        } // end foreach

        return redirect() -> route('admin.lands.getlist') -> with(['flash_message'=>'Cập nhật điều kiện thời tiết thành công!!!']);
    }



}