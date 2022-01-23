<div>
  <div class="flex flex-col">
    <div class="mb-4 flex flex-col md:flex-row md:items-end md:space-x-4 space-y-2 md:space-y-0">
      <div>
        <x-jet-input type="text" placeholder="Search..." wire:model.debounce="search" />
      </div>
      <div>
        @if (auth()->user()->hasPermissionTo('claims.create'))
        <x-jet-button type="button" wire:click="$emitTo('claims.form', 'add')">
          Register a Claim
        </x-jet-button>
        @endif
      </div>
      @if (auth()->user()->hasPermissionTo('claims.generate-report'))
      <div>
        @livewire('claims.report')
      </div>
      @endif
    </div>

    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8 h-screen">
      <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
        <div
        class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg bg-white divide-y divide-gray-200">
        @if ($claims->count())
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th scope="col" class="relative px-4 py-3">
                <span class="sr-only">Actions</span>
              </th>
              <th scope="col"
              class="px-4 py-3 text-left text-xs font-medium text-shark uppercase tracking-wider">
              <x-column-sorter column="claims.id">
                Claim Number
              </x-column-sorter>
            </th>
            <th scope="col"
            class="px-4 py-3 text-left text-xs font-medium text-shark uppercase tracking-wider">
            <x-column-sorter column="claims.client_name">
              Client Name
            </x-column-sorter>
          </th>
          <th scope="col"
          class="px-4 py-3 text-left text-xs font-medium text-shark uppercase tracking-wider">
          <x-column-sorter column="claims.insurer">
            Insurer
          </x-column-sorter>
        </th>
        <th scope="col"
        class="px-4 py-3 text-left text-xs font-medium text-shark uppercase tracking-wider">
        <x-column-sorter column="claims.policy_number">
          Policy Number
        </x-column-sorter>
      </th>
      <th scope="col"
      class="px-4 py-3 text-left text-xs font-medium text-shark uppercase tracking-wider">
      <x-column-sorter column="advisers.name">
        Adviser
      </x-column-sorter>
    </th>
    <th scope="col"
    class="px-4 py-3 text-left text-xs font-medium text-shark uppercase tracking-wider">
    <x-column-sorter column="claims.nature">
      Nature
    </x-column-sorter>
  </th>
  <th scope="col"
  class="px-4 py-3 text-left text-xs font-medium text-shark uppercase tracking-wider">
  <x-column-sorter column="claims.type">
    Type
  </x-column-sorter>
</th>
<th scope="col"
class="px-4 py-3 text-left text-xs font-medium text-shark uppercase tracking-wider">
<x-column-sorter column="claims.status">
  Status
</x-column-sorter>
</th>
<th scope="col"
class="px-4 py-3 text-left text-xs font-medium text-shark uppercase tracking-wider">
<x-column-sorter column="claims.created_at">
  Date Registered
</x-column-sorter>
</th>
<th scope="col"
class="px-4 py-3 text-left text-xs font-medium text-shark uppercase tracking-wider">
<x-column-sorter column="claims.created_at">
  Days Counter
</x-column-sorter>
</th>

@if (auth()->user()->hasPermissionTo('claims.delete'))
<th scope="col"
class="px-4 py-3 text-left text-xs font-medium text-shark uppercase tracking-wider">
<span class="sr-only">Delete Action</span>
</th>
@endif
</tr>
</thead>
<tbody>
  @foreach ($claims as $index => $claim)
  <tr class="{{ $index % 2 ? 'bg-gray-50' : 'bg-white' }}">
    <td class="px-4 py-2 whitespace-nowrap text-left text-sm">
      <x-jet-dropdown align="bottom" content-classes="py-1 bg-white divide-y divide-gray-200">
        <x-slot name="trigger">
          <button type="button"
          class="text-lmara hover:text-dsgreen" title="Actions">
          <x-heroicon-o-dots-vertical class="h-6 w-6" />
        </button>
      </x-slot>
      <x-slot name="content">
        <x-jet-dropdown-link href="javascript:void(0)"
        wire:click="$emitTo('claims.form', 'edit', {{ $claim->id }})">
        @if (auth()->user()->hasPermissionTo('claims.update'))
        Update
        @else
        View Details
        @endif
      </x-jet-dropdown-link>
      @if (auth()->user()->hasPermissionTo('claims.view-pdf'))
      <x-jet-dropdown-link href="javascript:void(0)"
      wire:click="showPdf({{ $claim->id }})">
      View PDF
    </x-jet-dropdown-link>
    @endif
  </x-slot>
</x-jet-dropdown>
</td>

<td class="px-4 py-2 whitespace-nowrap text-sm text-shark text-opacity-75">
  {{ $claim->number }}
</td>
<td class="px-4 py-2 whitespace-nowrap text-sm text-shark text-opacity-75">
  {{ $claim->client_name }}
</td>
<td class="px-4 py-2 whitespace-nowrap text-sm text-shark text-opacity-75">
  {{ $claim->insurer }}
</td>
<td class="px-4 py-2 whitespace-nowrap text-sm text-shark text-opacity-75">
  {{ $claim->policy_number }}
</td>
<td class="px-4 py-2 whitespace-nowrap text-sm text-shark text-opacity-75">
  {{ $claim->adviser->adviser_name }}
</td>
<td class="px-4 py-2 whitespace-nowrap text-sm text-shark text-opacity-75">
  {{ $claim->nature }}
</td>
<td class="px-4 py-2 text-sm text-shark text-opacity-75">
  {{ $claim->types }}
</td>
<td class="px-4 py-2 whitespace-nowrap text-sm text-shark text-opacity-75">
  {{ $claim->status }}
</td>
<td class="px-4 py-2 whitespace-nowrap text-sm text-shark text-opacity-75">
  {{ $claim->created_at->format('d/m/Y') }}
</td>
<td class="px-4 py-2 whitespace-nowrap text-sm text-shark text-opacity-75">
  {{ number_format($claim->day_counter) }}
</td>

@if (auth()->user()->hasPermissionTo('claims.delete'))
<td class="px-4 py-2 whitespace-nowrap text-sm text-shark text-opacity-75">
  <button type="button" class="text-red-500 hover:text-red-700" title="Delete"
  wire:click="confirmDelete({{ $claim->id }})">
  <x-heroicon-o-trash class="h-6 w-6" />
</button>
</td>
@endif
</tr>
@endforeach
</tbody>
</table>
{{ $claims->links() }}
@else
<p class="text-shark px-4 py-3">No available claims.</p>
@endif
</div>
</div>
</div>
</div>

<x-jet-dialog-modal wire:model="showPdf" max-width="5xl" focusable>
  <x-slot name="title">Claim PDF</x-slot>
  <x-slot name="content">
    <iframe src="{{ $this->PdfUrl }}" class="w-full" style="height: 600px;"></iframe>
  </x-slot>
  <x-slot name="footer">
    <x-jet-secondary-button type="button" wire:click="$set('showPdf', false)">Close</x-jet-secondary-button>
  </x-slot>
</x-jet-dialog-modal>

<x-jet-confirmation-modal wire:model="showDelete">
  <x-slot name="title">Delete Claim</x-slot>
  <x-slot name="content">Are you sure to delete this claim?</x-slot>
  <x-slot name="footer">
    <x-jet-button type="button" wire:click="delete">Yes</x-jet-button>
    <x-jet-secondary-button type="button" class="ml-2" wire:click="$set('showDelete', false)">No
    </x-jet-secondary-button>
  </x-slot>
</x-jet-confirmation-modal>
</div>
