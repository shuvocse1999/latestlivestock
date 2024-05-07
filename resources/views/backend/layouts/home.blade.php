@extends('backend.layouts.index')
@section('content')



@php
$sales = DB::table('sales_ledger')
->join("staff",'staff.id','sales_ledger.staff_id')
->join("users",'users.id','sales_ledger.admin_id')
->select("sales_ledger.*",'staff.staff_name','users.name')
->orderBy('sales_ledger.invoice_date','DESC')
->where('sales_ledger.status',1)
->limit(4)
->get();

$purchase = DB::table('purchase_ledger')
->join("suppliers",'suppliers.id','purchase_ledger.supplier_id')
->join("users",'users.id','purchase_ledger.admin_id')
->select("purchase_ledger.*",'suppliers.supplier_name','users.name')
->orderBy('purchase_ledger.invoice_date','DESC')
->limit(4)
->get();

$admin = DB::table("users")->count();
$products = DB::table("products")->count();
$dsr = DB::table("staff")->count();
$category = DB::table("categories")->count();



@endphp




<div class="content-body">



 <div class="container-fluid mt-3">

  <div class="row">


   <div class="col-lg-3 col-sm-6">
    <div class="card gradient-1">
      <div class="card-body p-4">
        <h3 class="card-title text-white">Admin</h3>
        <div class="d-inline-block">
          <h2 class="text-white font-weight-bold">{{ $admin }}</h2>
        </div>
        <span class="float-right display-5 opacity-5"><i class="fa fa-users"></i></span>
      </div>
    </div>
  </div>



  <div class="col-lg-3 col-sm-6">
    <div class="card gradient-4">
      <div class="card-body p-4">
        <h3 class="card-title text-white">DSR</h3>
        <div class="d-inline-block">
          <h2 class="text-white font-weight-bold">{{ $dsr }}</h2>
        </div>
        <span class="float-right display-5 opacity-5"><i class="fa fa-users"></i></span>

      </div>
    </div>
  </div>




  <div class="col-lg-3 col-sm-6">
    <div class="card gradient-4">
      <div class="card-body p-4">
        <h3 class="card-title text-white">Category</h3>
        <div class="d-inline-block">
          <h2 class="text-white font-weight-bold">{{ $category }}</h2>
        </div>
        <span class="float-right display-5 opacity-5"><i class="fa fa-bookmark-o"></i></span>

      </div>
    </div>
  </div>




  <div class="col-lg-3 col-sm-6">
    <div class="card gradient-4">
      <div class="card-body p-4">
        <h3 class="card-title text-white">Products</h3>
        <div class="d-inline-block">
          <h2 class="text-white font-weight-bold">{{ $products }}</h2>
        </div>
        <span class="float-right display-5 opacity-5"><i class="fa fa-product-hunt"></i></span>

      </div>
    </div>
  </div>






</div>



<div class="row">

  <div class="col-md-8">
    <div class="card">
      <div class="card-body">
        <div id="dsrchart"></div>
        <br><br>
      </div>
    </div>
  </div>



  <div class="col-md-4">
    <div class="card">
      <div class="card-body">

       <div id="myChart">
       </div>

       
        <select name="forma" class="form-control myselect" onchange="location = this.value;">
         <option value="">Go To Quick Link</option>
         <option value="{{ url('/sales') }}">Sales</option>
         <option value="{{ url('/purchase') }}">Recieved</option>
         <option value="{{ url('/stocks') }}">Stocks</option>
         <option value="{{ url('/staffpayment') }}">DSR Due Payment</option>
         <option value="{{ route('product.index') }}">Manage Product</option>

         
       </select>
     </div>
   </div>
 </div>


</div>



