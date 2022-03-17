@extends('layouts.pdf')

@section('pdfTitle')
<div class="header-title-lg">Claims Register</div>
<div class="header-title-sm">Report</div>
@endsection

@section('content')
<p>&nbsp;</p>
<table class="table-striped w-full">
  <tr>
    <td class="p-2">
      Period: <span
      class="font-bold">{{ \Illuminate\Support\Carbon::parse($filter['created_from'])->format('d/m/Y') }}</span>
      - <span
      class="font-bold">{{ \Illuminate\Support\Carbon::parse($filter['created_to'])->format('d/m/Y') }}</span>
    </td>
  </tr>
  <tr>
    <td class="p-2">Advisers:
      <span class="font-bold">{{ isset($advisers) ? $advisers->implode(', ') : 'All' }}</span>
    </td>
  </tr>
  <tr>
    <td class="p-2">Number of Claims Received:
      <span class="font-bold">{{ $claims->count() }}</span>
    </td>
  </tr>
</table>

<br>


@php

$num_in_progress = 0;
$num_continuing = 0;
$num_disapproved = 0;
$num_approved = 0;
$num_partially_approved = 0;

$num_life = 0;
$num_trauma = 0;
$num_medical = 0;
$num_tpd = 0;
$num_ip = 0;


$nature_pre_approval = 0;
$nature_claim = 0;


foreach ($claims as $key => $value) {
  if(str_contains($value->status, 'Progress')){
    $num_in_progress++;
  }else if(str_contains($value->status, 'Continuing')){
    $num_continuing++;
  }else if(str_contains($value->status, 'Disapproved')){
    $num_disapproved++;
  } else if(str_contains($value->status, 'Partially')){
    $num_partially_approved++;
  }else if(str_contains($value->status, 'Approved')){
    $num_approved++;
  }

}

foreach ($claims as $key => $value) {

  if(str_contains($value->types, 'Life')){
    $num_life++;
  }

  if(str_contains($value->types, 'Trauma')){
    $num_trauma++;
  }

  if(str_contains($value->types, 'Medical')){
    $num_medical++;
  }

  if(str_contains($value->types, 'TPD')){
    $num_tpd++;
  }

  if(str_contains($value->types, 'IP')){
    $num_ip++;
  }

}


foreach ($claims as $key => $value) {
  if($value->nature == 'Pre-approval'){
    $nature_pre_approval++;
  }else if($value->nature == 'Claim'){
    $nature_claim++;
  }
}


@endphp

<table class="table-striped border w-full">

  <tr>
    <td class="p-2">
      <b>Status</b>
    </td>
  </tr>

  <tr>

    <td class="p-2">
      Continuing: 
    </td>
    <td class="p-2 text-center" style="text-align: center">
      {{ $num_continuing }}  &emsp; &emsp;
    </td> 

    <td class="p-2">
      Disapproved:
    </td>
    <td class="p-2 text-center" style="text-align: center">
      {{ $num_disapproved }}  &emsp; &emsp;
    </td> 

    <td class="p-2">
      In Progress:
    </td>
    <td class="p-2" align="center">
      {{ $num_in_progress }}  &emsp; &emsp;
    </td>



  </tr>

  <tr>

    <td class="p-2">
      Approved:
    </td>
    <td class="p-2 text-center" style="text-align: center">
      {{ $num_approved }}  &emsp; &emsp;
    </td>

    <td class="p-2">
      Partially Approved:
    </td>
    <td class="p-2 text-center" style="text-align: center">
      {{ $num_partially_approved }}  &emsp; &emsp;
    </td>

    <td class="p-2">

    </td>
    <td class="p-2 text-center" style="text-align: center">

    </td>
    
  </tr>

</table>

<br>

<table class="table-striped border w-full">

  <tr>
    <td class="p-2">
      <b>Type</b>
    </td>
  </tr>

  <tr>

    <td class="p-2" style=" width: 18% !important;">
      Life: 
    </td>
    <td class="p-2 text-center" style="text-align: center; width: 16% !important">
      {{ $num_life }}  &nbsp;
    </td> 

    <td class="p-2">
     &nbsp; Medical: 
   </td>
   <td class="p-2 text-center" style="text-align: right; width: 22% !important">
    {{ $num_medical }}  &emsp; &emsp;  &emsp; &nbsp; &nbsp;
  </td> 

  <td class="p-2" style=" width:  10% !important">
   &nbsp; IP: 
 </td>
 <td class="p-2" style="text-align: center;  width: 16% !important">
  &nbsp; {{ $num_ip }} 
</td>

</tr>

<tr>

  <td class="p-2" style=" width: 18% !important;">
    Trauma: 
  </td>
  <td class="p-2 text-center" style="text-align: center; width: 16% !important">
    {{ $num_trauma }}  &nbsp;
  </td> 

  <td class="p-2">
   &nbsp; TPD: 
 </td>
 <td class="p-2 text-center" style="text-align: right; width: 22% !important">
  {{ $num_tpd }}  &emsp; &emsp;  &emsp; &nbsp; &nbsp;
</td> 

<td class="p-2" style=" width:  10% !important">
  
</td>
<td class="p-2" style="text-align: center;  width: 16% !important">
 
</td>



</tr>

</table>

<br>

<table class="table-striped border w-full">

  <tr>
    <td class="p-2">
      <b>Nature</b>
    </td>
  </tr>

  <tr>
    <td class="p-2" style=" width: 15% !important">
      Pre-approval: 
    </td>
    <td class="p-2 text-center" style="text-align: center; width: 16% !important">
      &nbsp; {{ $nature_pre_approval }}
    </td> 

    <td class="p-2" style=" width: 16% !important">
      &nbsp; Claim: 
    </td>
    <td class="p-2 text-center" style="text-align: right;  width: 22% !important">
     {{ $nature_claim }}  &emsp; &emsp;  &emsp; &nbsp;
   </td> 

   <td class="p-2" style=" width: 10% !important">
     <span style="visibility: hidden;">TPD:</span>
   </td>
   <td class="p-2 text-center" style="text-align: center;  width: 16% !important">
    <span style="visibility: hidden;">{{ $num_tpd }}</span>
  </td>


</tr>


</table>

<br>

<p>&nbsp;</p>

@if ($claims->count())
<table class="table-striped w-full">
  <tr>
    <th class="p-2 text-left">Claim Number</th>
    <th class="p-2 text-left">Client Name</th>
    <th class="p-2 text-left">Insurer</th>
    <th class="p-2 text-left">Policy Number</th>
    <th class="p-2 text-left">Adviser</th>
    <th class="p-2 text-left">Nature</th>
    <th class="p-2 text-left">Type</th>
    <th class="p-2 text-left">Status</th>
  </tr>
  @foreach ($claims as $claim)
  <tr>
    <td class="p-2">{{ $claim->number }}</td>
    <td class="p-2">{{ $claim->client_name }}</td>
    <td class="p-2">{{ $claim->insurer }}</td>
    <td class="p-2">{{ $claim->policy_number }}</td>
    <td class="p-2">{{ $claim->adviser->adviser_name }}</td>
    <td class="p-2">{{ $claim->nature }}</td>
    <td class="p-2">{{ $claim->types }}</td>
    <td class="p-2">{{ $claim->status }}</td>
  </tr>
  @endforeach
</table>
@else
<p>No available claims.</p>
@endif
@endsection
