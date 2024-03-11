<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Contracts\Validation\Validator as ValidationValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::orderBy('updated_at', 'desc')->paginate(4);
        return view('admin.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    //search category
    public function search(Request $request) {
        $categories = Category::where('name', 'like', '%'.$request->searchKey.'%')
                              ->paginate(4)
                              ->appends($request->query());

        return view('admin.category.index', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:categories,name',
            'description' => 'required',
            'image' => 'required|mimes:png,jpg,jpeg,webp,jfif|max:1024'
        ], [
            'image.max' => 'The image file size must not be greater than 1MB!'
        ]);

        if($validator->fails()) {
            return redirect()->route('admin#categories')
                             ->withErrors($validator)
                             ->withInput();
        }

        $data = $this->getCategoryData($request); //convert category data into array

        if(request()->hasFile('image')) {
            $image = request()->file('image');
            $imageName = uniqid() . '_' . $image->getClientOriginalName();
            $image->move(storage_path('app/public/categoryImages'), $imageName);
            $data['image'] = $imageName;
        }

        Category::create($data);

        return redirect()->route('admin#categories')->with(['successMessage' => 'The category has been created!']);
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
    public function edit($id)
    {
        $category = Category::where('id', $id)->first();
        return view('admin.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:categories,name,' . $id,
            'description' => 'required',
            'image' => 'mimes:png,jpg,jpeg,webp,jfif|max:1024'
        ], [
            'image.max' => 'The image file size must not be greater than 1MB'
        ]);

        if($validator->fails()) {
            return redirect()->route('admin#editCategory', $id)
                             ->withErrors($validator)
                             ->withInput();
        }

        //convert user request into array
        $data = $this->getCategoryData($request);

        //if user upload image
        if(request()->hasFile('image')) {
            //get old image from database
            $old_image = Category::where('id', $id)->first()->image;

            //delete the old image from storage
            Storage::delete('public/categoryImages/' . $old_image);

            //get image from user request
            $image = request()->file('image');

            //get image name
            $imageName = uniqid() . '_' . $image->getClientOriginalName();

            //store image
            $image->move(storage_path('app/public/categoryImages'), $imageName);

            $data['image'] = $imageName;
        }

        Category::where('id', $id)->update($data);

        return redirect()->route('admin#editCategory', $id)->with(['successMessage' => 'The category has been updated!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Category::where('id', $id)->delete();

        return redirect()->route('admin#categories')->with(['successMessage' => 'The cateory has been deleted!']);
    }

    private function getCategoryData($request) {
        return [
            'name' => $request->name,
            'description' => $request->description
        ];
    }
}
