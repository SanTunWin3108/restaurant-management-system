@extends('admin.layouts.master')

@section('title', 'Create product')

@section('search')
    <form action="{{route('admin#searchProducts')}}" method="GET" class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
        <div class="input-group">
            <input name="searchKey" value="{{request('searchKey')}}" class="form-control" type="text" placeholder="Search products..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
            <button class="btn btn-success" id="btnNavbarSearch" type="submit"><i class="fas fa-search"></i></button>
        </div>
    </form>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 col-md-8 col-sm-10 mx-auto mt-2">
                @if (session('successMessage'))
                <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                    <strong>{{session('successMessage')}}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
               <form action="{{route('admin#updateProduct', $product->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="card mb-4 mt-2 shadow ">
                    <div class="card-header bg-white d-flex align-items-center justify-content-between ">
                        <div class="fw-bold fs-5"><i class="fa-solid fa-pen-to-square"></i> Edit product</div>

                        <div>
                            <a href="{{route('admin#products')}}">
                                <button type="button" class="btn btn-dark"><i class="fa-solid fa-arrow-left me-1"></i>Back</button>
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="mb-3">
                            <label for="">Name</label>
                            <input name="name" type="text" class="form-control" value="{{old('name', $product->name)}}">
                            @error('name')
                                <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="">Description</label>
                            <input name="description" type="text" class="form-control" value="{{old('description', $product->description)}}">
                            @error('description')
                                <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="">Price (MMK)</label>
                            <input name="price" type="number" class="form-control" value="{{old('price', $product->price)}}">
                            @error('price')
                                <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="">Category</label>
                            <select name="categoryId"  class="form-control" style="cursor: pointer;">
                                <option value="">Choose category</option>

                                @foreach ($categories as $c)
                                    <option value="{{$c->id}}"
                                        @if (old('categoryId', $product->category_id) == $c->id)
                                            selected
                                        @endif
                                    >{{$c->name}}</option>
                                @endforeach
                            </select>
                            @error('categoryId')
                                <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <div class="row">
                                <div class="col-4">
                                    <img class="w-100 rounded " src="{{asset('storage/productImages/' . $product->image)}}" alt="">
                                </div>
                                <div class="col-8">
                                    <label for="">Image</label>
                                    <input name="image" type="file" class="form-control">
                                    @error('image')
                                        <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success w-100"><b><i class="fa-solid fa-floppy-disk"></i></b> Update product</button>
                    </div>
                </div>
               </form>
            </div>
        </div>
    </div>
@endsection
