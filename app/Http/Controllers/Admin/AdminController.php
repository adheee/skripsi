<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index() //menampilkan hal. data user
    {
    	return view(''); //struktur folder di folder views
    	/*
    	syntax
    	return view('namafolder.namafile');
    	*/
    }
}
