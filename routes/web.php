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
        //test halaman slider
        Route::get('/test', function() {
          return view('layout.test');
        });
        Route::get('/info', function() {
          return view('layout.test');
        });
        // Elearning
        Route::get('/', 'PagesController@index');
        Route::get('/elearning', 'PagesController@elearning');
        Route::get('/berita', 'PagesController@berita');
        Route::get('/persebaran', 'PagesController@persebaran');
        Route::get('/detailuser', 'PagesController@detailuser');
        Route::get('/editprofile', 'PagesController@editprofile');
        Route::get('/createkontenberbagi', 'PagesController@createkontenberbagi');
        Route::get('/linimasaberbagi', 'PagesController@linimasaberbagi');
        Route::get('/materibasic', 'PagesController@materibasic');
        Route::get('/materiadvanced', 'PagesController@materiadvanced');
        Route::get('/detailmateri', 'PagesController@detailmateri');
        Route::get('/login', 'PagesController@login');
        Route::get('/daftar', 'PagesController@register');
        Route::get('/resetpassword', 'PagesController@resetpassword');
        Route::get('/createnewpassword', 'PagesController@createNewPassword');
        Route::get('/pendampingan', 'PagesController@pendampingan');
        Route::get('/dashboard/rapor', 'PagesController@rapor');
        Route::get('/detailkonten', 'PagesController@detailkonten');
        Route::get('/pageuser', 'PagesController@pageUser');
        Route::get('/publickonten', 'PagesController@publickonten');
        Route::get('/grupsekolah' , 'PagesController@grupsekolah');

        Route::get('/sekolah/detail', function() {
          return view('detailSekolah');
        });

        // Assesor
        Route::get('/assessor/login', 'AssesorController@assessorLogin');
        Route::get('/assessor/rapor/createrapor/', 'AssesorController@createrapor');
        Route::get('/assessor/rapor/listuser/', 'AssesorController@listuser');
        Route::get('/assessor/rapor/listraporuser/', 'AssesorController@listraporuser');
        Route::get('/assessor/rapor/detailrapor/', 'AssesorController@detailrapor');
        Route::get('/assessor/pendampingan/listuser', 'AssesorController@pendampinganListUser');
        Route::get('/assessor/pendampingan/pagependampingan', 'AssesorController@pendampinganPage');

        Route::get('/assessor/tantangan', function() {
          return view('assessor.quiz.index');
        });

        Route::get('/assessor/tantangan/detail', function() {
          return view('assessor.quiz.detail');
        });

        Route::get('/assessor/tantangan/review', function() {
          return view('assessor.quiz.review');
        });

        // Dashboard

        Route::get('/dashboard', function() {
            return view('dashboard.home');
        });

        Route::get('/dashboard/home', function() {
          return view('dashboard.home');
        });

        Route::get('/dashboard/login', function() {
          return view('dashboard.auth.login');
        });

        Route::get('/dashboard/forgot-password', function() {
          return view('dashboard.auth.password.email');
        });

        Route::get('/dashboard/modul/add', function() {
          return view('dashboard.modul.add');
        });

        Route::get('/dashboard/modul/basic', function() {
          return view('dashboard.modul.index-basic');
        });

        Route::get('/dashboard/modul/advanced', function() {
          return view('dashboard.modul.index-advanced');
        });

        Route::get('/dashboard/modul/edit', function() {
          return view('dashboard.modul.edit');
        });

        Route::get('/dashboard/quiz', function() {
          return view('dashboard.quiz.index');
        });

        Route::get('/dashboard/quiz/review', function() {
          return view('dashboard.quiz.review');
        });

        Route::get('/dashboard/user', function() {
          return view('dashboard.user.index');
        });

        Route::get('/dashboard/user/detail', function() {
          return view('dashboard.user.detail');
        });

        Route::get('/dashboard/user/quiz/detail', function() {
          return view('dashboard.quiz.detail');
        });

        Route::get('/dashboard/assessor', function() {
          return view('dashboard.user.assessor.index');
        });

        Route::get('/dashboard/assessor/detail', function() {
          return view('dashboard.user.detail');
        });

        Route::get('/dashboard/request/assessor', function() {
          return view('dashboard.permintaan.mentor.request');
        });

        Route::get('/dashboard/request/sekolah', function() {
          return view('dashboard.permintaan.sekolah.request');
        });

        Route::get('/dashboard/sekolah/model', function() {
          return view('dashboard.sekolah.index-model');
        });

        Route::get('/dashboard/sekolah/emodel', function() {
          return view('dashboard.sekolah.index-emodel');
        });

        Route::get('/dashboard/sekolah/jejaring', function() {
          return view('dashboard.sekolah.index-jejaring');
        });

        Route::get('/dashboard/sekolah/indonesia', function() {
          return view('dashboard.sekolah.index-indonesia');
        });

        Route::get('/dashboard/sekolah/detail', function() {
          return view('dashboard.sekolah.detail');
        });

        Route::get('/dashboard/raporbyassessor/listassessor', function() {
          return view('dashboard.rapor.raporbyassessor');
        });

        Route::get('/dashboard/raporbyassessor/listuser', function() {
          return view('dashboard.rapor.listuser');
        });

        Route::get('/dashboard/raporbyassessor/listraporuser', function() {
          return view('dashboard.rapor.listraporuser');
        });

        Route::get('/dashboard/raporbyassessor/detailrapor', function() {
          return view('dashboard.rapor.detailrapor');
        });

        Route::get('/dashboard/rapor/sekolah', function() {
          return view('dashboard.rapor.sekolah.indexSekolah');
        });

        Route::get('/dashboard/rapor/sekolah/create', function() {
          return view('dashboard.rapor.sekolah.createRaporSekolah');
        });

        Route::get('/dashboard/rapor/sekolah/list-rapor', function() {
          return view('dashboard.rapor.sekolah.listRapor');
        });

        Route::get('/dashboard/rapor/sekolah/list-rapor/detail-rapor-user', function() {
          return view('dashboard.rapor.sekolah.detailRaporUser');
        });

        Route::get('/dashboard/rapor/sekolah/list-rapor/detail-rapor-sekolah', function() {
          return view('dashboard.rapor.sekolah.detailRaporSekolah');
        });

        Route::get('/dashboard/kupon', function() {
          return view('dashboard.kupon.index');
        });

        Route::get('/dashboard/kupon/add', function() {
          return view('dashboard.kupon.add');
        });
