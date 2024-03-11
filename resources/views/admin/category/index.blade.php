@extends('admin.layouts.master')

@section('title', 'Categories')

@section('content')

<style>

</style>

<main>
    <div class="container-fluid px-3">
        <div class="row my-4">
                {{-- Modal --}}
                <div class="modal mt-5 fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Delete category?</h5>
                        <button id="close-btn2" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to delete?</p>
                        </div>
                        <div class="modal-footer">
                        <button id="close-btn1" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <form id="deleteForm" action="" method="post">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                        </div>
                    </div>
                    </div>
                </div>
                {{-- Modal End --}}

            <div class="col-md-8">
                @if (session('successMessage'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>{{session('successMessage')}}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                {{-- <div class="row mt-3">
                    <div class="col-md-6">

                        <div class="card shadow ">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-4">
                                        <img class="w-100 rounded " src="https://www.tomatoblues.com/wp-content/uploads/2022/08/vegan-masala-chai-3-500x500.jpg" alt="">
                                    </div>
                                    <div class="col-8">
                                        <h4>Tea</h4>
                                        <p>Warm tea, cozy mug, relaxation in every sip.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div> --}}
                <div class="card shadow ">
                    <div class="card-header bg-white d-flex align-items-center justify-content-between ">
                        <div class="fw-bold">
                            <i class="fas fa-table me-1"></i><span class="fs-5 ms-1">Categories</span>
                        </div>

                        <div>
                            <a class="text-dark" href="{{route('admin#categories')}}">All categories</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered text-center">
                            <thead>
                                <tr>
                                    <td class="col-1">ID</td>
                                    <td class="col-2">Image</td>
                                    <td class="col">Name</td>
                                    <td class="col-2">Date</td>
                                    <td class="col-3">Action</td>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($categories as $c)
                                    <tr>
                                        <td class="align-middle">{{$c->id}}</td>
                                        <td class="align-middle">
                                            <img class="w-100 rounded " src="{{asset('storage/categoryImages/' . $c->image)}}" alt="">
                                        </td>
                                        <td class="align-middle">{{$c->name}}</td>
                                        <td class="align-middle">{{$c->updated_at->format('d/m/Y(D)')}}</td>
                                        <td class="align-middle">
                                            <div class="d-flex justify-content-center ">
                                                <button class="btn btn-dark px-2" data-toggle="tooltip" data-bs-placement="top" title="Edit">
                                                    <a href="{{route('admin#editCategory', $c->id)}}" class="text-white">
                                                        <i class="fa-solid fa-pen-to-square fs-5"></i>
                                                    </a>
                                                </button>

                                                <button  data-bs-toggle="modal" data-bs-target="#staticBackdrop" type="button" class="delete-btn btn btn-danger px-2 ms-2" data-toggle="tooltip" data-bs-placement="top" title="Delete" data-url="{{route('admin#destroyCategory', $c->id)}}">
                                                    <i class="fa-solid fa-trash-can fs-5"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @if (!$categories->count())
                            <h3 class="text-danger text-center ">There is no item!</h3>
                        @endif
                    </div>
                </div>

                <div class="d-flex justify-content-center mt-3">
                    {{$categories->links()}}
                </div>
            </div>
            <div class="col-md-4 my-4 mt-md-0 ">
                <div class="card shadow ">
                   <form action="{{route('admin#storeCategory')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-header bg-white fw-bold">
                            <span class="fs-5"> <b>+</b> Add New Category</span>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="">Name</label>
                                <input name="name" type="text" class="form-control" placeholder="Enter category name..." value="{{old('name')}}">
                                @error('name')
                                    <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="">Description</label>
                                <input name="description" type="text" class="form-control" placeholder="Enter category description..." value="{{old('description')}}">
                                @error('description')
                                    <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="">Image</label>
                                <input name="image" type="file" class="form-control">
                                @error('image')
                                    <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>

                            <button type="submit" class="w-100 btn btn-success mt-2"> <b>+</b> Add Category</button>
                        </div>
                   </form>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection

@section('script')
<script type="text/javascript">
    $(document).ready(function() {
        $("body").tooltip({ selector: '[data-toggle=tooltip]' });

        $('.delete-btn').click(function() {
            $url = $(this).data('url');
            $('#deleteForm').attr('action', $url);
        });

        $('#close-btn1').click(function() {
            location.reload();
        })

        $('#close-btn2').click(function() {
            location.reload();
        })
    });
</script>
@endsection


