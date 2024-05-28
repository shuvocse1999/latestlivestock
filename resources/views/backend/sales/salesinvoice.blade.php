@extends('backend.reports.layouts.index')
@section('content')

<title>Pending Sales Invoice</title>

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
      <td colspan="11" style="text-align:center;font-size: 15px;text-transform: capitalize;font-weight: bold;"><b>Pending Sales Invoice</b><br>DSR: {{ $data->staff_name }}</td> 
    </tr>
    <tr class="text-center">
     <td colspan="12">
      Market : {{ $data->market }} <br>
      Date : {{ date('d M Y',strtotime($data->invoice_date)) }}<br>
      Invoice No : <b>{{ $data->invoice_no }}</b> <br>
      Print  : {{ date('d M Y') }}, {{date("h:i:s a")}}<br>

    </td>


  </tr>



  <!-- <thead> -->
   <tr class="bg-light text-center">
     <th>SL</th>
     <th style="width:400px;">Product</th>
     <th>Carton/Piece</th>
     <th>Free</th>
     <th>R. Free</th>
     <th>R. Carton/Piece</th>
     <th>Damage</th>
     <th>Price</th>
     <th>Sub Total</th>
   </tr>
   <!-- </thead> -->



   <tbody>

    @php
    $i=1;
    $totalpurchaseamount = 0;
    @endphp
    @if(isset($product))
    @foreach($product as $p)

    @php
    $product = DB::table("products")->where("id",$p->product_id)->first();
    $piece_price = $p->sales_price/$product->unit_per_group;
    $totalpieceprice = $piece_price*$p->piece;
    $subtotal = ($p->carton*$p->sales_price)+$totalpieceprice;
    $totalpurchaseamount = $totalpurchaseamount+$subtotal;
    @endphp

    <tr class="text-center">
      <td>{{ $i++ }}</td>
      <td>{{ $p->product_name }}</td>
      <td>@if($p->carton>0){{ $p->carton }} @else 0 @endif - @if($p->piece>0){{ $p->piece }} @else 0 @endif</td>
      <td>@if($p->free>0){{ $p->free }} @else 0 @endif</td>
      <td></td>
      <td>{{ $p->returnscarton }} - {{ $p->returnspiece }}</td>
      <td>{{ $p->damage }}</td>
      <td>{{ $p->sales_price }}</td>
      <td class="text-right">{{ number_format($subtotal,2) }} /-</td>

    </tr>

    @endforeach
    @endif



  </tbody>



  <tr style="font-size: 16px;">

    <th colspan="8" style="text-align: right;">
      Total Amount :<br>
      Discount :<br>
      Grand Total :<br>
      Due :
    </th>




    <th colspan="2" class="text-right">
      {{ number_format($data->total,2) }} /- <br>
      {{ number_format($data->discount,2) }} /-<br>
      {{ number_format($data->grandtotal,2) }} /-<br>
      {{ number_format($data->due,2) }} /-<br>

    </th>


  </tr>


</table>

<br><br><br>
<table class="table table-bordered w-100">


 <tr style="font-size: 16px;">
  <td colspan="11" class="text-center bg-light">DSR Form Fillup</td>
</tr>



<tr style="font-size: 16px;">
  <th width="90%" class="text-right">Transport Cost :</th>
  <td></td>
</tr>

<tr style="font-size: 16px;">
  <th width="90%" class="text-right">DSR Cost :</th>
  <td></td>
</tr>

<tr style="font-size: 16px;">
  <th width="90%" class="text-right">Paid :</th>
  <td></td>
</tr>


<tr style="font-size: 16px;">
  <th width="90%" class="text-right">Due :</th>
  <td></td>
</tr>


<tr style="font-size: 16px;">
  <th width="90%" class="text-right">Due Collection :</th>
  <td></td>
</tr>



</table>

<span class="note">
  <span style="text-transform: capitalize; font-size: 16px;"><b>In Word: </b> {{ $numberTransformer->toWords($data->grandtotal) }} Taka Only.</span>
</span>




<br>
<br>

<div class="row" style="font-size: 16px;">
  <div class="col-4">
    --------------------<br>
    DSR Signature
  </div>
  <div class="col-4" style="text-align:center;">
    {{ $data->name }}<br>
    --------------------<br>
    Prepared By
  </div>
  <div class="col-4" style="text-align:right;">
    --------------------<br>
    Authorized  Signature
  </div>
</div>

<center><a href="#" class="btn btn-danger btn-sm print w-10" onclick="window.print();">Print</a></center>
<br>

</div>


<style type="text/css">
  

      .table-bordered td{
        border: 1px solid gray !important;
      }

      .table-bordered th{
        border: 1px solid gray !important;
      }
</style>


@endsection