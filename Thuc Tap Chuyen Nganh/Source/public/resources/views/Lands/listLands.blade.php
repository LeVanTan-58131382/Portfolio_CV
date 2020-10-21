@extends('admin')

@section('content')

<div class="container">
	<div class="row">
		<a href="{!! URL::route('admin.weather.create_condition')!!}" title="Kiểm tra môi trường" ><input type="button" class="btn tang" style="width: 210px; height: 40px" value="Kiểm tra điều kiện môi trường"></a>
		<a href="{!! URL::route('admin.lands.getIncrease')!!}" title="Tăng thêm 1 ngày" ><input type="button" class="btn tang" style="width: 180px; height: 40px" value="Tăng thêm 1 ngày"></a>
		<a href="{!! URL::route('admin.lands.getIncrease10')!!}" title="Tăng thêm 10 ngày" ><input type="button" class="btn tang" style="width: 180px; height: 40px" value="Tăng thêm 10 ngày"></a>
		<a href="{!! URL::route('admin.lands.getIncrease20')!!}" title="Tăng thêm 20 ngày" ><input type="button" class="btn tang" style="width: 180px; height: 40px" value="Tăng thêm 20 ngày"></a>
		<a href="{!! URL::route('admin.lands.getResetDevDay')!!}" title="Reset ngày" ><input type="button" class="btn tang" style="width: 180px; height: 40px" value="Reset ngày"></a>
		<label for="">Tháng hiện tại</label><?php foreach ($farms as $value): ?>
		<?php
		// if($value['id'] == 1)
		// {
		// 	echo $value['current_month'];
		// }
		?>
	<?php endforeach ?>

	<?php foreach ($lands as $value): ?>
		<?php
		if($value['crop_id'] != 0)
		{
			{?>
				<div  class="card-deck-wrapper">
					<div  class="card-deck">
						<div style="width: 570px; height: 750px" id="ban" class="col-md-5">
							<div class="card">
								<div class="row">
									<div class="col-md-7">
										<div class="card-block">
											<h4 class="card-title ten"><a href="{!! URL::route('admin.lands.getDetail', $value['id'])!!}"><b style="color: blue"><?= $value["name"] ?></b></a></h4>
											<?php
											foreach ($crops as $val) {
												if($val['id'] == $value["crop_id"])
													{?>
														<img style="width: 125px; height: 90px" src="{{ asset('/resources/upload/{!! $val["image"]!!}') }}" alt="">
														{{-- <img style="width: 125px; height: 90px" src="{!!url('/')!!}/resources/upload/{!!$val['image']!!}" alt=""> --}}
													<?php }
												}
												?>
											</br></br>
											<p class="card-text editns">
												<button class="btn btn-outline-success"><a href="{!! URL::route('admin.lands.getEdit', $value['id'])!!}" > Cập nhật <i class="far fa-edit"></i></a></button>
											</p>
											<p class="card-text tuoi">Tình Trạng: </p>
											<?php
											$tinhtrang = $value['have_watered'];
											if($tinhtrang == 0)
											{
												echo '<button style="color: white; background: #FF9900;font-size: 20px; width: 203px; height: 50px" class="btn">Chưa tưới nước</button></br></br>';
											}
											else {
												echo '<button style="color: white; background: #008F68;font-size: 20px; width: 203px; height: 50px" class="btn"> Đã tưới nước</button></br></br>';
											}
											$tinhtrangbonphan = $value['have_fertilized'];
											if($tinhtrangbonphan == 0)
											{
												echo '<button style="color: white; background: #FF9900;font-size: 20px; width: 203px; height: 50px" class="btn">Chưa bón phân</button></br>';
											}
											else {
												echo '<button style="color: white; background: #008F68; font-size: 20px; width: 203px; height: 50px" class="btn"> Đã bón phân</button></br>';
											}
											?>

										</br></br>
										<p class="card-text editns">
											<div class="row">
												<div class="col-md-4"><a rea href="{!! URL::route('admin.lands.getFer', $value['id'])!!}" title="Bón phân" ><input style="width: 92px" class="btn action" value="Bón phân"> </a><?php
												// lấy ra cái record theo dõi bón phân
												foreach ($stage as $valu){
													foreach ($follow_fer as $val) {
														if($value['virtual_dev_days'] != 0){
															if(($value['crop_id'] == $valu['crop_id']) && ($valu['start_day'] <= $value["virtual_dev_days"]) && ($valu['end_day'] >= $value["virtual_dev_days"]) && ($value['id'] == $val['id_land']))
															{
															// bước trên đã lấy dc giai đoạn hiện tại của cây trồng, record theo dõi bón phân của land
															// tiếp theo lấy record theo dõi bón phân của giai đoạn đó
																if($valu['numerical_order'] == $val['numerical_order'] && $val['have_fer'] == 0)
																{
																	{?>
																		<div class="del_img_demo_1"></div>
																	<?php }
																}
															}
														}
														elseif($value['virtual_dev_days'] == 0){
															if(($value['crop_id'] == $valu['crop_id']) && ($valu['start_day'] <= $value["dev_days"]) && ($valu['end_day'] >= $value["dev_days"]) && ($value['id'] == $val['id_land']))
															{
															// bước trên đã lấy dc giai đoạn hiện tại của cây trồng, record theo dõi bón phân của land
															// tiếp theo lấy record theo dõi bón phân của giai đoạn đó
																if($valu['numerical_order'] == $val['numerical_order'] && $val['have_fer'] == 0)
																{
																	{?>
																		<div class="del_img_demo_1"></div>
																	<?php }
																}
															}
														}
													}
												}
												?></div>
												<div class="col-md-4"><a rea href="{!! URL::route('admin.lands.getWatering', $value['id'])!!}" title="Tưới nước" ><input style="width: 92px" class="btn action" value="Tưới nước"></a><?php
												foreach ($stage as $valu){
													foreach ($weather as $val1) {
														if($value['virtual_dev_days'] != 0){
															if(($valu['crop_id'] == $value["crop_id"]) && ($valu['start_day'] <= $value["virtual_dev_days"]) && ($valu['end_day'] >= $value["virtual_dev_days"]) && $val1['land_id'] == $value["id"]){
																if((($val1['humidity_from'] + $val1['humidity_to'])/2 < $valu['suitable_humidity_from'] && $value['have_drip_irrigation'] == 0) || (($val1['temperature_from'] + $val1['temperature_to'])/2 > $valu['suitable_temperature_to'] && $value['have_watering_misting'] == 0))
																{
																	{?>
																		<div class="del_img_demo_2"></div>
																	<?php }
																}
															}
														}
														elseif($value['virtual_dev_days'] == 0){
															if(($valu['crop_id'] == $value["crop_id"]) && ($valu['start_day'] <= $value["dev_days"]) && ($valu['end_day'] >= $value["dev_days"]) && $val1['land_id'] == $value["id"]){
																if((($val1['humidity_from'] + $val1['humidity_to'])/2 < $valu['suitable_humidity_from'] && $value['have_drip_irrigation'] == 0) || (($val1['temperature_from'] + $val1['temperature_to'])/2 > $valu['suitable_temperature_to'] && $value['have_watering_misting'] == 0))
																{
																	{?>
																		<div class="del_img_demo_2"></div>
																	<?php }
																}
															}
														}

													}
												}
												?></div>
											</div>
										</br></br>
										<div><a rea href="{!! URL::route('admin.lands.getchangePH', $value['id'])!!}" title="Điều chỉnh độ PH" ><input style="width: 203px" class="btn action" value="Điều chỉnh độ PH của đất"></a><?php
										foreach ($stage as $valu){ // lấy giai đoạn hiện tại của cây trồng
											foreach ($weather as $val1) {
												if($value['virtual_dev_days'] != 0){
													if(($valu['crop_id'] == $value["crop_id"]) && ($valu['start_day'] <= $value["virtual_dev_days"]) && ($valu['end_day'] >= $value["virtual_dev_days"]) && $val1['land_id'] == $value["id"])
													{
														if(isset($val1['light']) && isset($val1['temperature_from']) && isset($val1['humidity_from']) && isset($val1['ph'])){
															if(($val1['ph'] > $valu['suitable_ph_to'] && $value['have_decreased_pH'] != 1) || ($val1['ph'] < $valu['suitable_ph_from'] && $value['have_increased_pH'] != 1)){
																{?>
																	<div class="del_img_demo_3"></div>
																<?php }
															}
														}
													}
												}
												elseif($value['virtual_dev_days'] == 0){
													if(($valu['crop_id'] == $value["crop_id"]) && ($valu['start_day'] <= $value["dev_days"]) && ($valu['end_day'] >= $value["dev_days"]) && $val1['land_id'] == $value["id"])
													{
														if(isset($val1['light']) && isset($val1['temperature_from']) && isset($val1['humidity_from']) && isset($val1['ph'])){
															if(($val1['ph'] > $valu['suitable_ph_to'] && $value['have_decreased_pH'] != 1) || ($val1['ph'] < $valu['suitable_ph_from'] && $value['have_increased_pH'] != 1)){
																{?>
																	<div class="del_img_demo_3"></div>
																<?php }
															}
														}
													}
												}
											}
											} // end foreach
											?></div>

										</p>
									</div>
									<label style="color: blue" for="">Lời khuyên (Giai đoạn)</label>

									<?php
									foreach ($stage as $valu){
										foreach ($follow_fer as $val) {
											if($value['virtual_dev_days'] != 0){
												if(($value['crop_id'] == $valu['crop_id']) && ($valu['start_day'] <= $value["virtual_dev_days"]) && ($valu['end_day'] >= $value["virtual_dev_days"]) && ($value['id'] == $val['id_land']))
												{
															// bước trên đã lấy dc giai đoạn hiện tại của cây trồng, record theo dõi bón phân của land
															// tiếp theo lấy record theo dõi bón phân của giai đoạn đó
													if($valu['numerical_order'] == $val['numerical_order'] && $val['have_fer'] == 0)
													{
														{?>
															<div class="loikuyen_1"><p>Bạn chưa bón loại phân thích hợp cho cây trồng tại giai đoạn hiện tại. Hãy bón phân cho cây trồng của bạn!</p>
															</div>
														<?php }
													}
												}
											}
											elseif($value['virtual_dev_days'] == 0){
												if(($value['crop_id'] == $valu['crop_id']) && ($valu['start_day'] <= $value["dev_days"]) && ($valu['end_day'] >= $value["dev_days"]) && ($value['id'] == $val['id_land']))
												{
															// bước trên đã lấy dc giai đoạn hiện tại của cây trồng, record theo dõi bón phân của land
															// tiếp theo lấy record theo dõi bón phân của giai đoạn đó
													if($valu['numerical_order'] == $val['numerical_order'] && $val['have_fer'] == 0)
													{
														{?>
															<div class="loikuyen_1"><p>Bạn chưa bón loại phân thích hợp cho cây trồng tại giai đoạn hiện tại. Hãy bón phân cho cây trồng của bạn!</p>
															</div>
														<?php }
													}
												}
											}
										}
									}
									?>
								</div>
								<div class="col-md-5">
									<label for="">Ngày phát triển: <?= $value["dev_days"] ?></label>
									<?php
									foreach ($weather as $val1) {
										if($val1['land_id'] == $value["id"])
										{
											{?></br>
												<label for="">Ánh sáng: <?php if(isset($val1['light'])) echo $val1['light'] ?></label></br>
												<label for="">Nhiệt độ: <?php if(isset($val1['temperature_from'])) echo $val1['temperature_from']."&ordmC"." - ".$val1['temperature_to']."&ordmC"; ?></label></br>
												<label for="">Độ ẩm:    <?php if(isset($val1['humidity_from'])) echo $val1['humidity_from']."%"." - ".$val1['humidity_to']."%"; ?></label></br>
												<label for="">Độ ph:    <?php if(isset($val1['ph'])) echo $val1['ph'] ?>
											</label></br>
										<?php }
									}
								}
								?>

								<?php
										foreach ($stage as $valu){ // lấy giai đoạn hiện tại của cây trồng
											foreach ($weather as $val1) {
												if($value['virtual_dev_days'] != 0){
													if(($valu['crop_id'] == $value["crop_id"]) && ($valu['start_day'] <= $value["virtual_dev_days"]) && ($valu['end_day'] >= $value["virtual_dev_days"]) && $val1['land_id'] == $value["id"])
													{
														if(isset($val1['light']) && isset($val1['temperature_from']) && isset($val1['humidity_from']) && isset($val1['ph'])){
															if($val1['light'] != $valu['suitable_light'] && $val1['light'] != 'Tốt'){
																{?>
																	<button style="font-size: 12px; width: 160px; height: 40px; margin: 4px" class="btn thongbao">Ánh sáng không thích hợp</button></br>
																<?php }
															}
															if($val1['ph'] > $valu['suitable_ph_to']){
																{?>
																	<button style="font-size: 12px; width: 160px; height: 40px; margin: 4px" class="btn thongbao">Độ ph cao hơn mức</button></br>
																<?php }
															}
															if($val1['ph'] < $valu['suitable_ph_from']){
																{?>
																	<button style="font-size: 12px; width: 160px; height: 40px; margin: 4px" class="btn thongbao">Độ ph thấp hơn mức</button></br>
																<?php }
															}
															if($val1['temperature_to'] > $valu['suitable_temperature_to'] && $value['have_watering_misting'] == 0){
																{?>
																	<button style="font-size: 12px; width: 160px; height: 40px; margin: 4px" class="btn thongbao">Nhiệt độ cao hơn mức</button></br>
																<?php }
															}
															if($val1['temperature_from'] < $valu['suitable_temperature_from'] && $value['have_watering_misting'] == 0){
																{?>
																	<button style="font-size: 12px; width: 160px; height: 40px; margin: 4px" class="btn thongbao">Nhiệt độ thấp hơn mức</button></br>
																<?php }
															}
															if($val1['humidity_to'] > $valu['suitable_humidity_to'] && $value['have_drip_irrigation'] == 0){
																{?>
																	<button style="font-size: 12px; width: 160px; height: 40px; margin: 4px" class="btn thongbao">Độ ẩm cao hơn mức</button></br>
																<?php }
															}
															if($val1['humidity_from'] < $valu['suitable_humidity_from'] && $value['have_drip_irrigation'] == 0){
																{?>
																	<button style="font-size: 12px; width: 160px; height: 40px; margin: 4px" class="btn thongbao">Độ ẩm thấp hơn mức</button></br>
																<?php }
															}
														}

													}
												}
												elseif($value['virtual_dev_days'] == 0){
													if(($valu['crop_id'] == $value["crop_id"]) && ($valu['start_day'] <= $value["dev_days"]) && ($valu['end_day'] >= $value["dev_days"]) && $val1['land_id'] == $value["id"])
													{
														if(isset($val1['light']) && isset($val1['temperature_from']) && isset($val1['humidity_from']) && isset($val1['ph'])){
															if($val1['light'] != $valu['suitable_light'] && $val1['light'] != 'Tốt'){
																{?>
																	<button style="font-size: 12px; width: 160px; height: 40px; margin: 4px" class="btn thongbao">Ánh sáng không thích hợp</button></br>
																<?php }
															}
															if($val1['ph'] > $valu['suitable_ph_to']){
																{?>
																	<button style="font-size: 12px; width: 160px; height: 40px; margin: 4px" class="btn thongbao">Độ ph cao hơn mức</button></br>
																<?php }
															}
															if($val1['ph'] < $valu['suitable_ph_from']){
																{?>
																	<button style="font-size: 12px; width: 160px; height: 40px; margin: 4px" class="btn thongbao">Độ ph thấp hơn mức</button></br>
																<?php }
															}
															if($val1['temperature_to'] > $valu['suitable_temperature_to'] && $value['have_watering_misting'] == 0){
																{?>
																	<button style="font-size: 12px; width: 160px; height: 40px; margin: 4px" class="btn thongbao">Nhiệt độ cao hơn mức</button></br>
																<?php }
															}
															if($val1['temperature_from'] < $valu['suitable_temperature_from'] && $value['have_watering_misting'] == 0){
																{?>
																	<button style="font-size: 12px; width: 160px; height: 40px; margin: 4px" class="btn thongbao">Nhiệt độ thấp hơn mức</button></br>
																<?php }
															}
															if($val1['humidity_to'] > $valu['suitable_humidity_to'] && $value['have_drip_irrigation'] == 0){
																{?>
																	<button style="font-size: 12px; width: 160px; height: 40px; margin: 4px" class="btn thongbao">Độ ẩm cao hơn mức</button></br>
																<?php }
															}
															if($val1['humidity_from'] < $valu['suitable_humidity_from'] && $value['have_drip_irrigation'] == 0){
																{?>
																	<button style="font-size: 12px; width: 160px; height: 40px; margin: 4px" class="btn thongbao">Độ ẩm thấp hơn mức</button></br>
																<?php }
															}
														}
													}
												}
											}
											} // end foreach
											?>


											<label style="color: blue" for="">Lời khuyên (Hằng ngày)</label>
											<?php
										foreach ($stage as $valu){ // lấy giai đoạn hiện tại của cây trồng
											foreach ($weather as $val1) {
												if($value['virtual_dev_days'] != 0){
													if(($valu['crop_id'] == $value["crop_id"]) && ($valu['start_day'] <= $value["virtual_dev_days"]) && ($valu['end_day'] >= $value["virtual_dev_days"]) && $val1['land_id'] == $value["id"])
												{
													if(isset($val1['light']) && isset($val1['temperature_from']) && isset($val1['humidity_from']) && isset($val1['ph'])){
														//if($val1['light'] != $valu['suitable_light'] && $val1['light'] != 'Tốt'){
															// Vì ta cũng không can thiệp được và thay đổi ánh sáng dc nên thông báo về ánh sáng sẽ dc tạm bỏ qua
														//}
														if($val1['ph'] > $valu['suitable_ph_to'] && $value['have_decreased_pH'] == 0){
															{?>
																<div class="loikuyen"><p>Độ PH của đất đang cao hơn mức thích hợp cho cây trồng của bạn. Hãy điều chỉnh để giảm độ PH</p></div>
															<?php }
														}
														if($val1['ph'] < $valu['suitable_ph_from'] && $value['have_increased_pH'] == 0){
															{?>
																<div class="loikuyen"><p>Độ PH của đất đang thấp hơn mức thích hợp cho cây trồng của bạn. Hãy điều chỉnh để tăng độ PH.</p></div>
															<?php }
														}
														if(($val1['temperature_from'] + $val1['temperature_to'])/2 > $valu['suitable_temperature_to'] && $value['have_watering_misting'] == 0){
															// hiện tại đang cho là lớn hơn hẳn hoặc bé hơn hẳn
															{?>
																<div class="loikuyen"><p>Nhiệt độ đang cao hơn mức thích hợp cho cây trồng của bạn. Bạn có thể tưới phun sương để hạ nhiệt độ môi trường xuống.</p></div>
															<?php }
														}
														if(($val1['temperature_to'] + $val1['temperature_from'])/2 < $valu['suitable_temperature_from'] && $value['have_watering_misting'] == 0){
															{?>
																<div class="loikuyen"><p>Nhiệt độ đang thấp hơn mức thích hợp cho cây trồng. Tuy nhiên nó không ảnh hưởng nhiều đến cây trồng của bạn!</p></div>
															<?php }
														}
														// đối với độ ẩm thì ta sẽ lấy trung bình của thời điểm 1h trước và hiện tại để so sánh với khoảng độ ẩm thích hợp với cây trồng
														if(($val1['humidity_from'] + $val1['humidity_to'])/2 > $valu['suitable_humidity_to'] && $value['have_drip_irrigation'] == 0){
															{?>
																<div class="loikuyen"><p>Độ ẩm của đất đang cao hơn mức thích hợp cho cây trồng của bạn. Bạn không cần phải tưới nước cho cây vào thời điểm này!</p></div>
															<?php }
														}
														if(($val1['humidity_from'] + $val1['humidity_to'])/2 < $valu['suitable_humidity_from'] && $value['have_drip_irrigation'] == 0){
															{?>
																<div class="loikuyen"><p>Độ ẩm của đất đang thấp hơn mức thích hợp cho cây trồng của bạn. Bạn có thể tưới nước để tăng độ ẩm của đất lên.</p></div>
															<?php }
														}
													}
												}
												}
													elseif($value['virtual_dev_days'] == 0){
												if(($valu['crop_id'] == $value["crop_id"]) && ($valu['start_day'] <= $value["dev_days"]) && ($valu['end_day'] >= $value["dev_days"]) && $val1['land_id'] == $value["id"])
												{
													if(isset($val1['light']) && isset($val1['temperature_from']) && isset($val1['humidity_from']) && isset($val1['ph'])){
														//if($val1['light'] != $valu['suitable_light'] && $val1['light'] != 'Tốt'){
															// Vì ta cũng không can thiệp được và thay đổi ánh sáng dc nên thông báo về ánh sáng sẽ dc tạm bỏ qua
														//}
														if($val1['ph'] > $valu['suitable_ph_to'] && $value['have_decreased_pH'] == 0){
															{?>
																<div class="loikuyen"><p>Độ PH của đất đang cao hơn mức thích hợp cho cây trồng của bạn. Hãy điều chỉnh để giảm độ PH</p></div>
															<?php }
														}
														if($val1['ph'] < $valu['suitable_ph_from'] && $value['have_increased_pH'] == 0){
															{?>
																<div class="loikuyen"><p>Độ PH của đất đang thấp hơn mức thích hợp cho cây trồng của bạn. Hãy điều chỉnh để tăng độ PH.</p></div>
															<?php }
														}
														if(($val1['temperature_from'] + $val1['temperature_to'])/2 > $valu['suitable_temperature_to'] && $value['have_watering_misting'] == 0){
															// hiện tại đang cho là lớn hơn hẳn hoặc bé hơn hẳn
															{?>
																<div class="loikuyen"><p>Nhiệt độ đang cao hơn mức thích hợp cho cây trồng của bạn. Bạn có thể tưới phun sương để hạ nhiệt độ môi trường xuống.</p></div>
															<?php }
														}
														if(($val1['temperature_to'] + $val1['temperature_from'])/2 < $valu['suitable_temperature_from'] && $value['have_watering_misting'] == 0){
															{?>
																<div class="loikuyen"><p>Nhiệt độ đang thấp hơn mức thích hợp cho cây trồng. Tuy nhiên nó không ảnh hưởng nhiều đến cây trồng của bạn!</p></div>
															<?php }
														}
														// đối với độ ẩm thì ta sẽ lấy trung bình của thời điểm 1h trước và hiện tại để so sánh với khoảng độ ẩm thích hợp với cây trồng
														if(($val1['humidity_from'] + $val1['humidity_to'])/2 > $valu['suitable_humidity_to'] && $value['have_drip_irrigation'] == 0){
															{?>
																<div class="loikuyen"><p>Độ ẩm của đất đang cao hơn mức thích hợp cho cây trồng của bạn. Bạn không cần phải tưới nước cho cây vào thời điểm này!</p></div>
															<?php }
														}
														if(($val1['humidity_from'] + $val1['humidity_to'])/2 < $valu['suitable_humidity_from'] && $value['have_drip_irrigation'] == 0){
															{?>
																<div class="loikuyen"><p>Độ ẩm của đất đang thấp hơn mức thích hợp cho cây trồng của bạn. Bạn có thể tưới nước để tăng độ ẩm của đất lên.</p></div>
															<?php }
														}
													}
												}
												}
											}
											} // end foreach
											?>

											<?php
											$vitri = 0;
											foreach ($stage as $val) {
												if($value['virtual_dev_days'] != 0) {
													if(($val['crop_id'] == $value["crop_id"]) && ($val['start_day'] <= $value["virtual_dev_days"]) && ($val['end_day'] >= $value["virtual_dev_days"])){
														$vitri = $val['numerical_order'];
														{?>
															<label style="color: blue" for=""><?= '</br>'.$val['name'] ?></label>
														<?php }
														foreach ($crops as $val) {
															if(($val['id'] == $value['crop_id']) && ($val['quantity_max_stages_dev'] == $vitri))
															{
													//echo $val['quantity_max_stages_dev'];
													//echo $val['name'];
																{?>
																	<a href="{!! URL::route('admin.lands.getHarvest', $value['id'])!!}"><button style="font-size: 20px; width: 150px; height: 50px" class="btn btn-success"> Thu hoạch</button></a>
																<?php }
															}
														}
													}
												}
												elseif(($val['crop_id'] == $value["crop_id"]) && ($val['start_day'] <= $value["dev_days"]) && ($val['end_day'] >= $value["dev_days"]))
												{	//$vitri = $val['numerical_order'];
											$vitri = $val['numerical_order'];
											{?>
												<label style="color: blue" for=""><?= '</br>'."Cây đang ở ".$val['name'] ?></label>
											<?php }
											foreach ($crops as $val) {
												if(($val['id'] == $value['crop_id']) && ($val['quantity_max_stages_dev'] == $vitri))
												{
													{?>
														<a href="{!! URL::route('admin.lands.getHarvest', $value['id'])!!}"><button style="font-size: 20px; width: 150px; height: 50px" class="btn btn-success"> Thu hoạch</button></a>
													<?php }
												}
											}


										} // end if
									}

									?>
								</div>
							</div>

						</div>
					</div>
				</div> <!-- end card -->
			</div>
		<?php }
	}
	if($value['crop_id'] == 0)
	{
		{?>
			<div class="card-deck-wrapper">
				<div class="card-deck">
					<div id="ban" class="col-md-5">
						<div class="card">
							<div class="row">
								<div class="col-md-7">
									<div class="card-block">
										<h4 class="card-title ten"><a href="{!! URL::route('admin.lands.getDetail', $value['id'])!!}"><b style="color: blue"><?= $value["name"] ?></b></a></h4>

									</br></br>
									<p class="card-text editns">
										<button class="btn btn-outline-success"><a href="{!! URL::route('admin.lands.getEdit', $value['id'])!!}" title="Bón phân" > Cập nhật <i class="far fa-edit"></i></a></button>
									</p>
									<p class="card-text tuoi">Tình Trạng:
										<label style="color: blue" for="">Land trống</label></p>
										<div class="col-md-5">
										</div>
									</div>

								</div>
							</div>
						</div> <!-- end card -->

					</div>
				<?php }
			}

			?>


		<?php endforeach ?>
	</div>
