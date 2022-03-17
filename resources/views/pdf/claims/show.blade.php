@extends('layouts.pdf')

@section('pdfTitle')
<div class="header-title">Claim</div>
@endsection

@section('content')
<p>&nbsp;</p>
<table class="table-striped w-full">
  <tr>
    <td class="p-2"><b>Claim Number:</b></td>
    <td class="py-2 w-quart">{{ $claim->number }}</td>
    <td class="w-4">&nbsp;</td>
    <td class="p-2"><b>Client Name:</b></td>
    <td class="py-2 pr-2 w-quart">{{ $claim->client_name }}</td>
  </tr>
  <tr>
    <td class="p-2"><b>Insurer:</b></td>
    <td class="py-2">{{ $claim->insurer }}</td>
    <td class="w-4">&nbsp;</td>
    <td class="p-2"><b>Policy Number:</b></td>
    <td class="py-2 pr-2">{{ $claim->policy_number }}</td>
  </tr>
  <tr>
    <td class="p-2"><b>Adviser:</b></td>
    <td class="py-2">{{ $claim->adviser->name }}</td>
    <td class="w-4">&nbsp;</td>
    <td class="p-2"><b>Nature:</b></td>
    <td class="py-2 pr-2">{{ $claim->nature }}</td>
  </tr>
  <tr>
    <td class="p-2"><b>Type:</b></td>
    <td class="py-2">{{ collect($claim->type)->implode(', ') }}</td>
    <td class="w-4">&nbsp;</td>
    <td class="p-2"><b>Status:</b></td>
    <td class="py-2 pr-2">{{ $claim->status }}</td>
  </tr>
</table>

<p>&nbsp;</p>
<h1 class="section-title">&emsp;Notes</h1>

<div class="table-striped">
  @if ($claim->notes()->count())
  <div>
    <div class="float-left p-2 font-bold" style="width: 150px; min-width:150px; max-width: 150px;"><b>Date Added</b></div>
    <div class="float-left p-2 font-bold" style="width:125px; min-width:125px; max-width: 125px;"><b>Noted By</b></div>
    <div class="float-left p-2 font-bold" style="width:324px; min-width:324px; max-width: 324px;"><b>Notes</b></div>
  </div>
  @foreach ($claim->notes()->latest('created_at')->get()
  as $key => $note)
  <div class="{{ $key % 2 == 0 ? 'bg-gray' : null }}">
    <div class="float-left p-2" style="width:150px ; min-width:150px ; max-width:150px ;">{{ $note->created_at->format('d/m/Y h:i A') }}</div>
    <div class="float-left p-2" style="width:125px ; min-width:125px ; max-width:125px ;">{{ $note->creator->name }}</div>
    <div class="float-left p-2" style="width:324px ; min-width:324px ; max-width:324px ;">{{ $note->notes }}</div>
  </div>
  @endforeach
  @else
  <div class="p-2">
    No available notes.
  </div>
  @endif
</div>
@endsection
