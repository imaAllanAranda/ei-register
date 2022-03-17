@extends('layouts.pdf')

@section('pdfTitle')
<div class="header-title-lg">Complaints Register</div>
<div class="header-title-sm">Report</div>
@endsection

@section('content')
<p>&nbsp;</p>
<table class="table-striped w-full">
  <tr>
    <td class="p-2">
      Period: &emsp;&emsp;<span
      class="font-bold">{{ \Illuminate\Support\Carbon::parse($filter['received_from'])->format('d/m/Y') }}</span>
      - <span
      class="font-bold">{{ \Illuminate\Support\Carbon::parse($filter['received_to'])->format('d/m/Y') }}</span>
    </td>
  </tr>
  <tr>
    <td class="p-2">Advisers: &emsp;
      <span class="font-bold">{{ isset($advisers) ? $advisers->implode(', ') : 'All' }}</span>
    </td>
  </tr>
  <tr>
    <td class="p-2">Number of Complaints Received: &nbsp;
      <span class="font-bold">{{ $complaints->count() }}</span>
    </td>
  </tr>
</table>

<br>

@php

$num_pending = 0;
$num_resolved = 0;
$num_failed = 0;
$num_retracted = 0;
$num_invalid = 0;
$num_deadlock = 0;

$num_tier_1 = 0;
$num_tier_2 = 0;

$nature_adviser = 0;
$nature_admin = 0;
$nature_marketer = 0;
$nature_management = 0;
$nature_contract = 0;
$nature_conduct = 0;

foreach ($complaints as $key => $value) {
  if(str_contains($value->status, 'Pending')){
    $num_pending++;
  }else if(str_contains($value->status, 'Resolved')){
    $num_resolved++;
  }else if(str_contains($value->status, 'Failed')){
    $num_failed++;
  } else if(str_contains($value->status, 'Retracted')){
    $num_retracted++;
  }else if(str_contains($value->status, 'Invalid')){
    $num_invalid++;
  }else if(str_contains($value->status, 'Deadlock')){
    $num_deadlock++;
  }
}


foreach ($complaints as $key => $value) {
  if(str_contains($value->status, '1')){
    $num_tier_1++;
  }else if(str_contains($value->status, '2')){
    $num_tier_2++;
  }
}

foreach ($complaints as $key => $value) {
  if($value->nature == 'Service (Adviser)'){
    $nature_adviser++;
  }else if($value->nature == 'Service (Admin)'){
    $nature_admin++;
  }else if($value->nature == 'Service (Marketer)'){
    $nature_marketer++;
  }else if($value->nature == 'Service (Management)'){
    $nature_management++;
  }else if($value->nature == 'Contract'){
    $nature_contract++;
  }else if($value->nature == 'Conduct'){
    $nature_conduct++;
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
      Pending &emsp; &emsp;
    </td>
    <td class="p-2 text-center" style="text-align: center">
      {{ $num_pending }}  &emsp; &nbsp;
    </td> 

    <td class="p-2">
      Retracted &emsp; &emsp;
    </td>
    <td class="p-2 text-center" style="text-align: center">
      {{ $num_retracted }}  &emsp; &emsp;
    </td>

  </tr>

  <tr>

    <td class="p-2">
      Resolved &emsp; &emsp;
    </td>
    <td class="p-2" align="center">
      {{ $num_resolved }}  &emsp; &nbsp;
    </td>

    <td class="p-2">
      Invalid &emsp; &emsp;
    </td>
    <td class="p-2" align="center">
      {{ $num_invalid }}  &emsp; &emsp;
    </td>

  </tr>

  <tr>

    <td class="p-2">
      Failed &emsp; &emsp;
    </td>
    <td class="p-2" align="center">
      {{ $num_failed }}  &emsp; &nbsp;
    </td>

    <td class="p-2">
      Deadlock &emsp; &emsp;
    </td>
    <td class="p-2" align="center">
      {{ $num_deadlock }}  &emsp; &emsp;
    </td>

  </tr>





</table>

<br>

<table class="table-striped border w-full">

  <tr>
    <td class="p-2">
      <b>Level</b>
    </td>
  </tr>

  <tr>
    <td class="p-2">
      Tier 1 
    </td>
    <td class="p-2 text-center" style="text-align: center">
      &emsp; &emsp;  &emsp; &nbsp; &nbsp; &nbsp;  &nbsp;  &nbsp;  {{ $num_tier_1 }}
    </td> 
    <td class="p-2">
      &nbsp; &nbsp; Tier 2  &emsp; &emsp;  &nbsp; &nbsp; &nbsp;  &nbsp;  &nbsp; &nbsp;

    </td>
    <td class="p-2 text-center" style="text-align: center">
      {{ $num_tier_2 }}  &emsp; &emsp; &nbsp;
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
    <td class="p-2">
      Service (Adviser)
    </td>
    <td class="p-2" align="center">
      {{ $nature_adviser }}   &emsp; &emsp;
    </td>

    <td class="p-2">
      Service (Management)
    </td>
    <td class="p-2 text-center" style="text-align: center">
      {{ $nature_management }}  &emsp; &emsp; &nbsp;
    </td>
  </tr>



  <tr>
    <td class="p-2">
      Service (Admin)
    </td>
    <td class="p-2" align="center">
      {{ $nature_admin }}   &emsp; &emsp;
    </td>

    <td class="p-2">
      Contract
    </td>
    <td class="p-2 text-center" style="text-align: center">
      {{ $nature_contract }}   &emsp; &emsp; &nbsp;
    </td>
  </tr>

  <tr>
    <td class="p-2">
      Service (Marketer)
    </td>
    <td class="p-2" align="center">
      {{ $nature_marketer }}   &emsp; &emsp;
    </td>

    <td class="p-2">
      Conduct
    </td>
    <td class="p-2 text-center" style="text-align: center">
      {{ $nature_conduct }}   &emsp; &emsp; &nbsp;
    </td>
  </tr>

</table>


<p>&nbsp;</p>

@if ($complaints->count())
<table class="table-striped w-full">
  <tr>
    <th class="p-2 text-left">Complaint Number</th>
    <th class="p-2 text-left">Complainant Name</th>
    <th class="p-2 text-left">Date Received</th>
    <th class="p-2 text-left">Nature of Complaint</th>
    <th class="p-2 text-left">Status</th>
  </tr>
  @foreach ($complaints as $complaint)
  <tr>
    <td class="p-2">{{ $complaint->number }}</td>
    <td class="p-2">{{ $complaint->complainant }}</td>
    <td class="p-2">{{ $complaint->received_at->format('d/m/Y') }}</td>
    <td class="p-2">{{ $complaint->nature }}</td>
    <td class="p-2">{{ $complaint->status }}</td>
  </tr>
  @endforeach
</table>
@else
<p>No available complaints.</p>
@endif
@endsection
