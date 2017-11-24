<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $AGENT = array();

    public function __construct()
    {
        $this->AGENT = session()->get("login_data");    
    }
    // Dashboard
    public function index(Request $request)
    {
        $data['AGENT'] = $this->AGENT;

        return view('home', $data);
    }
}
