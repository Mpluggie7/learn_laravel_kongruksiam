<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use Carbon\Carbon;

class ServiceController extends Controller
{
    public function index() {
        $services = Service::paginate(3);
        return view('admin.service.index', compact('services'));
    }

    public function store(Request $request) {
        $request->validate([
            'service_name' => 'required|unique:services|max:255',
            'service_image' => 'required|mimes:jpg,jpeg,png'
        ],
        [
            'service_name.required' => 'Service name must be not empty',
            'service_name.max' => 'Service name must less than 256',
            'service_name.unique' => 'Duplicate name of Service',
            'service_image.required' => 'Service image must be added',
        ]);

        $service_image = $request->file('service_image');
        $name_gen = hexdec(uniqid());
        $img_ext = strtolower($service_image->getClientOriginalExtension());
        // dd($img_ext);

        $img_name = $name_gen.".".$img_ext;
        // dd($img_name);

        // upload and insert
        $upload_location = 'image/services/';
        $full_path = $upload_location.$img_name;
        
        Service::insert([
            'service_name'=>$request->service_name,
            'service_image'=>$full_path,
            'created_at'=>Carbon::now()
        ]);

        $service_image->move($upload_location, $img_name);

        return redirect()->back()->with('success', 'Save and upload file completely');
    }

    public function edit($id) {
        $service = Service::find($id);
        return view('admin.service.edit', compact('service'));
    }

    public function update(Request $request, $id) {
        $request->validate([
            'service_name' => 'max:255|required'
        ],
        [
            'service_name.required' => 'Service name must be not empty',
            'service_name.max' => 'Service name must less than 256'
        ]);

        $service_image = $request->file('service_image');
        
        // update both image and name
        if ($service_image) {

            $name_gen = hexdec(uniqid());
            $img_ext = strtolower($service_image->getClientOriginalExtension());
            $img_name = $name_gen.".".$img_ext;
            $upload_location = 'image/services/';
            $full_path = $upload_location.$img_name;

            Service::find($id)->update([
                'service_name'=>$request->service_name,
                'service_image'=>$full_path
            ]);
    
            $old_image = $request->old_image;
            unlink($old_image);
            $service_image->move($upload_location, $img_name);

            return redirect()->route('service')->with('success', 'Update service completely');

        // update only image
        } else {
            Service::find($id)->update([
                'service_name'=>$request->service_name
            ]);
            return redirect()->route('service')->with('success', 'Update service completely');
        };
    }

    public function delete($id) {
        $image = Service::find($id)->service_image;
        unlink($image);
        $delete = Service::find($id)->Delete();
        return redirect()->back()->with('success', 'Delete completely');
    }
}
