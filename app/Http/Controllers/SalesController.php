<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\ClientStatus;
use App\CompanyDetails;
use App\Airlines;
use App\SalesReport;
use Carbon\Carbon;
use DB;

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
        $data['clients'] = clientStatus::all();

        return view('public/sales_revenue', $data);
    }
    // Create revenue
    public function createRevenue(Request $request)
    {
        $data['AGENT'] = $this->AGENT;
        $data['page_title'] = 'Create Sales Revenue Performance';
        $data['airlines_dom'] = Airlines::where('area', '=', 'domestic')->get();
        $data['airlines_int'] = Airlines::where('area', '=', 'international')->get();
        $data['tour'] = array('Umrah', 'Moslem Tour', 'Regular/Series', 'Incentive Tour');
        $data['others'] = array('Paspor', 'Visa', 'Hotel', 'Transportation');
        $data['client_status'] = ClientStatus::all();

        return view('public/sales_revenue_create', $data);
    }

    public function doCreateRevenue(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'sales_client_id' => 'required',
            'report_type' => 'required',
            'subject' => 'required',
            'gross' => 'required',
            'netto' => 'required',
            'profit' => 'required',
            'month' => 'required'
        ]);

        $agent = $this->AGENT;

        if($validator->passes()){
            $salesReport = new SalesReport;
            $salesReport->sales_client_id = $request->sales_client_id;
            $salesReport->report_type = $request->report_type;
            $salesReport->subject = $request->subject;
            $salesReport->gross = str_replace(',', '', $request->gross);
            $salesReport->netto = str_replace(',', '', $request->netto);
            $salesReport->profit = str_replace(',', '', $request->profit);
            $salesReport->month = date('Y-m-d', strtotime('1-'.$request->month));
            $salesReport->save();

            return redirect('sales/revenue');
        }

        return redirect('sales/revenue/create')->withErrors($validator)->withInput();        
    }
    /**
     * API
     */
    public function m2m(Request $request)
    {
        $client = $request->client;
        $month1 = date('Y-m-d', strtotime('1-'.$request->month1));
        $month2 = date('Y-m-d', strtotime('1-'.$request->month2));

        $montharr = get_months($month1, $month2.('+1 month'));
        foreach(array_keys($montharr) as $year)
        {
            foreach($montharr[$year] as $month)
            {
                $months[] = date('F Y', strtotime("{$year}-{$month}"));
            }
        }
        
        if($client != 0){
            // Corporate selected
            if(count($months) == 2){
                // mode 1
                $data['report'] = SalesReport::whereBetween('month', [$month1, $month2])
                        ->where('sales_client_id', $client)
                        ->get();

                $data['mode'] = 1;
                $data['table'] = array();

                foreach($data['report'] as $key => $value){
                    $data['table'][$value->report_type][$value->subject][] = array(
                        'month' => $value->month,
                        'gross' => $value->gross,
                        'netto' => $value->netto,
                        'profit' => $value->profit,
                    );
                }
            }else{
                // mode 2
                $data['report'] = SalesReport::whereBetween('month', [$month1, $month2])
                        ->where('sales_client_id', $client)
                        ->select(DB::raw('sum(gross) as sum_gross'), DB::raw('sum(netto) as sum_netto'), DB::raw('sum(profit) as sum_profit'), 'month')
                        ->groupBy('month')->get();
                
                foreach($data['report'] as $key => $value){
                    $data['report'][$key]['sum_gross'] = number_format($value['sum_gross'],0,',',',');
                    $data['report'][$key]['sum_netto'] = number_format($value['sum_netto'],0,',',',');
                    $data['report'][$key]['sum_profit'] = number_format($value['sum_profit'],0,',',',');
                    $data['report'][$key]['month'] = date('F Y', strtotime($value['month']));
                }

                $data['mode'] = 2;
                
                for($i = 1; $i < count($data['report']); $i++){
                    $diff = str_replace(',', '', $data['report'][$i]['sum_profit'])-str_replace(',', '', $data['report'][$i-1]['sum_profit']);
                    $data['differentials'][] = number_format($diff, 0, ',', ',');
                    $perc = ($diff / (str_replace(',', '', $data['report'][$i-1]['sum_profit']) / 100));
                    $data['percents'][] = round($perc);
                }
                
                array_unshift($data['differentials'], '');
                array_unshift($data['percents'], '');
            }

            $reportSum = DB::table('sales_report')
                            ->select('id', DB::raw('SUM(profit) as sum_profit'), 'month')
                            ->where('sales_client_id', $client)
                            ->whereBetween('month', [$month1, $month2])
                            ->groupBy('month')->get();

            $data['company'] = ClientStatus::where('id', $client)->get();

        }else{
            // All
            if(count($months) == 2){
                // mode 1
                $data['report'] = SalesReport::whereBetween('month', [$month1, $month2])
                        ->get();
                $data['mode'] = 1;
                $data['table'] = array();

                foreach($data['report'] as $key => $value){
                    $data['table'][$value->report_type][$value->subject][] = array(
                        'month' => $value->month,
                        'gross' => $value->gross,
                        'netto' => $value->netto,
                        'profit' => $value->profit,
                    );
                }
            }else{
                $data['report'] = SalesReport::whereBetween('month', [$month1, $month2])
                        ->select(DB::raw('sum(gross) as sum_gross'), DB::raw('sum(netto) as sum_netto'), DB::raw('sum(profit) as sum_profit'), 'month')
                        ->groupBy('month')->get();
                
                foreach($data['report'] as $key => $value){
                    $data['report'][$key]['sum_gross'] = number_format($value['sum_gross'],0,',',',');
                    $data['report'][$key]['sum_netto'] = number_format($value['sum_netto'],0,',',',');
                    $data['report'][$key]['sum_profit'] = number_format($value['sum_profit'],0,',',',');
                    $data['report'][$key]['month'] = date('F Y', strtotime($value['month']));
                }

                $data['mode'] = 2;
                
                for($i = 1; $i < count($data['report']); $i++){
                    $diff = str_replace(',', '', $data['report'][$i]['sum_profit'])-str_replace(',', '', $data['report'][$i-1]['sum_profit']);
                    $data['differentials'][] = number_format($diff, 0, ',', ',');
                    $perc = ($diff / (str_replace(',', '', $data['report'][$i-1]['sum_profit']) / 100));
                    $data['percents'][] = round($perc);
                }
                
                array_unshift($data['differentials'], '');
                array_unshift($data['percents'], '');
            }

            $reportSum = DB::table('sales_report')
                            ->select('id', DB::raw('SUM(profit) as sum_profit'), 'month')
                            ->whereBetween('month', [$month1, $month2])
                            ->groupBy('month')->get();
        }
        
        foreach($reportSum as $item){
            $chart_data[] = $item->sum_profit;
            $labels[] = date('F Y', strtotime($item->month));
        }

        $data['chart'] = array(
            'labels' => $labels,
            'datasets' => array(
                array(
                    'label' => 'Profit',
                    'borderColor' => '#1abc9c',
                    'fill' => 'false',
                    'data' => $chart_data
                )
            )
        );

        return response()->json($data);
    }

    
    public function y2y(Request $request)
    {

    }
    /**
     * Client
     */
    public function clientStatus(Request $request, $id = NULL)
    {
        $data['AGENT'] = $this->AGENT;
        $data['page_title'] = 'Client Status';
        
        if($id){
            $data['client'] = clientStatus::find($id);
            $data['details'] = CompanyDetails::where('sales_client_id', '=', $id)->get();
            
            return view('public/sales_client_detail', $data);    
        }

        $data['clients'] = clientStatus::all();

        return view('public/sales_client', $data);
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
    // Update Client
    public function updateClient(Request $request, $id)
    {
        $data['AGENT'] = $this->AGENT;
        $data['page_title'] = 'Edit Client Status';

        $data['client'] = clientStatus::find($id);
        $data['details'] = CompanyDetails::where('sales_client_id', '=', $id)->get();

        return view('public/sales_client_update', $data);
    }
    
    public function doUpdateClient(Request $request, $id)
    {
        if($id){
        
        $validator = Validator::make($request->all(), [
            'classification' => 'required',
            'name_of_company' => 'required'
        ]);

        $agent = $this->AGENT;

        if($validator->passes()){
            $client = ClientStatus::find($id);
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

            $delDetails = CompanyDetails::where('sales_client_id', '=', $id)->delete();

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

        return redirect('sales/client-status');
    }
    // Delete Client 
    public function deleteClient(Request $request, $id)
    {
        if(!$id){
            return response()->json(['success' => false]);
        }

        $client = ClientStatus::find($id);
        $client->delete();

        $delDetails = CompanyDetails::where('sales_client_id', '=', $id)->delete();

        return response()->json(['success' => true]);
    }
}
