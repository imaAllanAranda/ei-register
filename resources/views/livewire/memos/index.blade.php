<div>
  <div class="flex flex-col">
    <div class="mb-4 flex flex-col md:flex-row md:items-end md:space-x-4 space-y-2 md:space-y-0">
      <div>
        <x-jet-input type="text" placeholder="Search..." wire:model.debounce="search" />
      </div>

      @if (auth()->user()->hasPermissionTo('memos.create'))
      <div>
        <x-jet-button type="button" wire:click="$emitTo('memos.form', 'add')">
          Register a Memo
        </x-jet-button>
      </div>
      @endif
    </div>

    <div class="mb-4">
      <div class="sm:hidden">
        <label for="tabs" class="sr-only">Select a tab</label>
      </div>
      <div class="hidden sm:inline-block">
        <nav class="relative z-0 rounded-lg shadow flex divide-x divide-gray-200" aria-label="Tabs">

        </nav>
      </div>
    </div>

    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8 h-screen">
      <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
        <div class="shadow {{-- overflow-hidden --}} border-b border-gray-200 sm:rounded-lg bg-white divide-y divide-gray-200">



          @if ($memos->count())
          <table class="min-w-full divide-y divide-gray-200 sm:rounded-lg">
            <thead class="bg-gray-50 sm:rounded-t-lg">
              <tr>
                <th scope="col" class="relative px-4 py-3 sm:rounded-tl-lg">
                  <span class="sr-only">Actions</span>
                </th>

                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-shark uppercase tracking-wider">
                  <x-column-sorter column="type">
                    Memo Num
                  </x-column-sorter>
                </th>
                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-shark uppercase tracking-wider">
                  <x-column-sorter column="name">
                    Subject
                  </x-column-sorter>
                </th>


                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-shark uppercase tracking-wider">
                  <x-column-sorter column="email">
                    Writer
                  </x-column-sorter>
                </th>

                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-shark uppercase tracking-wider">
                  <x-column-sorter column="fsp_no">
                    Recipient
                  </x-column-sorter>
                </th>

                {{-- <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-shark uppercase tracking-wider">
                  <x-column-sorter column="fsp_no">
                    Memo Date
                  </x-column-sorter>
                </th> --}}

                @if (auth()->user()->hasPermissionTo('memos.delete'))
                <th scope="col" class="relative px-4 py-3 sm:rounded-tr-lg">
                  <span class="sr-only">Delete Action</span>
                </th>
                @endif

              </tr>
            </thead>

            <tbody>

              @foreach ($memos as $index => $memo)
              <tr class="{{ $index % 2 ? 'bg-gray-50' : 'bg-white' }}">

                <td class="px-4 py-2 whitespace-nowrap text-left text-sm font-medium">
                  <x-jet-dropdown align="top-left" content-classes="py-1 bg-white divide-y divide-gray-200">
                    <x-slot name="trigger">
                      <button type="button" class="text-lmara hover:text-dsgreen" title="Actions">
                        <x-heroicon-o-dots-vertical class="h-6 w-6" />
                      </button>
                    </x-slot>
                    <x-slot name="content">
                      <x-jet-dropdown-link href="javascript:void(0)" wire:click="$emitTo('memos.form', 'edit', {{ $memo->id }})">

                        @if (auth()->user()->hasPermissionTo('memos.update'))Update

                        @else
                        View Details
                        @endif

                      </x-jet-dropdown-link>

                      @if (auth()->user()->hasPermissionTo('memos.view-pdf'))

                      <x-jet-dropdown-link href="javascript:void(0)" wire:click="showPdf({{ $memo->id }})">View PDF</x-jet-dropdown-link>

                      @endif

                    </x-slot>
                  </x-jet-dropdown>
                </td>

                <td>{{ $memo->memo_num }}</td>
                <td>{{ $memo->subject }}</td>
                <td>{{ $memo->name_of_writer }}</td>
                <td>{{ $memo->recipient }}</td>
                {{-- <td>{{ $memo->memo_date }}</td> --}}


                @if (auth()->user()->hasPermissionTo('memos.delete'))
                <td class="px-4 py-2 whitespace-nowrap text-sm text-shark text-opacity-75">
                  <button type="button" class="text-red-500 hover:text-red-700" title="Delete"
                  wire:click="confirmDelete({{ $memo->id }})">
                  <x-heroicon-o-trash class="h-6 w-6" />
                </button>

                 <button type="button" class="text-green-500 hover:text-green-700" title="Send Email Memo" onclick="showConfirm({{ $memo->id }},{{ $memo->memo_type }})">
                  <x-heroicon-o-mail class="h-6 w-6" />
                </button>
              </td>
              @endif

            </tr>
            @endforeach
          </tbody>



        </table>
        {{ $memos->links() }}
        @else
        <p class="text-shark px-4 py-3">No available memo.</p>
        @endif

      </div>
    </div>
  </div>
</div>
<div id='loadPage' style="display:none;"></div>


<x-jet-dialog-modal wire:model="showPdf" max-width="5xl" focusable>
  <x-slot name="title">Memo PDF</x-slot>
  <x-slot name="content">
    <iframe src="{{ $this->PdfUrl }}" class="w-full" style="height: 600px;"></iframe>
  </x-slot>
  <x-slot name="footer">
    <x-jet-secondary-button type="button" wire:click="$set('showPdf', false)">Close</x-jet-secondary-button>
  </x-slot>
</x-jet-dialog-modal>


<x-jet-confirmation-modal wire:model="showDelete">
  <x-slot name="title">Delete Memo</x-slot>
  <x-slot name="content">Are you sure to delete this memo?</x-slot>
  <x-slot name="footer">
    <x-jet-button type="button" wire:click="delete">Yes</x-jet-button>
    <x-jet-secondary-button type="button" class="ml-2" wire:click="$set('showDelete', false)">No
    </x-jet-secondary-button>
  </x-slot>
</x-jet-confirmation-modal>


</div>
<script type="text/javascript">
  function showConfirm(id,type){
      swal.fire({
      title: 'Send Email Memo',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, Send it!'
    }).then((result) => {
      if(result.isConfirmed){
           $('#loadPage').load('https://localhost/ei-portal/memo_pdf?id='+id+'&mail=1&userType='+type);
            setTimeout(function() {
              swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Email Sent!',
                    showConfirmButton: false
                  })
            }, 2000);
          }else{

          }
    })

  }
</script>
