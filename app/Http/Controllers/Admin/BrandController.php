<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Brand;
use Session;

class BrandController extends Controller
{
    public function brand()
    {
        Session::put('page', 'brands');
        $brandData = Brand::get();
        // $brandData = json_decode(json_encode($brandData), true);
        // echo "<pre>"; print_r($brandData); die;
        return view('admin.brands.brands')->with(compact('brandData'));

    }

        //update Brand status
    public function updateBrandStatus(Request $request)
    {
            if($request->ajax())
            {
                $data = $request->all();
                
                if($data['status']=="Active")
                {
                    $status = 0;
                }else
                {
                    $status = 1;
                }
            }
            Brand::Where('id', $data['brand_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status, 'brand_id'=>$data['brand_id']]);
    }

    public function addEditBrand(Request $request, $id=null)
    {
        if($id=="")
        {
            $title="Add Brand";
            $message="Brand Added Successfully";
            $brand = New Brand;
        }else
        {
            $title="Edit Brand";
            $message="Brand Updated Successfully";
            $brand = Brand::find($id);
        }

        if($request->isMethod('post'))
        {
        $data = $request->all();
        // dd($data);
            
        $rules = [
            'brand_name' => 'required|regex:/^[\pL\s\-]+$/u',
        ];
        $customMessages = [
            'brand_name.required' => 'Name is required',
            'brand_name.regex' => 'Valid name is required',
        ];

        $this->validate($request, $rules, $customMessages);

        $brand->name = $data['brand_name'];
        $brand->status = 1;
        $brand->save();

        Session::flash('success_message', $message);
        return redirect('/admin/brands');
        
        }

        return view('admin.brands.add_edit_brands')->with(compact('title', 'brand'));
    }

    public function deleteBrand($id)
    {
        Brand::where('id', $id)->delete();

        Session::flash('success_message', 'Brand Deleted Successfully');
        return redirect()->back();
    }
}
