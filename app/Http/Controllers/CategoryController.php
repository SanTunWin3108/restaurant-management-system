<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
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
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //
    }

    private function getCategoryData($request) {
        return [
            'name' => $request->name,
            'description' => $request->description
        ];
    }
}
