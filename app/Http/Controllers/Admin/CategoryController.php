<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use Session;
use App\Section;
use Image;

class CategoryController extends Controller
{
    public function category()
    {
        Session::put('page', 'categories');
        $categories = Category::with(['section', 'parentcategory'])->get();
        return view('admin.categories.categories')->with(compact('categories'));
    }

    //update category status
    public function updateCategoryStatus(Request $request)
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
        Category::Where('id', $data['category_id'])->update(['status'=>$status]);
        return response()->json(['status'=>$status, 'category_id'=>$data['category_id']]);
    }

    public function addEditCategory(Request $request, $id=null)
    {
        if($id == "")
        {
            $title = "Add Category";
            $category = new Category;
            $categorydata = array();
            $getCategories = array();
            $submit = "Submit";
            $message = "Category Added successfully";
            
            
        }else
        {
            $title = "Edit Category";

            $categorydata = Category::where('id', $id)->first();
            $getCategories = Category::with('subcategories')->where([ 'parent_id'=>0, 'section_id'=>$categorydata['section_id']])->get();
            // $getCategories = json_decode(json_encode($getCategories), true);
            // echo "<pre>"; print_r($getCategories); die;
            $submit = "Update";
            $category = Category::find($id);
            $message = "Category updated successfully";
        }

        if($request->isMethod('post'))
        {
            $data = $request->all();

            //validations
            $rules = [
                'category_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'section_id' => 'required', 
                'url' => 'required', 
                'category_image' => 'image', 
            ];
            $customMessages = [
                'category_name.required' => 'Name is required',
                'category_name.regex' => 'Valid name is required',
                'section_id.required' => 'section is required',
                'url.required' => 'url is required',
                'category_image.image' => 'valid image is required',
            ];

            $this->validate($request, $rules, $customMessages);


            //upload image
            if($request->hasFile('category_image'))
            {
                $image_tmp = $request->file('category_image');
                if($image_tmp->isValid())
                {
                    $extension = $image_tmp->getClientOriginalExtension();
                    $imageName = rand(111,99999).'.'.$extension;
                    $imagePath = 'images/category_images/'.$imageName;
                    
                    //upload the image

                    Image::make($image_tmp)->save($imagePath);

                    $category->category_image = $imageName;
                }

            }

            // dd($data);
            $category->parent_id = $data['parent_id'];
            $category->section_id = $data['section_id'];
            $category->category_name = $data['category_name'];
            $category->category_discount = $data['category_discount'];
            $category->description = $data['description'];
            $category->url = $data['url'];
            $category->meta_title = $data['meta_title'];
            $category->meta_description = $data['meta_description'];
            $category->meta_keywords = $data['meta_keywords'];
            $category->status = 1;

            $category->save();

            Session::flash('success_message', $message);
            return redirect('admin/categories');

        }

        $getSections = Section::get();
        return view('admin.categories.add_edit_category')->with(compact('submit', 'title', 'getSections', 'categorydata', 'getCategories'));
    }

    //append category level
    public function appendCategoryLevel(Request $request)
    {
        if($request->ajax())
        {
            $data = $request->all();

            $getCategories = Category::with('subcategories')->where(['section_id'=>$data['section_id'], 'parent_id'=>0, 'status'=>1])->get();

            return view('admin.categories.append_categories_level')->with(compact('getCategories'));
        }
    }

    public function deleteCategoryImage($id)
    {
        $categoryImage = Category::select('category_image')->where('id', $id)->first();
        $category_image_path = 'images/category_images/';

        //delete image from category image folder
        if(file_exists($category_image_path.$categoryImage->category_image))
        {
            unlink($category_image_path.$categoryImage->category_image);
        }

        //delete image from database
        Category::where('id', $id)->update(['category_image'=>'']);

        Session::flash('success_message', 'Image deleted');
        return redirect()->back();

    }

    //delete category
    public function deleteCategory($id)
    {
        Category::where('id', $id)->delete();

        Session::flash('success_message', 'Category deleted successfully');
        return redirect()->back();

    }
}
