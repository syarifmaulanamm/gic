<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Po;
use App\PoVendor;
use App\PoItem;

class PoController extends Controller
{
    protected $AGENT = array();
    
    public function __construct()
    {
        $this->AGENT = session()->get("login_data");    
    }
    /** Purchase Order **/
    // Index
    public function index(Request $request)
    {
        $data['AGENT'] = $this->AGENT;
        $data['page_title'] = 'Purchase Order';
        
        if($data['AGENT']['role'] == 1 || $data['AGENT']['role'] == 2){
            $data['po_pending'] = Po::whereIn('status', array(0,1,2))->orderBy('id', 'desc')->get();           
            $data['po_approved'] = Po::where('status', '=', 3)->orderBy('id', 'desc')->get();            
            $data['po_completed'] = Po::where('status', '=', 4)->orderBy('id', 'desc')->get();            
            $data['po_rejected'] = Po::where('status', '=', 5)->orderBy('id', 'desc')->get();    
        }else if($data['AGENT']['role'] == 3){
            $data['po_approval'] = Po::where('status', '=', 1)->orderBy('id', 'desc')->get();             
            $data['po_pending'] = Po::whereIn('status', array(0,1,2))->orderBy('id', 'desc')->get();           
            $data['po_approved'] = Po::where('status', '=', 3)->orderBy('id', 'desc')->get();            
            $data['po_completed'] = Po::where('status', '=', 4)->orderBy('id', 'desc')->get();            
            $data['po_rejected'] = Po::where('status', '=', 5)->orderBy('id', 'desc')->get();                                
        }else if($data['AGENT']['role'] == 4){
            $data['po_approval'] = Po::where('status', '=', 0)->orderBy('id', 'desc')->get();             
            $data['po_pending'] = Po::whereIn('status', array(0,1,2))->orderBy('id', 'desc')->get();           
            $data['po_approved'] = Po::where('status', '=', 3)->orderBy('id', 'desc')->get();            
            $data['po_completed'] = Po::where('status', '=', 4)->orderBy('id', 'desc')->get();            
            $data['po_rejected'] = Po::where('status', '=', 5)->orderBy('id', 'desc')->get();            
        }else if($data['AGENT']['role'] == 5){                  
            $data['po_approval'] = Po::where('issued_by', '=', $data['AGENT']['email'])->where('status', '=', 0)->orderBy('id', 'desc')->get();             
            $data['po_pending'] = Po::where('issued_by', '=', $data['AGENT']['email'])->whereIn('status', array(0,1,2))->orderBy('id', 'desc')->get();           
            $data['po_approved'] = Po::where('issued_by', '=', $data['AGENT']['email'])->where('status', '=', 3)->orderBy('id', 'desc')->get();            
            $data['po_completed'] = Po::where('issued_by', '=', $data['AGENT']['email'])->where('status', '=', 4)->orderBy('id', 'desc')->get();            
            $data['po_rejected'] = Po::where('issued_by', '=', $data['AGENT']['email'])->where('status', '=', 5)->orderBy('id', 'desc')->get();       
        }else if($data['AGENT']['role'] == 6){
            $data['po_approval'] = Po::where('status', '=', 2)->orderBy('id', 'desc')->get();             
            $data['po_pending'] = Po::whereIn('status', array(0,1,2))->orderBy('id', 'desc')->get();           
            $data['po_approved'] = Po::where('status', '=', 3)->orderBy('id', 'desc')->get();            
            $data['po_completed'] = Po::where('status', '=', 4)->orderBy('id', 'desc')->get();            
            $data['po_rejected'] = Po::where('status', '=', 5)->orderBy('id', 'desc')->get();                               
        }

        return view('public/po', $data);
    }
    // Create
    public function create(Request $request)
    {
        $data['AGENT'] = $this->AGENT;
        $data['page_title'] = 'Create Purchase Order';
        $data['vendors'] = PoVendor::all();
        
        return view('public/po_create', $data);
    }
    