<div class="row">
  <div class="col-md-6">
    <div class="card">
      <div class="card-body">

       <b class="text-primary">Top Sales</b><br><br>

       <table class="table table-bordered">
        <tr>
          <th>SL.</th>
          <th>Date</th>
          <th>Invoice</th>
          <th>Grand Total</th>
          <th>Print</th>
        </tr>

        @php $i =1; @endphp
        @if(isset($sales))
        @foreach($sales as $d)
        <tr>
          <td>{{ $i++ }}</td>
          <td>{{ date('d M Y',strtotime($d->invoice_date)) }}</td>
          <td>{{ $d->invoice_no }}</td>
          <td>{{ number_format($d->grandtotal,2) }}</td>
          <td>
            <a class="btn btn-primary btn-sm" href="{{ url("finalsalesinvoice/".$d->invoice_no) }}" target="blank">Invoice</a>

          </td>

        </tr>

        @endforeach
        @endif
      </table>
    </div>

  </div>

</div>

<div class="col-md-6">
 <div class="card">
  <div class="card-body">

   <b class="text-primary">Top Purchase</b><br><br>

   <table class="table table-bordered">
    <tr>
      <th>SL.</th>
      <th>Date</th>
      <th>Voucher</th>
      <th>Grand Total</th>
      <th>Print</th>
    </tr>

    @php $i =1; @endphp
    @if(isset($purchase))
    @foreach($purchase as $d)
    <tr>
      <td>{{ $i++ }}</td>
      <td>{{ date('d M Y',strtotime($d->invoice_date)) }}</td>
      <td>#{{ $d->voucer }}</td>
      <td>{{ number_format($d->grandtotal,2) }}</td>
      <td>
        <a class="btn btn-primary btn-sm" href="{{ url("purchaseinvoice/".$d->invoice_no) }}" target="blank">Invoice</a>

      </td>

    </tr>

    @endforeach
    @endif
  </table>
</div>

</div>
</div>
</div>






</div>

</div>


@php
$dsr = DB::table("staff")->where("designation","dsr")->get();
$purchase = DB::table("purchase_ledger")->sum("grandtotal");
$sales = DB::table("sales_ledger")->sum("grandtotal");
$i = 0;
@endphp

<input type="hidden" id="purchase" value="{{ $purchase }}">
<input type="hidden" id="sales" value="{{ $sales }}">

@foreach($dsr as $d)

@php
$sales = DB::table("sales_ledger")->where("staff_id",$d->id)->sum('grandtotal');
@endphp

<center>
  <input type="hidden" id="name{{ $i++ }}" value="{{ $d->staff_name }}">
  <input type="hidden" id="sales{{ $i++ }}" value="{{ $sales }}">
</center>
@endforeach



<script type="text/javascript" src="{{ asset("backend/admindashboard/my") }}/loader.js"></script>


<script>
  google.charts.load('current', {'packages':['corechart']});
  google.charts.setOnLoadCallback(drawChart);

  function drawChart() {

   var top1 = $("#name0").val();
   var top1sales = parseFloat($("#sales1").val());

   var top2 = $("#name2").val();
   var top2sales = parseFloat($("#sales3").val());

   var top3 = $("#name4").val();
   var top3sales = parseFloat($("#sales5").val());

   var top4 = $("#name6").val();
   var top4sales = parseFloat($("#sales7").val());

   var top5 = $("#name8").val();
   var top5sales = parseFloat($("#sales9").val());

   const data = google.visualization.arrayToDataTable([
    ['DSR', 'Tk'],
    [top1,top1sales],
    [top2,top2sales],
    [top3,top3sales],
    [top4,top4sales],
    [top5,top5sales],

    ]);

   const options = {
    title:'DSR Sales Graph'
  };

  const chart = new google.visualization.BarChart(document.getElementById('dsrchart'));
  chart.draw(data, options);
}
</script>



<script>
  google.charts.load('current', {'packages':['corechart']});
  google.charts.setOnLoadCallback(drawChart);

  function drawChart() {

    var purchase = parseFloat($("#purchase").val());
    var sales    = parseFloat($("#sales").val());

    const data = google.visualization.arrayToDataTable([
      ['Products', 'Mhl'],
      ['Sales',sales],
      ['Recieved',purchase]
      ]);

    const options = {
      title:'Product Recieved And Sales Payment',
      is3D:false
    };

    const chart = new google.visualization.PieChart(document.getElementById('myChart'));
    chart.draw(data, options);
  }
</script>






@endsection