<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Section;
use Session;

class SectionController extends Controller
{
    public function section()
    {
        Session::put('page', 'Sections');
        $sections = Section::get();
        return view('admin.sections.sections')->with(compact('sections'));
    }

    public function updateSectionStatus(Request $request)
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
        Section::Where('id', $data['section_id'])->update(['status'=>$status]);
        return response()->json(['status'=>$status, 'section_id'=>$data['section_id']]);
    }
}
