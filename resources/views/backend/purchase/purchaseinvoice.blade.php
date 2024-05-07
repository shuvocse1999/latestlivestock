

@extends('backend.reports.layouts.index')
@section('content')

<title>Product Recieved Invoice</title>

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
      <td colspan="8" style="text-align:center;font-size: 15px;text-transform: capitalize;font-weight: bold;"><b>Didar Enterprise Limited 
<br>Product Recieve Invoice<br>{{ $data->supplier_name }}</b></td>
    </tr>
    <tr>
     <td colspan="4" class="text-center">
      Date : {{ date('d M Y',strtotime($data->invoice_date)) }}<br>
      <b>Voucher No : {{ $data->voucer }} <br></b>
      Supplier Info : {{ $data->supplier_name }}

    </td>
    <td colspan="4" class="text-center">
      Transaction : {{ $data->transaction_type }}<br>
      Prepared By : {{ $data->name }}<br>
      Print  : {{ date('d M Y') }}, {{date("h:i:s a")}}<br>

    </tr>



    <!-- <thead> -->
     <tr class="text-center bg-light">
       <th>SL</th>
       <th>Product</th>
       <th>Carton</th>
       <th>Piece</th>
       <th>Total QTY</th>
       <th>Free</th>
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
      $piece_price = $p->purchase_price/$product->unit_per_group;
      $totalpieceprice = $piece_price*$p->piece;
      $subtotal = ($p->carton*$p->purchase_price)+$totalpieceprice;
      $totalpurchaseamount = $totalpurchaseamount+$subtotal;
      @endphp

      <tr class="text-center">
        <td>{{ $i++ }}</td>
        <td>{{ $p->product_name }}</td>
        <td>{{ $p->carton }}</td>
        <td>{{ $p->piece }}</td>
        <td>{{ $p->qty }}</td>
        <td>{{ $p->free }}</td>
        <td>{{ $p->purchase_price }}</td>
        <td class="text-right">{{ number_format($subtotal,2) }} /-</td>

      </tr>

      @endforeach
      @endif


    </tbody>



    <tr style="font-size: 14px;">

      <th colspan="7" style="text-align: right;">
        Total Amount :<br>
        Discount :<br>
        Transport Cost :<br>
        Grand Total :<br>
        Paid :<br>
        Due :
      </th>




      <th class="text-right">
        {{ number_format($data->total,2) }} /- <br>
        {{ number_format($data->discount,2) }} /-<br>
        {{ number_format($data->transport_cost,2) }} /-<br>
        {{ number_format($data->grandtotal,2) }} /-<br>
        {{ number_format($data->paid,2) }} /-<br>
        {{ number_format($data->due,2) }} /-<br>

      </th>


    </tr>

    @php
     $ledger  = DB::table("purchase_ledger")->where("supplier_id",$data->supplier_id)->sum('grandtotal');
    $payment = DB::table("purchase_payment")->where("supplier_id",$data->supplier_id)->sum('payment');

    $due = $ledger - $payment;
    @endphp

    <tr  class="text-center">
      <th colspan="8" style="letter-spacing: 1px; font-size:20px;">Previous Due = ( {{ number_format($due,2) }} )</th>
    
    </tr>


  </table>

  <span class="note">
    <span style="text-transform: capitalize; font-size: 14px;"><b>In Word: </b> {{ $numberTransformer->toWords($data->grandtotal) }} Taka Only.</span>
  </span>




  <br> <br>

  <div class="row" style="font-size: 14px;">
    <div class="col-4">
      --------------------<br>
      Supplier's Signature
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
  <br>
  <center><span style="font-size: 13px; color: gray;">Developer By SoftwarefarmBD. <br>Phone: 01788283580</span></center>
  <br>
  <center><a href="#" class="btn btn-danger btn-sm print w-10" onclick="window.print();">Print</a></center>
  <br>

</div>




@endsection