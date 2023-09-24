<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Banner;
use Session;
use Image;

class BannersController extends Controller
{
    public function banner()
    {
        Session::put('page', 'banners');
        $bannerData = Banner::get()->toArray();
        return view('admin.banners.banners')->with(compact('bannerData'));
    }

    //update banner status
    public function updateBannerStatus(Request $request)
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
        Banner::Where('id', $data['banner_id'])->update(['status'=>$status]);
        return response()->json(['status'=>$status, 'banner_id'=>$data['banner_id']]);
    }

    //delete banner
    public function deleteBanner($id)
    {
        Banner::where('id', $id)->delete();
        Session::flash('success_message', 'Banner Deleted Successfully');
        return redirect()->back();
    }

    public function addEditBanner(Request $request, $id=null)
    {
        if($id == "") 
        {
            $title = "Add Banner";
            $banner = new Banner;
            $bannerData = array();
            $message = "Banner Added Successfully";
            $sub_btn_name = "Submit";

        }else
        {
            $title = "Edit Banner";
            $bannerData = Banner::where('id', $id)->get()->first();
            $banner = Banner::find($id);
            $message = "Banner updated Successfully";
            $sub_btn_name = "Update";
        }

        if($request->isMethod('post'))
        {
            $data = $request->all();
           
            $rules = 
            [
                'banner_image' => 'required',
                'banner_link' => 'required|regex:/^[\pL\s\-]+$/u',
                'banner_title' => 'required|regex:/^[\pL\s\-]+$/u',
                'banner_alt' => 'required|regex:/^[\pL\s\-]+$/u',
            ];

            $customMessages = 
            [
                'banner_image.required' => "Image is Required",
                'banner_link.required' => "Banner Link is Required",
                'banner_title.required' => "Banner Title is Required",
                'banner_alt.required' => "Banner Alt is Required",
                'banner_link.regex' => "valid link is required",
                'banner_title.regex' => "valid link is required",
                'banner_alt.regex' => "valid link is required",
                
            ];

            $this->validate($request, $rules, $customMessages);

            if($request->hasFile('banner_image'))
            {
                $image_tmp = $request->file('banner_image');
                $var = "banner";

                if($image_tmp->isValid())
                {
                    $extension = $image_tmp->getClientOriginalExtension();
                    $imageName = $var.rand(111, 99999).'.'.$extension;
                    $image_path = 'images/front_images/carousel/'.$imageName;

                    //upload image to file
                    Image::make($image_tmp)->resize(1170, 480)->save($image_path);
                    //upload image name and extension in database
                    $banner->image = $imageName;
                }
            }
            $banner->link = $data['banner_link'];
            $banner->title = $data['banner_title'];
            $banner->alt = $data['banner_alt'];
            $banner->status = 1;
            $banner->save();

            Session::flash('success_message', $message);
            return redirect('/admin/banners');
        }

        return view('admin.banners.add_edit_banner')->with(compact('title', 'banner', 'message', 'sub_btn_name', 'bannerData'));

    }

    public function deleteBannerImage($id)
    {
        $bannerImage = Banner::select('image')->where('id', $id)->first();
        // $data = $bannerImage->image;
        // dd($data);
        $banner_image_path = 'images/front_images/carousel/';

        if(file_exists($banner_image_path.$bannerImage->image))
        {
            unlink($banner_image_path.$bannerImage->image);
        }

        Banner::where('id',$id)->update(['image'=>'']);

        Session::flash('success_message', 'Image Deleted Successfully');
        return redirect()->back();
    }
}