    public function doCreate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'vendor_id' => 'required'
        ]);

        $agent = $this->AGENT;

        if($validator->passes()){
            // PO
            $po = new Po;
            $po->title = $request->title;
            $po->vendor_id = $request->vendor_id;
            $po->delivery = $request->delivery;
            $po->shipment_to = $request->shipment_to;
            $po->freight = $request->freight;
            $po->insurance = $request->insurance;
            $po->payment = $request->payment;
            $po->total = $request->total;
            // $po->tax = $request->tax;
            $po->issued_by = $agent['email'];
            $po->status = 0;
            $po->save();

            $id = $po->id;
            $data = array();
            // ITEMS
            for($i = 1; $i < count($request->nameItem); $i++){
                $data[] = array(
                    'po_id' => $id,
                    'name' => $request->nameItem[$i],
                    'quantity' => $request->quantity[$i],
                    'price' => $request->price[$i],
                    'amount' => $request->amount[$i],
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                );
            }
            $item = PoItem::insert($data);

            return redirect('po');
        }

        return redirect('po/create')->withErrors($validator)->withInput();
    }

    // Read
    public function read(Request $request, $id)
    {
        $data['AGENT'] = $this->AGENT;
        $data['page_title'] = 'Purchase Order Detail';
        $data['po'] = Po::find($id);

        $data['items'] = PoItem::where('po_id','=',$id)->get();

        return view('public/po_read', $data);
    }
    // Approval
    public function approval(Request $request, $id)
    {
        if($id){
            if($request->type == 'approve'){
                $po = Po::find($id);
                if($po->status < 4){
                    $po->status = $po->status+1;
                }
                $po->save();
            }else if($request->type == 'reject'){
                $po = Po::find($id);
                $po->status = 5;
                $po->save();
            }

            return response()->json(['success' => true]);
        }
        
        return response()->json(['success' => false]);
    }

    // Update
    public function update(Request $request, $id)
    {
        if($id){
            $data['AGENT'] = $this->AGENT;
            $data['page_title'] = 'Edit Purchase Order';
            $data['vendors'] = PoVendor::all();
            $data['po'] = Po::find($id);
            $data['items'] = PoItem::where('po_id','=',$id)->get();
            
            return view('public/po_update', $data);
        }

        return redirect('po');
    }

    public function doUpdate(Request $request, $id)
    {
        if($id){
            $validator = Validator::make($request->all(), [
                'id' => 'required',
                'title' => 'required',
                'vendor_id' => 'required'
            ]);

            $agent = $this->AGENT;

            if($validator->passes()){
                // PO
                $po = Po::find($id);
                $po->title = $request->title;
                $po->vendor_id = $request->vendor_id;
                $po->delivery = $request->delivery;
                $po->shipment_to = $request->shipment_to;
                $po->freight = $request->freight;
                $po->insurance = $request->insurance;
                $po->payment = $request->payment;
                $po->total = $request->total;
                // $po->tax = $request->tax;
                $po->issued_by = $agent['email'];
                $po->save();

                $id = $po->id;
                $data = array();
                // ITEMS
                $resetItem = PoItem::where('po_id', '=', $id)->delete();

                for($i = 1; $i < count($request->nameItem); $i++){
                    $data[] = array(
                        'po_id' => $id,
                        'name' => $request->nameItem[$i],
                        'quantity' => $request->quantity[$i],
                        'price' => $request->price[$i],
                        'amount' => $request->amount[$i],
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    );
                }
                $item = PoItem::insert($data);

                return redirect('po');
            }

            return redirect('po/update')->withErrors($validator)->withInput();
        }

        return redirect('po');
    }

    /** Vendor **/
    // index
    public function vendor(Request $request)
    {
        $data['AGENT'] = $this->AGENT;
        $data['page_title'] = 'Vendor';
        $data['vendors'] = PoVendor::all();

        return view('public/vendor', $data);
    }
    
    // Create
    public function createVendor(Request $request)
    {
        $data['AGENT'] = $this->AGENT;
        $data['page_title'] = 'Add Vendor';

        return view('public/vendor_create', $data);
    }

    public function doCreateVendor(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required'
        ]);

        if($validator->passes()){
            $vendor = new PoVendor;
            $vendor->name = $request->name;
            $vendor->email = $request->email;
            $vendor->phone = $request->phone;
            $vendor->address = $request->address;
            $vendor->save();

            return redirect('po/vendor');
        }

        return redirect('po/vendor/create')->withErrors($validator)->withInput();
    }

    public function updateVendor(Request $request, $id)
    {
        if(!$id){
            return redirect('po/vendor');
        }

        $data['AGENT'] = $this->AGENT;
        $data['page_title'] = 'Edit Vendor';
        $data['vendor'] = PoVendor::find($id);

        return view('public/vendor_update', $data);
    }

    public function doUpdateVendor(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required'
        ]);

        if($validator->passes()){
            $vendor = PoVendor::find($request->id);
            $vendor->name = $request->name;
            $vendor->email = $request->email;
            $vendor->phone = $request->phone;
            $vendor->address = $request->address;
            $vendor->save();

            return redirect('po/vendor');
        }

        return redirect('po/vendor/update/'.$request->id)->withErrors($validator)->withInput();
    }

    public function deleteVendor(Request $request, $id)
    {
        if(!$id){
            return response()->json(['success' => false]);
        }

        $vendor = PoVendor::find($id);
        $vendor->delete();

        return response()->json(['success' => true]);
    }

    // API Vendor
    public function APIGetVendor(Request $request, $id)
    {
        if(!$id){
            return response()->json(['success' => false]);
        }

        $vendor = PoVendor::find($id);
        return response()->json(['success' => true, 'data' => $vendor]);
    }

    // Item
    // Read Item
    public function readItem(Request $request, $id)
    {
        if($id){
            $item = PoItem::find($id);
            $item->price = number_format($item->price,0, "", ",");
            $item->amount = number_format($item->amount,0, "", ",");

            if($item){
                return response()->json(['success' => 'true', 'msg' => 'Success!', 'data' => $item]);
            }
            return response()->json(['success' => 'false', 'msg' => 'Something went wrong!']);            
        }
    }
    // Create
    public function createItem(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'quantity' => 'required',
            'price' => 'required',
            'amount' => 'required'
        ]);

        if($validator->passes()){
            $price = explode(".", $request->price);
            $priceClear = str_replace(',', '', $price[0]);
            $amount = explode(".", $request->amount);
            $amountClear = str_replace(',', '' , $amount[0]);

            $item = new PoItem;
            $item->po_id = $request->poID;
            $item->name = $request->name;
            $item->quantity = $request->quantity;
            $item->price = $priceClear;
            $item->amount = $amountClear;
            $item->save();

            $item->price = number_format($item->price,0, "", ",");
            $item->amount = number_format($item->amount,0, "", ",");
            
            $total = number_format(PoItem::where('po_id', '=', $request->poID)->sum('amount'), 0, "", ",");

            return response()->json(['success' => 'true', 'msg' => 'Data has been saved!', 'data' => $item, 'total' => $total]);
        }

        return response()->json(['error'=>$validator->errors()->all()]);
    }
    // Delete Item
    public function deleteItem(Request $request, $id)
    {
        if($id){
            $item = PoItem::find($id);
            $item->delete();

            $total = number_format(PoItem::where('po_id', '=', $item->po_id)->sum('amount'), 0, "", ",");
            
            return response()->json(['success' => 'true', 'msg' => 'Data has been deleted!', 'total' => $total]);            
        }

        return response()->json(['success' => 'false', 'msg' => 'Something went wrong!']);                    
    }
}