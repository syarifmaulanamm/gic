<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Airlines;

class AirlinesController extends Controller
{
    protected $AGENT = array();
    
    public function __construct()
    {
        $this->AGENT = session()->get("login_data");    
    }
    
    public function index(Request $request)
    {
        $data['AGENT'] = $this->AGENT;
        $data['page_title'] = 'Airlines';
        $data['domestic'] = Airlines::where('area', '=', 'domestic')->get();
        $data['international'] = Airlines::where('area', '=', 'international')->get();

        return view('public/airlines', $data);
    }

    public function create(Request $request)
    {
        $data['AGENT'] = $this->AGENT;
        $data['page_title'] = 'Add Airlines';

        return view('public/airlines_create', $data);
    }

    public function doCreate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required',
            'name' => 'required',
            'area' => 'required'
        ]);

        if($validator->passes()){
            $vendor = new Airlines;
            $vendor->code = $request->code;
            $vendor->name = $request->name;
            $vendor->area = $request->area;
            $vendor->save();

            return redirect('airlines');
        }

        return redirect('airlines/create')->withErrors($validator)->withInput();
    }
}
