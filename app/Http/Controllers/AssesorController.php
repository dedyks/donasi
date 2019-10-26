<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AssesorController extends Controller
{
    public function assessorLogin(){
        return view('assessor/login');
    }

    public function createrapor(){
        return view('assessor/rapor/createRapor');
    }

    public function listuser(){
        return view('assessor/rapor/listUser');
    }

    public function listraporuser(){
        return view('assessor/rapor/listraporuser');
    }

    public function detailrapor(){
        return view('assessor/rapor/detailrapor');
    }

    public function pendampinganListUser(){
        return view('assessor/pendampingan/listUser');
    }

    public function pendampinganPage(){
        return view('assessor/pendampingan/pagePendampingan');
    }

}
