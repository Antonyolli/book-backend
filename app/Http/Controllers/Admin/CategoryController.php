<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $category = Category::all();
        return response()->json([
            'data' => $category,
            'con' => true,
            'message' => 'All Categories'
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()
            ]);
        } else {
            $category = new Category();
            $category->name = $request->name;
            $category->slug = Str::of($request->name)->slug;
            $category->save();
            return response()->json([
                'data' => $category,
                'con' => true,
                'message' => 'Category Created'
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $category)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()
            ]);
        } else {
            $category = Category::where('slug', $category)->first();
            $category->name = $request->name;
            $category->slug = Str::of($request->name)->slug;
            $category->update();
            return response()->json([
                'data' => $category,
                'con' => true,
                'message' => 'Successfully Updated'
            ], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($category)
    {
        $category = Category::where('slug' , $category)->first();
        $category->delete();
        return response()->json([
            'data' => $category,
            'con' => true,
            'message' => 'Successfully Deleted'
        ], 200);
    }
}
