<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::orderBy('updated_at', 'desc')->paginate(4);
        return view('admin.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::get();
        return view('admin.product.create', compact('categories'));
    }

    //search products
    public function search(Request $request) {
        $products = Product::where('name','like', '%' . $request->searchKey . '%')
                            ->orderBy('updated_at', 'desc')
                            ->paginate(4)
                            ->appends($request->query());

        return view('admin.product.index', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $categories = Category::get();

        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:products,name',
            'description' => 'required',
            'price' => 'required',
            'categoryId' => 'required',
            'image' => 'required|mimes:png,jpg,jpeg,webp,jfif|max:1024'
        ], [
            'image.max' => 'The image file size must not be greater than 1MB.',
            'categoryId.required' => 'The category field is required.'
        ]);

        if($validator->fails()) {
            return redirect()->route('admin#createProduct')
                             ->with(['categories' => $categories])
                             ->withErrors($validator)
                             ->withInput();
        }

        $data = $this->getProductData($request); //convert product data into array

        if($request->file('image')) {
            $image = $request->file('image');
            $imageName = uniqid() . '_' . $image->getClientOriginalName();
            $image->move(storage_path('app/public/productImages/'), $imageName);
            $data['image'] = $imageName;
        }

        Product::create($data);

        return redirect()->route('admin#products')->with([
            'successMessage' => 'The product has been created!',
            'categories' => $categories
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //get image from database
        $old_image = Product::where('id', $id)->first()->image;
        if(Storage::exists('public/productImages/' . $old_image)) {
            Storage::delete('public/productImages/' . $old_image); //delete the image from storage
        }

        Product::where('id', $id)->delete();

        return redirect()->route('admin#products')->with(['successMessage' => 'The product has been deleted!']);
    }

    private function getProductData($request) {
        return [
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'category_id' => $request->categoryId
        ];
    }
}
