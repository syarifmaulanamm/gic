<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Goods;

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
        $data['page_title'] = 'Home';
        // All Goods
        $data['goods'] = Goods::all();
        // Out Of Stock
        $data['oos'] = Goods::where('in_stock', 1)
                                ->where('stock', '<', 1)
                                ->get();
        // Less Stock
        $data['lessStock'] = Goods::where('in_stock', 1)
                                    ->where('stock', '<=', 50)
                                    ->get();

        return view('home', $data);
    }
}
