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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::group(['middleware' => 'web'],function(){
  Route::auth();
  Route::any('/','HomeController@index');
});
Route::resource('/teacher','teacherController');
Route::resource('/student','studentController');
// Route::get('/teacher','teacherController@index');
// Route::post('/teacher','teacherController@addSubject');
Route::resource('/subject','subjectController');
Route::resource('/studentSubject','studentSubjectController');
Route::resource('/practice','practiceController');
Route::resource('/checkExercise','checkExerciseController');
Route::resource('/studentPractice','studentPracticeController');
Route::resource('/makePDF','makePDFcontroller');
Route::get('/getuser',function(){
  //$get = Auth::user();
  dd(Auth::user());
  //var_dump($get->name);
});
