<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Features;
use Session;
use File;

class FeaturesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Features::get();
        return view('Admin.Features.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.Features.create');
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
            'name'=>'required',
            'image'=>'required|mimes:svg'
        ]);

        $data = $request->all();

        if ($request->file('image')) {
            $file = $request->file('image');
            $filename = 'Features-' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(storage_path('app/public/features/'), $filename);
            $data['image'] = $filename;
        }

        $features = new Features();
        $features->fill($data);
        if($features->save()){
            Session::flash('message','<div class="alert alert-success">Feature Created Successfully.!! </div>');
            return redirect('master-admin/features');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Features::findorFail($id);
        return view('Admin.Features.edit',compact('data','id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'name'=>'required',
            'image'=>'mimes:svg',
            'status'=>'required'
        ]);

        $data = $request->all();
        $data = $request->except('_token', '_method');

        if ($request->file('image')) {

            $oldimage = Features::where('id', $id)->value('image');

            if (!empty($oldimage)) {

                File::delete('storage/app/public/features/' . $oldimage);
            }

            $file = $request->file('image');
            $filename = 'Features-' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move('storage/app/public/features', $filename);
            $data['image'] = $filename;
        }

        $update = Features::where('id',$id)->update($data);

        if($update){
            Session::flash('message','<div class="alert alert-success">Features Updated Successfully.!! </div>');
            return redirect('master-admin/features');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $oldimage = Features::where('id', $id)->value('image');

        if (!empty($oldimage)) {

            File::delete('storage/app/public/features/' . $oldimage);
        }



        $delete = Features::where('id',$id)->delete();
        if($delete){
            Session::flash('message', '<div class="alert alert-danger"><strong>Alert!</strong> Feature Deleted successfully. </div>');

            return redirect('master-admin/features');
        }
    }

    public function statusChange($id){
        $users  = Features::findorFail($id);

        if($users['status'] == 'active'){
            $newStatus = 'inactive';
        } else {
            $newStatus = 'active';
        }

        $update = Features::where('id',$id)->update(['status'=>$newStatus]);

        if($update){
            Session::flash('message', '<div class="alert alert-success"><strong>Success!</strong> Features status updated successfully. </div>');

            return redirect('master-admin/features');
        }
    }
}
