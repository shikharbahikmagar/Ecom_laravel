<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function subcategories()
    {
        return $this->hasMany('App\Category', 'parent_id')->where('status', 1);
    }

    public function section()
    {
        return $this->belongsTo('App\Section', 'section_id')->select('id', 'name');
    }

    public function parentcategory()
    {
        return $this->belongsTo('App\Category', 'parent_id')->select('id', 'category_name');
    }

    public static function categoryDetails($url)
    {
        $categoryDetails = Category::where('url', $url)->select(['id', 'parent_id', 'category_name', 'url', 'description'])->with(['subcategories'=>
        function($query){
            $query->select('id', 'parent_id', 'category_name', 'url', 'description')->where('status', 1);
        }])->first()->toArray();
        //using breadcrumbs 
        if($categoryDetails['parent_id'] == 0)
        {
            //only showing sub categories
            $breadcrumbs = '<a href="'.url($categoryDetails['url']).'">'.$categoryDetails['category_name'].'</a>';
        }else
        {
            $parentCategory = Category::select('category_name', 'url')->where('id', $categoryDetails['parent_id'])
            ->first()->toArray();
            $breadcrumbs = '<a href="'.url($parentCategory['url']).'">'.$parentCategory['category_name'].'</a>
            &nbsp;<span class="divider">/</span>&nbsp;<a href="'.url($categoryDetails['url']).'">'.$categoryDetails['category_name'].'</a>';
        }
        $catIds = array();
        $catIds[] = $categoryDetails['id']; //getting id's of categories
        foreach($categoryDetails['subcategories'] as $key=>$subCat)
        {
            $catIds[] = $subCat['id']; // getting ids of subcategories "category and sub categories in same array"
        }
        return array('catIds'=>$catIds, 'categoryDetails'=>$categoryDetails, 'breadcrumbs'=>$breadcrumbs);
    }
}