</div>
</br>
<div class="row">
	<div class="col-md-5"></div>
	<div class="col-md-4" >
		{{ $lands->links() }}
	</div>
</div>

 	<!-- </div>
 	</div>
 -->
</div>
<style type="text/css">
	#ban {
		border: 1px solid green;
		-moz-border-radius: 10px;
		-webkit-border-radius: 10px;
		margin: 5px;
	}
	.tt{
		margin-left: 230px;
	}
</style>
<style type="text/css">
	img {
		border-radius:2%;
		-moz-border-radius:2%;
		-webkit-border-radius:5%;
	}
	.loikuyen{
		margin: 3px;
		padding: 5px;
		color: #006899;
		border: solid 1px #006899;
		background: white;
		border-radius: 5px
	}
	.loikuyen:hover{
		margin: 3px;
		padding: 5px;
		color: white;
		border: solid 1px #006899;
		background: #006899;
		border-radius: 5px
	}
	.loikuyen_1{
		margin: 3px;
		padding: 5px;
		width: 220px;
		color: #006899;
		border: solid 1px #006899;
		background: white;
		border-radius: 5px
	}
	.loikuyen_1:hover{
		margin: 3px;
		padding: 5px;
		width: 220px;
		color: white;
		border: solid 1px #006899;
		background: #006899;
		border-radius: 5px
	}
	.del_img_demo_1{
		position: relative; top: -38px;left: 88px;
		width: 10px;
		height: 10px;
		background: #FE2E2E;
		-moz-border-radius: 5px;
		-webkit-border-radius: 5px;
		--border-radius: 5px;
		border-radius: 5px;

	}
	.del_img_demo_2{
		position: relative; top: -38px;left: 89px;
		width: 10px;
		height: 10px;
		background: #FE2E2E;
		-moz-border-radius: 5px;
		-webkit-border-radius: 5px;
		--border-radius: 5px;
		border-radius: 5px;

	}
	.del_img_demo_3{
		position: relative; top: -38px;left: 199px;
		width: 10px;
		height: 10px;
		background: #FE2E2E;
		-moz-border-radius: 5px;
		-webkit-border-radius: 5px;
		--border-radius: 5px;
		border-radius: 5px;

	}
	.tang{
		color: white;
		background:#006899;
	}
	.tang:hover{
		color: white;
		background:#008F68;
	}
	.thongbao{
		color: white;
		background:#FF9900;
	}
	.thongbao:hover{
		color: #DB5800;
		background:#FFF056;
	}
	.action{
		color: white;
		background:#006899;
	}
	.action:hover{
		color: white;
		background:#008F68;
	}
</style>
@endsection