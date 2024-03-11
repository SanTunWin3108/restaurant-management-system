<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>@yield('title')</title>

        {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> --}}

        <link rel="stylesheet" href="{{asset('bootstrap/bootstrap.min.css')}}">

        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />

        <link href="{{asset('adminTemplate/css/styles.css')}}" rel="stylesheet" />

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

        <style>
            body {
                font-family: "Poppins", sans-serif;
  font-weight: 400;
  font-style: normal;
            }
        </style>

    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <div class="navbar-brand ps-3" href=""><b>Pos</b>System</div>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form action="{{route('admin#searchCategory')}}" method="GET" class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                <div class="input-group">
                    <input name="searchKey" value="{{request('searchKey')}}" class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                    <button class="btn btn-success" id="btnNavbarSearch" type="submit"><i class="fas fa-search"></i></button>
                </div>
            </form>
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw me-1"></i>{{Auth::user()->name}}</a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark " aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#!"><i class="fa-solid fa-user me-2"></i>Profile</a></li>
                        <li><a class="dropdown-item" href="#!"><i class="fa-solid fa-key me-2"></i>Password</a></li>
                        <li><hr class="dropdown-divider" /></li>
                        <li><a class="dropdown-item" href="{{route('admin#logout')}}"><i class="fa-solid fa-right-from-bracket me-2"></i>Logout</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Navigation</div>

                            <a class="nav-link" href="index.html">
                                <div class=""><i class="fa-solid fa-chart-line me-2"></i>Dashboard</div>

                            </a>

                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class=""><i class="fa-solid fa-user me-2"></i>Account</div>
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href=""><i class="fa-solid fa-user me-2"></i>Profile</a>
                                    <a class="nav-link" href=""><i class="fa-solid fa-key me-2"></i>Password</a>
                                    <a class="nav-link" href="{{route('admin#logout')}}"><i class="fa-solid fa-right-from-bracket me-2"></i>Logout</a>
                                </nav>
                            </div>

                            <a class="nav-link" href="index.html">
                                <div class=""><i class="fa-solid fa-list-check me-2"></i>Orders</div>

                            </a>

                            <a class="nav-link" href="{{route('admin#categories')}}">
                                <div class=""><i class="fa-solid fa-book me-2"></i>Categories</div>
                            </a>

                            <a class="nav-link" href="index.html">
                                <div class=""><i class="fa-solid fa-table-cells-large me-2"></i>Products</div>

                            </a>

                        </div>
                    </div>

                </nav>
            </div>

            <div id="layoutSidenav_content">
                @yield('content')
            </div>
        </div>



        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

        <script src="{{asset('adminTemplate/js/scripts.js')}}"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>

       {{--  <script src="{{asset('adminTemplate/assets/demo/chart-area-demo.js')}}"></script>

        <script src="{{asset('adminTemplate/assets/demo/chart-bar-demo.js')}}"></script>
 --}}
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>

        <script src="{{asset('adminTemplate/js/datatables-simple-demo.js')}}"></script>

        <script src="{{asset('jquery/jquery.min.js')}}"></script>

        @yield('script')
    </body>
</html>
