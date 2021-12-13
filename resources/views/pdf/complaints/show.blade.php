@extends('layouts.pdf')

@section('pdfTitle')
  <div class="header-title">Complaint</div>
@endsection

@section('content')
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <table class="table-striped w-full">
    <tr>
      <td class="p-2">Complaint Number:</td>
      <td class="py-2 w-quart">{{ $complaint->number }}</td>
      <td class="w-4">&nbsp;</td>
      <td class="p-2">&nbsp;</td>
      <td class="py-2 pr-2 w-quart">&nbsp;</td>
    </tr>
    <tr>
      <td class="p-2">Complainant Name:</td>
      <td class="py-2">{{ $complaint->complainant }}</td>
      <td class="w-4">&nbsp;</td>
      <td class="p-2">Label:</td>
      <td class="py-2 pr-2">{{ $complaint->label }}</td>
    </tr>
    <tr>
      <td class="p-2">Complainee Name:</td>
      <td class="py-2">{{ $complaint->complainee }}</td>
      <td class="w-4">&nbsp;</td>
      <td class="p-2">Label:</td>
      <td class="py-2 pr-2">{{ $complaint->complainee_label }}</td>
    </tr>
    <tr>
      <td class="p-2">Policy Number:</td>
      <td class="py-2">{{ $complaint->policy_number ?? 'N/A' }}</td>
      <td class="w-4">&nbsp;</td>
      <td class="p-2">Insurer:</td>
      <td class="py-2 pr-2">{{ $complaint->insurer ?? 'N/A' }}</td>
    </tr>
    <tr>
      <td class="p-2">Date Received:</td>
      <td class="py-2">{{ $complaint->received_at->format('d/m/Y') }}</td>
      <td class="w-4">&nbsp;</td>
      <td class="p-2">Date Registered:</td>
      <td class="py-2 pr-2">{{ $complaint->created_at->format('d/m/Y') }}</td>
    </tr>
    <tr>
      <td class="p-2">Date Acknowledged:</td>
      <td class="py-2">{{ $complaint->acknowledged_at->format('d/m/Y') }}</td>
      {{-- <td class="p-2">Days Counter:</td>
      <td class="py-2">{{ number_format($complaint->day_counter) }}</td> --}}
      <td class="w-4">&nbsp;</td>
      <td class="p-2">Nature of Complaint:</td>
      <td class="py-2 pr-2">{{ $complaint->nature }}</td>
    </tr>
  </table>

  <p>&nbsp;</p>
  <p>&nbsp;</p>

  <h1 class="section-title">&emsp;Tier</h1>

  <table class="table-striped w-full">
    <tr>
      <td class="p-2">Tier:</td>
      <td class="py-2 w-quart">{{ $complaint->tier['tier'] }}</td>
      <td class="w-4">&nbsp;</td>
      <td class="p-2">Handled By:</td>
      <td class="py-2 pr-2 w-quart">{{ $complaint->tier['handler'] }}</td>
    </tr>
    <tr>
      <td class="p-2">Adviser:</td>
      <td class="py-2">{{ $complaint->tier['handler'] == 'Adviser' ? $complaint->adviser->name . '(' . $complaint->adviser->type . ')' : 'N/A' }}</td>
      <td class="w-4">&nbsp;</td>
      <td class="p-2">Status:</td>
      <td class="py-2 pr-2">{{ $complaint->tier['status'] }}</td>
    </tr>
    <tr>
      <td class="p-2">Date Completed:</td>
      <td class="py-2">
        {{ $complaint->tier['completed_at'] ?? '' ? \Illuminate\Support\Carbon::parse($complaint->tier['completed_at'])->format('d/m/Y') : '' }}
      </td>
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
      <td class="p-2">Summary:</td>
      <td colspan="4" class="py-2 pr-2">{{ $complaint->tier['summary'] ?? '' }}</td>
    </tr>
  </table>

  <p>&nbsp;</p>
  <p>&nbsp;</p>

  <h1 class="section-title">&emsp;Notes</h1>

  <div class="table-striped">
    @if ($complaint->notes()->count())
      <div>
        <div class="float-left p-2 font-bold" style="width: 150px; min-width:150px; max-width: 150px;">Date Added</div>
        <div class="float-left p-2 font-bold" style="width:125px; min-width:125px; max-width: 125px;">Noted By</div>
        <div class="float-left p-2 font-bold" style="width:324px; min-width:324px; max-width: 324px;">Notes</div>
      </div>
      @foreach ($complaint->notes()->latest('created_at')->get()
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
