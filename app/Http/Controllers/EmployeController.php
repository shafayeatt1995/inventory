<?php

namespace App\Http\Controllers;

use App\Employe;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class EmployeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employes = Employe::latest()->get();
        return view('employe.index', compact('employes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('employe.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:50',
            'email' => 'required|max:50|unique:employes',
            'phone' => 'required|max:14|unique:employes',
            'address' => 'required',
            'nid' => 'required|max:18|unique:employes',
            'salary' => 'required',
        ]);

        $image = $request->file('image');
        if (isset($image)) {
            $slug = str_slug($request->name);
            $currentdate = Carbon::now()->toDateString();
            $tempName = $slug . '-' . $currentdate . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
            $path = 'public/images/employe/';
            $imagename = $path . $tempName;
            $image->move($path, $imagename);
        } else {
            $imagename = 'public/images/user.png';
        }
//
//        $slug = str_slug($request->name);
//        if (isset($image))
//        {
//            //make unique name for image
//            $currentdate = Carbon::now()->toDateString();
//            $imagename = $slug.'-'.$currentdate.'-'.uniqid().'.'.$image->getClientOriginalExtension();
//
//            //Check Employe folder if exist
//            if (!Storage::disk('public')->exists('employe'))
//            {
//                Storage::disk('public')->makeDirectory('employe');
//            }
//            //Employe Image Upload
//            $employeImage = Image::make($image)->save($image->getClientOriginalExtension());
//            Storage::disk('public')->put('employe/'.$imagename,$employeImage);
//        }
//        else
//        {
//            $imagename = "default.png";
//        }

        $employe = new Employe();
        $employe->name = $request->name;
        $employe->email = $request->email;
        $employe->phone = $request->phone;
        $employe->address = $request->address;
        $employe->nid = $request->nid;
        $employe->experience = $request->experience;
        $employe->salary = $request->salary;
        $employe->holiday = $request->holiday;
        $employe->image = $imagename;
        $employe->save();
        Toastr::success('Employe Successfully Added', 'Success');
        return redirect()->route('employe.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employe = Employe::find($id);
        return view('employe.show', compact('employe'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employe = Employe::find($id);
        return view('employe.edit', compact('employe'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employe $employe)
    {
        $this->validate($request, [
            'name' => 'required|max:50',
            'email' => 'required|max:50',
            'phone' => 'required|max:14',
            'address' => 'required',
            'nid' => 'required|max:18',
            'salary' => 'required',
        ]);

        $image = $request->file('image');
        if (isset($image)) {
            if ($employe->image == 'public/images/user.png') {

            } else {
                unlink($employe->image);
            }
            $slug = str_slug($request->name);
            $currentdate = Carbon::now()->toDateString();
            $tempName = $slug . '-' . $currentdate . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
            $path = 'public/images/employe/';
            $imagename = $path . $tempName;
            $image->move($path, $imagename);
        } else {
            $imagename = $employe->image;
        }

        $employe->name = $request->name;
        $employe->email = $request->email;
        $employe->phone = $request->phone;
        $employe->address = $request->address;
        $employe->nid = $request->nid;
        $employe->experience = $request->experience;
        $employe->image = $imagename;
        $employe->salary = $request->salary;
        $employe->holiday = $request->holiday;
        $employe->save();
        return redirect()->route('employe.index')->with('success', 'Employe Successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employe $employe)
    {
        if ($employe->image == 'public/images/user.png') {

        } else {
            unlink($employe->image);
        }
        $employe->delete();
        Toastr::success('Employe Successfully deleted', 'Success');
        return redirect()->back();
    }
}
