<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Admin Dashboard</title>
    <link href="{{ asset("backend/admindashboard") }}/css/style.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset("backend/admindashboard/my") }}/toastr.css">
    <script src="{{ asset("backend/admindashboard/my") }}/jquery.min.js"></script>
    <link rel="stylesheet" href="{{ asset("backend/admindashboard/my") }}/uikit.min.css" />
    <link href="{{ asset("backend/admindashboard/my") }}/select2.min.css" rel="stylesheet" />


    <style type="text/css">
        label{
            color: #585858!important;
            font-weight: 500;
            font-size: 13px;
        }

        .card-title{
            font-size: 20px;
        }



        .nk-sidebar .metismenu a{
            font-weight: 500;
            color: #585858;
        }

        .select2-container--default .select2-selection--single{
            height: 45px!important;
            border: none;
            border:1px solid #e1e1e1;
            border-radius: 0px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered{
            line-height: 40px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow{
            height: 40px;
        }

        .select2-container--default .select2-search--dropdown .select2-search__field:focus{
            border: 0px solid #fff!important;
        }

        .dropdown-item:hover{
            background: darkred;
            color: #fff;
        }

        .nk-sidebar .metismenu > li.active > a{
            background: #7571f9 !important;
            color: #fff!important;
        }

        .nk-sidebar .metismenu > li:focus span, .nk-sidebar .metismenu > li.active span{
            color: #fff!important;
        }

        .nk-sidebar .metismenu > li:focus i, .nk-sidebar .metismenu > li.active i{
            color: #fff!important;
        }

        .nk-sidebar .metismenu a:active, .nk-sidebar .metismenu a.active{
            color: #7571f9!important;
        }
        a:hover{
            text-decoration: none;
        }

        .dataTables_filter input{
            border:1px solid lightgray!important;
            height: 30px!important;
        }
        


    </style>


</head>
<body>

    <div id="preloader">
        <div class="loader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10" />
            </svg>
        </div>
    </div>

    <div id="main-wrapper">

        <div class="nav-header">
            <div class="brand-logo">
                <a href="{{ url('/dashboard') }}">
                    <b class="logo-abbr text-white">D</b>
                    <span class="logo-compact"></span>
                    <span class="brand-title">
                        <h4 style="color: #fff;" class="text-uppercase"><b>{{ (Auth()->user()->name) }}</b></h4>
                    </span>
                </a>
            </div>
        </div>

        <div class="header">    
            <div class="header-content clearfix">

                <div class="nav-control">
                    <div class="hamburger">
                        <span class="toggle-icon"><i class="icon-menu"></i></span>
                    </div>

                
                </div>


                <div class="header-right">


                    <ul class="clearfix">


                        <li class="icons dropdown">
                            <div class="user-img c-pointer position-relative"   data-toggle="dropdown">
                                <span class="activity active"></span>
                                <img src="https://i.ibb.co/8b8PG14/images.png" height="40" width="40" alt="">
                            </div>
                            <div class="drop-down dropdown-profile animated fadeIn dropdown-menu">
                                <div class="dropdown-content-body">
                                    <ul>
                                        <li>
                                            <a href="{{ route("admin.edit",Auth::id()) }}" class="btn btn-primary"><i class="icon-user text-white"></i> <span>Profile</span></a>
                                        </li>

                                        <li>

                                            <form method="post" action="{{ route('logout') }}">
                                                @csrf
                                                <button class="btn btn-primary w-100"><i class="icon-key"></i> <span>Logout</span></button>
                                            </form>



                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="nk-sidebar">           
            <div class="nk-nav-scroll">
                <ul class="metismenu" id="menu">
                    <li class="nav-label" style="color:gray;">Dashboard</li>

                    <li>
                        <a href="{{ url("/dashboard") }}" aria-expanded="false">
                            <i class="fa fa-bar-chart menu-icon"></i><span class="nav-text">Dashboard</span>
                        </a>
                    </li>



                    <li class="nav-label" style="color:gray;">Purchase/Sales</li>




                    <li>
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="icon-grid menu-icon"></i><span class="nav-text">Sales</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="{{ url('sales')}}">Sales</a></li>
                            <li><a href="{{ url('pendingallsalesledger')}}">Pending Sales</a></li>
                            <li><a href="{{ url('allsalesledger')}}">Final Sales</a></li>
                        </ul>
                    </li>




                    <li>
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="icon-grid menu-icon"></i><span class="nav-text">Product Receive</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="{{ url('purchase')}}">Product Receive</a></li>
                            <li><a href="{{ url('allpurchaseledger')}}">Receive Lists</a></li>
                        </ul>
                    </li>





                    <li>
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="icon-grid menu-icon"></i><span class="nav-text">Stocks</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="{{ url('stocks')}}">Stocks</a></li>
                        </ul>
                    </li>


                      <li>
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="icon-grid menu-icon"></i><span class="nav-text">Damage</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="{{ url('damage')}}">Damage</a></li>
                            <li><a href="{{ url('damagereports')}}">Damage Reports</a></li>
                        </ul>
                    </li>



                    <li>
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="icon-grid menu-icon"></i><span class="nav-text">Income/Expense</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="{{ url('incomeexpense')}}">Income/Expense</a></li>
                            <li><a href="{{ url('allincomeexpense')}}">All Income/Expense</a></li>
                        </ul>
                    </li>


                    <li>
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="icon-grid menu-icon"></i><span class="nav-text">Reports</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="{{ url('stockreports')}}">Stock Reports</a></li>
                            <li><a href="{{ url('dsrreports')}}">DSR Reports</a></li>
                           {{--  <li><a href="{{ url('profitreports')}}">Profit Reports</a></li> --}}
                        </ul>
                    </li>





                    <li class="nav-label" style="color:gray;">Menu</li>



                    <li>
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="icon-grid menu-icon"></i><span class="nav-text">DSR</span>
                        </a>
                        <ul aria-expanded="false">
                          <li><a href="{{ route('staff.index')}}">DSR</a></li>
                          <li><a href="{{ url('staffpayment')}}">DSR Due Payment</a></li>
                          <li><a href="{{ url('allstaffpayment')}}">Due Payment Lists</a></li>
                      </ul>
                  </li>

                  <li>
                    <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                        <i class="icon-grid menu-icon"></i><span class="nav-text">Supplier</span>
                    </a>
                    <ul aria-expanded="false">
                      <li><a href="{{ route('supplier.index')}}">Supplier</a></li>
                  </ul>
              </li>





              <li>
                <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                    <i class="icon-grid menu-icon"></i><span class="nav-text">Product Setting</span>
                </a>
                <ul aria-expanded="false">
                  <li><a href="{{ route('category.index')}}">Category</a></li>
                  {{-- <li><a href="{{ route('brand.index')}}">Brand</a></li> --}}
                  <li><a href="{{ route('product.create')}}">Product</a></li>
                  <li><a href="{{ route('product.index')}}">Manage Product</a></li>
              </ul>
          </li>



          <li class="nav-label" style="color:gray;">Setting</li>


      
          <li>
            <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                <i class="icon-grid menu-icon"></i><span class="nav-text">Admin Info.</span>
            </a>
            <ul aria-expanded="false">
                <li><a href="{{ route('admin.create')}}">Add New</a></li>
                <li><a href="{{ route('admin.index')}}">Manage Admin</a></li>
            </ul>
        </li>








    </ul>
</div>
</div>





@yield('content')



</div>


<script src="{{ asset("backend/admindashboard") }}/plugins/common/common.min.js"></script>
<script src="{{ asset("backend/admindashboard") }}/js/custom.min.js"></script>
<script src="{{ asset("backend/admindashboard") }}/js/settings.js"></script>
<script src="{{ asset("backend/admindashboard/my") }}/select2.min.js"></script>
<script src="{{ asset("backend/admindashboard/my") }}/toastr.min.js"></script>

<script>
  @if(Session::has('messege'))
  var type="{{Session::get('alert-type','info')}}"
  switch(type){
    case 'info':
    toastr.info("{{ Session::get('messege') }}");
    break;
    case 'success':
    toastr.success("{{ Session::get('messege') }}");
    break;
    case 'warning':
    toastr.warning("{{ Session::get('messege') }}");
    break;
    case 'error':
    toastr.error("{{ Session::get('messege') }}");
    break;
}
@endif
</script>


<script src="{{ asset("backend/admindashboard") }}/plugins/tables/js/jquery.dataTables.min.js"></script>
<script src="{{ asset("backend/admindashboard") }}/plugins/tables/js/datatable/dataTables.bootstrap4.min.js"></script>
<script src="{{ asset("backend/admindashboard") }}/plugins/tables/js/datatable-init/datatable-basic.min.js"></script>

<script type="text/javascript">
  (function($) {
    "use strict"

    new quixSettings({
        sidebarPosition: "fixed",
        headerPosition: "fixed"
    });

})(jQuery);

</script>


<script type="text/javascript">

    $(document).ready(function() {
        $('.myselect').select2();
    });


</script>



<script src="{{ asset("backend/admindashboard/my") }}/uikit.min.js"></script>
<script src="{{ asset("backend/admindashboard/my") }}/uikit-icons.min.js"></script>
<script src="{{ asset("backend/admindashboard/my") }}/sweetalert2@11.js"></script>


</body>
</html>