<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function __construct(){
        $this->view_path = 'admin.categories.';
    }

    public function index()
    {
        $title = 'Category';
        $categorys = Category::all();
        return view($this->view_path.'index',compact('categorys','title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Category';
        $categorys = Category::where('parent_id',null)->get();
        return view($this->view_path.'create',compact('title','categorys'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'slug' => 'required|max:255',
            'parent_id' => 'nullable|exists:categories,id',
            'description' => 'nullable',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_visible' => 'required|in:0,1'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $category = new Category();
        $category->name = $request->name;
        $category->slug = $request->slug;
        $category->parent_id = $request->parent_id;
        $category->description = $request->description;

        if ($request->hasFile('image')) {
            $img = $request->file('image');
            $filename = time(). '_' .$img->getClientOriginalName();
            $directory = public_path('web_directory/category-image');
            $img->move($directory, $filename);
            $filePath = "web_directory/category-image/".$filename;
            $category->image = $filePath;
        }

        $category->visibility = $request->is_visible;
        $res = $category->save();
        if($res){
            return redirect()->back()->with('success','Data Added Successfully');
        }else{
            return redirect()->back()->with('error','Data Not Added, try again!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $title = 'Category';
        $categorys = Category::where('parent_id',null)->get();
        $cate = Category::find($id);
        return view($this->view_path.'edit',compact('title','categorys','cate'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'slug' => 'required|max:255',
            'parent_id' => 'nullable|exists:categories,id',
            'description' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_visible' => 'required|in:0,1'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $category = Category::find($id);
        $category->name = $request->name;
        $category->slug = $request->slug;
        $category->parent_id = $request->parent_id;
        $category->description = $request->description;

        if ($request->hasFile('image')) {
            if ($category->image) {
                $existingImagePath = public_path($category->image);
                if (file_exists($existingImagePath)) {
                    unlink($existingImagePath);
                }
            }
            $img = $request->file('image');
            $filename = time(). '_' .$img->getClientOriginalName();
            $directory = public_path('web_directory/category-image');
            $img->move($directory, $filename);
            $filePath = "web_directory/category-image/".$filename;
            $category->image = $filePath;
        }

        $category->visibility = $request->is_visible;
        $res = $category->update();
        if($res){
            return redirect()->back()->with('success','Data Updated Successfully');
        }else{
            return redirect()->back()->with('error','Data Not Updated, try again!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::find($id);
        if($category){
            if ($category->image) {
                $existingImagePath = public_path($category->image);
                if (file_exists($existingImagePath)) {
                    unlink($existingImagePath);
                }
            }
            $res = $category->delete();
            if($res){
                return back()->with('success','Deleted Successfully');
            }else{
                return back()->with('error','Not Deleted');
            }
        }else{
            return back()->with('error','Not Found');
        }
    }
}
