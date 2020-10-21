<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});//->middleware('auth');

Route::get('homeindex',['as'=>'homepage', 'uses'=>'Home_Controller@Index']);
Route::get('adminpage',['as'=>'adminpage', 'uses'=>'Home_Controller@Admin']);

Route::group(['prefix'=>'admin'], function()
{
	Route::group(['prefix'=>'crops'], function()
		{
			Route::get('delete/{id}',['as'=>'admin.crops.getDelete', 'uses'=>'Crops_Controller@getDelete']);
			Route::get('detail/{id}',['as'=>'admin.crops.getDetail', 'uses'=>'Crops_Controller@getDetail']);
			Route::get('edit/{id}',['as'=>'admin.crops.getEdit', 'uses'=>'Crops_Controller@getEdit']);
			Route::post('edit/{id}',['as'=>'admin.crops.postEdit', 'uses'=>'Crops_Controller@postEdit']);
			Route::get('add',['as'=>'admin.crops.getadd', 'uses'=>'Crops_Controller@getAdd']);
			Route::post('add',['as'=>'admin.crops.postadd', 'uses'=>'Crops_Controller@postAdd']);
			Route::get('edit/{id}',['as'=>'admin.crops.getEdit', 'uses'=>'Crops_Controller@getEdit']);
			Route::post('edit/{id}',['as'=>'admin.crops.postEdit', 'uses'=>'Crops_Controller@postEdit']);
			Route::get('list',['as'=>'admin.crops.getlist', 'uses'=>'Crops_Controller@getList']);
			Route::post('search',['as'=>'admin.crops.postSearch', 'uses'=>'Crops_Controller@postSearch']);
	});

	Route::group(['prefix'=>'seasons'], function()
		{
			Route::get('edit/{id}',['as'=>'admin.seasons.getEdit', 'uses'=>'Seasons_Controller@getEdit']);
			Route::post('edit/{id}',['as'=>'admin.seasons.postEdit', 'uses'=>'Seasons_Controller@postEdit']);
			Route::get('detail/{id}',['as'=>'admin.seasons.getDetail', 'uses'=>'Seasons_Controller@getDetail']);
			Route::get('delete/{id}',['as'=>'admin.seasons.getDelete', 'uses'=>'Seasons_Controller@getDelete']);
			Route::get('list',['as'=>'admin.seasons.getlist', 'uses'=>'Seasons_Controller@getList']);
			Route::get('add',['as'=>'admin.seasons.getadd', 'uses'=>'Seasons_Controller@getAdd']);
			Route::post('add',['as'=>'admin.seasons.postadd', 'uses'=>'Seasons_Controller@postAdd']);
			Route::post('search',['as'=>'admin.seasons.postSearch', 'uses'=>'Seasons_Controller@postSearch']);
	});

	Route::group(['prefix'=>'lands'], function()
		{
			Route::get('add',['as'=>'admin.lands.getadd', 'uses'=>'Lands_Controller@getAdd']);
			Route::post('add',['as'=>'admin.lands.postadd', 'uses'=>'Lands_Controller@postAdd']);
			Route::get('edit/{id}',['as'=>'admin.lands.getEdit', 'uses'=>'Lands_Controller@getEdit']);
			Route::post('edit/{id}',['as'=>'admin.lands.postEdit', 'uses'=>'Lands_Controller@postEdit']);
			Route::get('delete/{id}',['as'=>'admin.lands.getDelete', 'uses'=>'Lands_Controller@getDelete']);
			Route::get('list',['as'=>'admin.lands.getlist', 'uses'=>'Lands_Controller@getList']);
			Route::get('detail/{id}',['as'=>'admin.lands.getDetail', 'uses'=>'Lands_Controller@getDetail']);

			// Lấy list land theo farm
			Route::get('listbyfarm/{id}',['as'=>'admin.lands.getlistByFarm', 'uses'=>'Lands_Controller@getlistByFarm']);

			Route::get('increase',['as'=>'admin.lands.getIncrease', 'uses'=>'Lands_Controller@increase_Day_dev']);
			Route::get('increase10',['as'=>'admin.lands.getIncrease10', 'uses'=>'Lands_Controller@increase_Day_dev10']);
			Route::get('increase20',['as'=>'admin.lands.getIncrease20', 'uses'=>'Lands_Controller@increase_Day_dev20']);
			Route::get('reset',['as'=>'admin.lands.getResetDevDay', 'uses'=>'Lands_Controller@getResetDevDay']);
			Route::get('harvest/{id}',['as'=>'admin.lands.getHarvest', 'uses'=>'Lands_Controller@getHarvest']);
			Route::post('harvest/{id}',['as'=>'admin.lands.postHarvest', 'uses'=>'Lands_Controller@postHarvest']);

			Route::get('listHarvest',['as'=>'admin.lands.getlistHarvestHarvest', 'uses'=>'Lands_Controller@getlistHarvestHarvest']);
			Route::get('create_condition',['as'=>'admin.weather.create_condition', 'uses'=>'Lands_Controller@Create_weather_condition']);
			Route::get('watering/{id}',['as'=>'admin.lands.getWatering', 'uses'=>'Lands_Controller@getWatering']);
			Route::post('watering/{id}',['as'=>'admin.lands.postWatering', 'uses'=>'Lands_Controller@postWatering']);
			Route::get('fer/{id}',['as'=>'admin.lands.getFer', 'uses'=>'Lands_Controller@getFer']);
			Route::post('fer/{id}',['as'=>'admin.lands.postFer', 'uses'=>'Lands_Controller@postFer']);

			Route::get('changeph/{id}',['as'=>'admin.lands.getchangePH', 'uses'=>'Lands_Controller@getchangePH']);
			Route::post('changeph/{id}',['as'=>'admin.lands.postchangePH', 'uses'=>'Lands_Controller@postchangePH']);
	});
	Route::group(['prefix'=>'fertilizers'], function()
		{
			Route::get('delete/{id}',['as'=>'admin.fertilizers.getDelete', 'uses'=>'Fertilizers_Controller@getDelete']);
			Route::get('detail/{id}',['as'=>'admin.fertilizers.getDetail', 'uses'=>'Fertilizers_Controller@getDetail']);
			Route::get('edit/{id}',['as'=>'admin.fertilizers.getEdit', 'uses'=>'Fertilizers_Controller@getEdit']);
			Route::post('edit/{id}',['as'=>'admin.fertilizers.postEdit', 'uses'=>'Fertilizers_Controller@postEdit']);
			Route::get('add',['as'=>'admin.fertilizers.getadd', 'uses'=>'Fertilizers_Controller@getAdd']);
			Route::post('add',['as'=>'admin.fertilizers.postadd', 'uses'=>'Fertilizers_Controller@postAdd']);
			Route::get('list',['as'=>'admin.fertilizers.getlist', 'uses'=>'Fertilizers_Controller@getList']);
			// Lấy list land theo farm
			Route::get('listbyfarm/{id}',['as'=>'admin.fertilizers.getlistByFarm', 'uses'=>'Fertilizers_Controller@getlistByFarm']);
	});
	Route::group(['prefix'=>'sourceofwater'], function()
		{
			Route::get('edit/{id}',['as'=>'admin.sourceofwater.getEdit', 'uses'=>'SourceOfwater_Controller@getEdit']);
			Route::post('edit/{id}',['as'=>'admin.sourceofwater.postEdit', 'uses'=>'SourceOfwater_Controller@postEdit']);
			Route::get('delete/{id}',['as'=>'admin.sourceofwater.getDelete', 'uses'=>'SourceOfwater_Controller@getDelete']);
			Route::get('list',['as'=>'admin.sourceofwater.getlist', 'uses'=>'SourceOfwater_Controller@getList']);
			Route::get('add',['as'=>'admin.sourceofwater.getadd', 'uses'=>'SourceOfwater_Controller@getAdd']);
			Route::post('add',['as'=>'admin.sourceofwater.postadd', 'uses'=>'SourceOfwater_Controller@postAdd']);
			Route::get('detail/{id}',['as'=>'admin.sourceofwater.getDetail', 'uses'=>'SourceOfwater_Controller@getDetail']);
			// Lấy list land theo farm
			Route::get('listbyfarm/{id}',['as'=>'admin.sourceofwater.getlistByFarm', 'uses'=>'SourceOfwater_Controller@getlistByFarm']);
	});

	Route::group(['prefix'=>'farm'], function()
		{
			Route::get('edit/{id}',['as'=>'admin.farm.getEdit', 'uses'=>'Farm@getEdit']);
			Route::post('edit/{id}',['as'=>'admin.farm.postEdit', 'uses'=>'Farm@postEdit']);
			Route::get('detail/{id}',['as'=>'admin.farm.getDetail', 'uses'=>'Farm@getDetail']);
	});
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
//route resource
//chèn html vào xử lý controller
//Html: decode
// jquery với kiểu dữ liệu json
// input với array