<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Api;
use response;
use Validator;


class ApiController extends Controller
{
    public function detail(Request $request)
    {
         $data=Api::all();
        if(count($data)>0)
        {
            return response()->json(['status'=>1,'msg'=>'Record Found...','data'=>$data]);
        }
        else
        {
            return response()->json(['status'=>0,'msg'=>'Record Not Found...','data'=>[]]);
        }
    }

    public function insert(Request $request)
    {
         $validator = Validator::make($request->all(),
         [
            
            'name'=>'required',
            'description'=>'required',
           
        ],
        [
            'name.required'=>"name Required",
            'description.required'=>"description Required",
        ]
         );

        if ($validator->fails()) {
            $msg=$validator->errors()->first();
            return response()->json(['data'=>[], 'status'=>0 , 'msg'=>$msg]);
        }
        $insert=new Api;
        $insert->name=$request->name;
        $insert->description=$request->description;
        $insert->save();
        return response()->json(['status'=>1,'msg'=>'record added......','data'=>$insert]);
    }

     public function update(Request $request)
    {
         $validator = Validator::make($request->all(),
         [
            'id'=>'required',
        ],
        [
            'id.required'=>"id Required",
        ]
         );

        if ($validator->fails()) {
            $msg=$validator->errors()->first();
            return response()->json(['data'=>[], 'status'=>0 , 'msg'=>$msg]);
        }

        // Check the Id is inserted or not in tabel
       $check_detail=Api::where('id',$request->id)->first();
       if($check_detail === null)
       {
         return response()->json(['status'=>0,'msg'=>'record Not Match......','data'=>[]]);
       }

       // Update perticular one record in table
        $updatedetail=Api::find($request->id);

        // check new record upadte or exiting record updated 
        if($request->has('name')&& $request->name != null)
        {
            $updatedetail->name=$request->name;
        }
        if($request->has('description')&& $request->description != null)
        {
            $updatedetail->description=$request->description;
        }
        $updatedetail->save();
         return response()->json(['status'=>1,'msg'=>'record Updated......','data'=>$updatedetail]);
    }
     public function delete(Request $request)
    {
           $validator = Validator::make($request->all(),
         [
            'id'=>'required',
        ],
        [
            'id.required'=>"id Required",
        ]
         );

        if ($validator->fails()) {
            $msg=$validator->errors()->first();
            return response()->json(['data'=>[], 'status'=>0 , 'msg'=>$msg]);
        }

        // Check the Id is inserted or not in tabel
       $check_detail=Api::where('id',$request->id)->first();
       if($check_detail === null)
       {
         return response()->json(['status'=>0,'msg'=>'record Not Match......','data'=>[]]);
       }

         $delete=Api::find($request->id)->delete();
         return response()->json(['status'=>1,'msg'=>'record Deleted......','data'=>[]]);
    }
    
}
