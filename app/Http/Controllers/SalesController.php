<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\ClientStatus;
use App\CompanyDetails;

class SalesController extends Controller
{
    protected $AGENT = array();
    
    public function __construct()
    {
        $this->AGENT = session()->get("login_data");    
    }
    /**
     * Revenue
     */
    public function revenue(Request $request)
    {
        $data['AGENT'] = $this->AGENT;
        $data['page_title'] = 'Sales Revenue Performance';

        return view('public/sales_revenue', $data);
    }
    // Create revenue
    public function createRevenue(Request $request)
    {
        $data['AGENT'] = $this->AGENT;
        $data['page_title'] = 'Create Sales Revenue Performance';

        return view('public/sales_revenue_create', $data);
    }
    /**
     * Client
     */
    public function clintStatus(Request $request)
    {
        
    }
    // Create Client
    public function createClient(Request $request)
    {
        $data['AGENT'] = $this->AGENT;
        $data['page_title'] = 'Add Client Status';

        return view('public/sales_client_create', $data);
    }

    public function doCreateClient(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'classification' => 'required',
            'name_of_company' => 'required'
        ]);

        $agent = $this->AGENT;

        if($validator->passes()){
            $client = new ClientStatus;
            $client->classification = $request->classification;
            $client->name_of_company = $request->name_of_company;
            $client->phone = $request->phone;
            $client->fax = $request->fax;
            $client->email = $request->email;
            $client->website = $request->website;
            $client->kind_of_business = $request->kind_of_business;
            $client->number_of_employee = $request->number_of_employee;
            $client->bank_account = $request->bank_account;
            $client->address = $request->address;
            $client->other_office_location = $request->other_office_location;
            $client->date_of_assign = $request->date_of_assign;
            $client->sales_rep = $request->sales_rep;
            $client->manager = $request->manager;
            $client->remarks = $request->remarks;
            $client->save();

            $id = $client->id;
            $data = array();

            for($i = 1; $i < count($request->pic); $i++){
                $data[] = array(
                    'sales_client_id' => $id,
                    'pic' => $request->pic[$i],
                    'title' => $request->title[$i],
                    'date_of_birth' => $request->dob[$i],
                    'date_of_join' => $request->doj[$i],
                    'phone' => $request->phonePIC[$i],
                    'ext' => $request->ext[$i],
                    'other_information' => $request->comments[$i],
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                );
            }

            $companyDetails = CompanyDetails::insert($data);

            return redirect('sales/client-status');

        }

        return redirect('sales/client-status')->withErrors($validator)->withInput();
    }
}
