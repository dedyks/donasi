<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index(){
        return view('welcome2');
    }
    public function elearning(){
        return view('elearning3');
    }
    public function berita(){
        return view('berita');
    }
    public function persebaran(){
        return view('persebaran');
    }
    public function detailuser(){
        return view('detailuser');
    }
    public function editprofile(){
        return view('editprofile');
    }
    public function createkontenberbagi(){
        return view('uploadperubahan');
    }
    public function linimasaberbagi(){
        return view('perubahangurulain');
    }
    public function materibasic(){
        return view('materibasic');
    }
    public function materiadvanced(){
        return view('materiadvanced');
    }
 
    public function detailmateri(){
        return view('detailmateri');
    }

    public function login(){
        return view('page/login');
    }

    public function register(){
        return view('page/register');
    }

    public function resetpassword(){
        return view('page/resetpassword');
    }

    public function createNewPassword(){
        return view('page/createNewPassword');
    }

    public function pendampingan(){
        return view('pendampingan');
    }

    public function grupsekolah(){
        return view('grupSekolah');
    }

    public function detailkonten(){
        return view('detailKonten');
    }

    public function pageUser(){
        return view('pageUser');
    }

    public function rapor(){
        return view('dashboard/rapor/createRapor');
    }

    public function publickonten(){
        return view('publickontenberbagi');
    }
}
