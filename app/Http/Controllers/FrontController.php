<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\URL;
 
class FrontController extends Controller
{
   public function index(Request $request)
   {
    return view('index');
   }



   public function showview(Request $req)
   {
      
      return view('welcome');
   }
}
