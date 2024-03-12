@extends('admin.layouts.master')

@section('title', 'Products')

@section('search')
    <form action="" method="GET" class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
        <div class="input-group">
            <input name="searchKey" value="{{request('searchKey')}}" class="form-control" type="text" placeholder="Search products..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
            <button class="btn btn-success" id="btnNavbarSearch" type="submit"><i class="fas fa-search"></i></button>
        </div>
    </form>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 col-lg-10 mx-auto my-5">
                @if (session('successMessage'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>{{session('successMessage')}}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                <div class="card">
                    <div class="card-header bg-white">
                        <div class="row">
                            <div class="fs-5 fw-bold col-sm-4">
                                <i class="fa-solid fa-table-cells-large me-1"></i>Products
                            </div>
                            <div class="col-sm-8 text-sm-end text-center  mt-sm-0 mt-3 ">
                                <a class="text-dark me-3" href="">All products</a>
                                <a href="{{route('admin#createProduct')}}"><button class="btn btn-success ">+ Add New Product</button></a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body" style="overflow-x: auto">
                        <table class="table table-bordered text-center table-responsive ">
                            <thead>
                                <tr>
                                    <td class="col-1">ID</td>
                                    <td class="col">Image</td>
                                    <td class="col-2">Name</td>
                                    <td class="col-2">Category</td>
                                    <td class="col-3">Date</td>
                                    <td class="col-2">Action</td>
                                </tr>
                            </thead>

                           <tbody>
                                @foreach ($products as $p)
                                    <tr>
                                        <td class="align-middle">{{$p->id}}</td>
                                        <td class="align-middle">
                                            <img class="w-100 rounded " src="{{asset('storage/productImages/' . $p->image)}}" alt="">
                                        </td>
                                        <td class="align-middle">{{$p->name}}</td>
                                        <td class="align-middle">{{$p->category->name}}</td>
                                        <td class="align-middle">{{$p->updated_at->format('d-M-Y(D)')}}</td>
                                        <td class="align-middle">
                                            <div class="d-flex justify-content-center ">
                                                <button class="btn btn-dark px-2" data-toggle="tooltip" data-bs-placement="top" title="Edit">
                                                    <a href="" class="text-white">
                                                        <i class="fa-solid fa-pen-to-square fs-5"></i>
                                                    </a>
                                                </button>

                                                <button  data-bs-toggle="modal" data-bs-target="#staticBackdrop" type="button" class="delete-btn btn btn-danger px-2 ms-2" data-toggle="tooltip" data-bs-placement="top" title="Delete" data-url="">
                                                    <i class="fa-solid fa-trash-can fs-5"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                           </tbody>
                        </table>
                    </div>
                </div>

                <div class="d-flex justify-content-center mt-2">
                    {{$products->links()}}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script type="text/javascript">
    $(document).ready(function() {
        $("body").tooltip({ selector: '[data-toggle=tooltip]' });
    });
</script>
@endsection
