<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CategoryStoreRequest;
use App\Models\Category;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function data(){
        $query = Category::latest();
       $name = request('name');
       $status = request('status');
       $date = request('date');

       if($name)
            $query = $query->where('name', 'LIKE', '%'.$name.'%');
        
       if($status)
        $query = $query->where('status',$status);
      
        if($date)
        $query = $query->orderBy('created_at',$date);

        $data = $query->get();

        return response()->json([
            'data' => $data,
            
        ]);
    }

    public function store(CategoryStoreRequest $request){
        if(Category::create($request->all())){
            return response()->json([
                'message'=>'Category inserted..',
                'data' => Category::where('id',request('id'))->first(),
                'status'=> Response::HTTP_CREATED
            ]);
        }else{
            return response()->json([
                'message'=>'Error..',
                'data' => null,
                'status'=> Response::HTTP_BAD_REQUEST
            ]);
        }
    }

    public function show($id){
        $category = Category::find($id);
        return response()->json([
           
            'data' => $category,
            
        ]);
    }

    public function update(CategoryStoreRequest $request, $id){
        $category = Category::find($id);
        if($category->update($request->all())){
            return response()->json([
                'message'=>'Category updated..',
                'data' => $category,
                'status'=> 200
            ]);
        }else{
            return response()->json([
                'message'=>'Error..',
                'data' => $category,
                'status'=> Response::HTTP_BAD_REQUEST
            ]);
        }
    }

    public function delete($id){
        if(Category::find($id)->delete()){
            return response()->json([
                'message'=>'Category deleted..',
               
            ]);
        }else{
            return response()->json([
                'message'=>'Error..',
                'data' => Category::find($id),
                'status'=> Response::HTTP_BAD_REQUEST
            ]);
            
        }
    }
}
