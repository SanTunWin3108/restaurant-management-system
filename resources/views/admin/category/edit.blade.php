@extends('admin.layouts.master')

@section('title', 'Edit Category')

@section('content')
    <div class="container px-3">
        <div class="row">
            <div class="col-md-10 col-lg-6 mx-auto mt-4">
                @if (session('successMessage'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>{{session('successMessage')}}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <form action="{{route('admin#updateCategory', $category->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="card">
                        <div class="card-header bg-white d-flex align-items-center justify-content-between ">
                            <div class="fw-bold">
                                <i class="fa-solid fa-pen-to-square fs-5"></i>
                                <span class="fs-5 ms-1">Edit Category</span>
                            </div>

                            <div>
                                <a href="{{route('admin#categories')}}">
                                    <button type="button" class="btn btn-dark"><i class="fa-solid fa-arrow-left me-1"></i>Back</button>
                                </a>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="mb-3">
                                <label for="">Name</label>
                                <input name="name" type="text" class="form-control" placeholder="Enter category name..." value="{{old('name', $category->name)}}">
                                @error('name')
                                    <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="">Description</label>
                                <input name="description" type="text" class="form-control" placeholder="Enter category description..." value="{{old('description', $category->description)}}">
                                @error('description')
                                    <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-4">
                                        <img class="w-100 rounded " src="{{asset('storage/categoryImages/' . $category->image)}}" alt="">
                                    </div>
                                    <div class="col-8">
                                        <label for="">Image</label>
                                        <input name="image" type="file" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-success w-100"><i class="fa-solid fa-floppy-disk me-1"></i>Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
