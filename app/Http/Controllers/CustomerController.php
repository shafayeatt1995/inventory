<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Employe;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::latest()->get();
        return view('customer.index',compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('customer.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name'=>'required|max:50',
            'email'=>'required|max:50',
            'phone'=>'required|max:14',
            'address'=>'required',
            'shopName'=>'required',
            'accountHolder'=>'required',
            'accountNumber'=>'required|unique:customers',
            'bankName'=>'required',
            'bankBranch'=>'required',
            'bkashNumber'=>'required|unique:customers',
        ]);

        $image = $request->file('image');
        $slug = str_slug($request->name);
        if (isset($image))
        {
            //make unique name for image
            $currentdate = Carbon::now()->toDateString();
            $imagename = $slug.'-'.$currentdate.'-'.uniqid().'.'.$image->getClientOriginalExtension();

            //Check Employe folder if exist
            if (!Storage::disk('public')->exists('customer'))
            {
                Storage::disk('public')->makeDirectory('customer');
            }
            //Employe Image Upload
            $customerImage = Image::make($image)->save($image->getClientOriginalExtension());
            Storage::disk('public')->put('customer/'.$imagename,$customerImage);
        }
        else
        {
            $imagename = "default.png";
        }

        $customer = new Customer();
        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->phone = $request->phone;
        $customer->address = $request->address;
        $customer->shopName = $request->shopName;
        $customer->accountHolder = $request->accountHolder;
        $customer->accountNumber = $request->accountNumber;
        $customer->bankName = $request->bankName;
        $customer->bankBranch = $request->bankBranch;
        $customer->bkashNumber = $request->bkashNumber;
        $customer->image = $imagename;
        $customer->save();
        Toastr::success('Customer Successfully Added','Success');
        return redirect()->route('customer.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        return view('customer.show',compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        return view('customer.edit',compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        $this->validate($request,[
            'name'=>'required|max:50',
            'email'=>'required|max:50',
            'phone'=>'required|max:14',
            'address'=>'required',
            'shopName'=>'required',
            'accountHolder'=>'required',
            'accountNumber'=>'required',
            'bankName'=>'required',
            'bankBranch'=>'required',
            'bkashNumber'=>'required',
        ]);

        $image = $request->file('image');
        $slug = str_slug($request->name);
        if (isset($image))
        {
            //make unique name for image
            $currentdate = Carbon::now()->toDateString();
            $imagename = $slug.'-'.$currentdate.'-'.uniqid().'.'.$image->getClientOriginalExtension();

            //Delete Customer Old Photo
            if (Storage::disk('public')->exists('customer/'.$customer->image))
            {
                Storage::disk('public')->delete('customer/'.$customer->image);
            }
            //Employe Image Upload
            $customerImage = Image::make($image)->save($image->getClientOriginalExtension());
            Storage::disk('public')->put('customer/'.$imagename,$customerImage);
        }
        else
        {
            $imagename = $customer->image;
        }

        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->phone = $request->phone;
        $customer->address = $request->address;
        $customer->shopName = $request->shopName;
        $customer->accountHolder = $request->accountHolder;
        $customer->accountNumber = $request->accountNumber;
        $customer->bankName = $request->bankName;
        $customer->bankBranch = $request->bankBranch;
        $customer->bkashNumber = $request->bkashNumber;
        $customer->image = $imagename;
        $customer->save();
        Toastr::success('Customer Successfully Updated','Success');
        return redirect()->route('customer.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        //
    }
}
