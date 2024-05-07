@extends('backend.reports.layouts.index')
@section('content')

<title>Final Sales Invoice</title>

@php
use NumberToWords\NumberToWords;
$numberToWords = new NumberToWords();
$numberTransformer = $numberToWords->getNumberTransformer('en');

@endphp


<div class="invoice">
{{-- 
  <center><img src="{{ url($company_info->banner) }}" id="header_image" class="img-fluid" style="max-height: 130px;"></center> --}}

  <br>


  <table class="table table-bordered w-100">
    <tr class="bg-light">
      <td colspan="10" style="text-align:center;font-size: 15px;text-transform: capitalize;font-weight: bold;"><b>Purchase Invoice</b><br>DSR: {{ $data->staff_name }}</td>
    </tr>
   
    <tr class="text-center">
     <td colspan="12">
      Date : {{ date('d M Y',strtotime($data->invoice_date)) }}<br>
      Invoice No : {{ $data->invoice_no }} <br>
      Transaction : {{ $data->transaction_type }}<br>
      Print  : {{ date('d M Y') }}, {{date("h:i:s a")}}<br>

    </td>

  </tr>



  <tr class="bg-light">
   <th>SL</th>
   <th>Product</th>
   <th>Carton/Piece</th>
   <th>Price</th>
   <th>Sub Total</th>
 </tr>


 <tbody>

  @php
  $i=1;
  $totalpurchaseamount = 0;
  @endphp
  @if(isset($product))
  @foreach($product as $p)

  @php
  $product = DB::table("products")->where("id",$p->product_id)->first();


  $sqty = DB::table("stocks")->where("invoice_no",$data->invoice_no)->where("product_id",$p->product_id)->where('status',Null)->sum("qty");
  $returnqty = DB::table("stocks")->where("invoice_no",$data->invoice_no)->where("product_id",$p->product_id)->where('status',Null)->sum("returnqty");

  $salescartons = floor($sqty / $product->unit_per_group);
  $salesremainingPieces = $sqty % $product->unit_per_group;

  $returncartons = floor($returnqty / $product->unit_per_group);
  $returnremainingPieces = $returnqty % $product->unit_per_group;


  $finalsalesqty = $sqty - $returnqty;
  $finalsalescartons = floor($finalsalesqty / $product->unit_per_group);
  $finalsalesremainingPieces = $finalsalesqty % $product->unit_per_group;

  $piece_price = $p->sales_price/$product->unit_per_group;
  $totalpieceprice = $piece_price*$finalsalesremainingPieces;
  $damageprice = $p->damage*$piece_price;


  $subtotal = (($finalsalescartons*$p->sales_price)+$totalpieceprice)-$damageprice;
  $totalpurchaseamount = $totalpurchaseamount+$subtotal;


  @endphp

  
@if($sqty > 0 || $p->damage > 0)

  <tr>
    <td>{{ $i++ }}</td>
    <td>{{ $p->product_name }}</td>
    <td>@if($p->carton > 0) {{ $p->carton }} @else 0 @endif -  @if($p->piece > 0) {{ $p->piece }} @else 0 @endif</td>

    <td>{{ $p->sales_price }}</td>
    <td class="text-right">

      @if($p->carton == null and $p->piece == null)

      (-) {{ number_format($p->damage*$piece_price,2) }} /-

      @else

      {{ number_format($subtotal,2) }} /-

      @endif

    </td>

  </tr>

  @endif


  @endforeach
  @endif


</tbody>



<tr style="font-size: 16px;">

  <th colspan="4" style="text-align: right;">
    Total Amount :<br>
    Discount :<br>
    Transport Cost :<br>
    DSR Cost :<br>
    Grand Total :<br>
    Paid :<br>
    Due :
  </th>




  <th colspan="2" class="text-right">
    {{ number_format($data->total,2) }} /- <br>
    {{ number_format($data->discount,2) }} /-<br>
    {{ number_format($data->transport_cost,2) }} /-<br>
    {{ number_format($data->dsr_cost,2) }} /-<br>
    {{ number_format($data->grandtotal,2) }} /-<br>
    {{ number_format($data->paid,2) }} /-<br>
    {{ number_format($data->due,2) }} /-<br>

  </th>


</tr>


</table>

<span class="note">
  <span style="text-transform: capitalize; font-size: 14px;"><b>In Word: </b> {{ $numberTransformer->toWords($data->grandtotal) }} Taka Only.</span>
</span>




<br><br>

<div class="row" style="font-size: 14px!important;">
  <div class="col-4">
    --------------------<br>
    DSR Signature
  </div>
  <div class="col-4" style="text-align:center;">
    <br>
    --------------------<br>
    Prepared By
  </div>
  <div class="col-4" style="text-align:right;">
    --------------------<br>
    Authorized  Signature
  </div>
</div>
<br>
<center><span style="font-size: 13px; color: gray;">Developer By SoftwarefarmBD. <br>Phone: 01788283580</span></center>
<br>
<center><a href="#" class="btn btn-danger btn-sm print w-10" onclick="window.print();">Print</a></center>
<br>

</div>


@endsection