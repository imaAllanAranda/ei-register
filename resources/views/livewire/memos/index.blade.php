<div>
  <div class="flex flex-col">
    <div class="mb-4 flex flex-col md:flex-row md:items-end md:space-x-4 space-y-2 md:space-y-0">
      <!-- <div>
        <x-jet-input type="text" placeholder="Search..." wire:model.debounce="search" />
      </div> -->

      @if (auth()->user()->hasPermissionTo('memos.create'))
      <div>
        <x-jet-button type="button"  wire:click="$emitTo('memos.form', 'add')">
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

   <!--  <div class="mb-4 flex flex-col md:flex-row md:items-end md:space-x-4 space-y-2 md:space-y-0">
        <label>Search By</label><select id="memo_type" name="tabs" class="block focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md">
              <option value="1">Memo Number</option>
              <option value="1">Writer</option>
              <option value="1">Recipient</option>               
        </select>
    </div> -->
 
      <div style="background-color: white; padding:20px;" class="rounded-md focus:ring-indigo-500 focus:border-indigo-500 border-gray-300"> 
<table border="0" cellspacing="5" cellpadding="5">
        <tbody>
            <tr>
                <td> <p class="text-shark px-4 py-3">To:</p><td>
                <td><input class="border-gray-300 focus:border-dsgreen focus:ring focus:ring-lmara focus:ring-opacity-50 rounded-md shadow-sm block w-full mt-1" name="min" id="min" type="text"></td>
                <td><p class="text-shark px-4 py-3">From:</p></td>
                <td><input class="border-gray-300 focus:border-dsgreen focus:ring focus:ring-lmara focus:ring-opacity-50 rounded-md shadow-sm block w-full mt-1" name="max" id="max" type="text"></td>
            </tr>
        </tbody>
    </table>

          @if ($memos->count())
          <table class="table" id="myTable">
            <thead>
              <tr>
                <th scope="col">
                  <span class="sr-only">Actions</span>
                </th>

               
                <th scope="col">
                  <x-column-sorter column="type">
                    Memo Num
                  </x-column-sorter>
                </th>

                 <th scope="col">
                  <x-column-sorter column="type">
                    Date Created
                  </x-column-sorter>
                </th>

                <th scope="col">
                  <x-column-sorter column="name">
                    Subject
                  </x-column-sorter>
                </th>


                <th scope="col">
                  <x-column-sorter column="email">
                    Writer
                  </x-column-sorter>
                </th>

                <th scope="col">
                  <x-column-sorter column="fsp_no">
                    Recipient
                  </x-column-sorter>
                </th>

                {{-- <th scope="col">
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
                      <x-jet-dropdown-link href="javascript:void(0)" onclick="loadContent()" wire:click="$emitTo('memos.form', 'edit', {{ $memo->id }})">

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
                <td>{{ date('m-d-Y', strtotime($memo->created_at ));  }}</td>
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

                 <button type="button" class="sendEmailButton{{$memo->id}}" style="    {{ ($memo->is_sent == 1 ) ? 'color:#0439b5;' : 'color:green;' }}  "  title="Send Email Memo" onclick="showConfirm({{ $memo->id }})">
                  <x-heroicon-o-mail class="h-6 w-6" />
                </button>
              </td>
              @endif

            </tr>
            @endforeach
          </tbody>



        </table>
      </div>
        {{ $memos->links() }}
        @else
        <p class="text-shark px-4 py-3">No available memo.</p>
        @endif

</div>

<style type="text/css">
 
#myTable_length{
  display: none!important;
}
#ui-datepicker-div{
    background: rgb(242, 242, 242)!important;
    padding: 20px!important;
    box-shadow: 20px 20px 50px grey!important;
    line-height: 2em!important;
    word-spacing: 30px!important;
  }
  .ui-datepicker-prev{
    display:none!important;
  }
  .ui-datepicker-next{
    display: none!important;
  }
</style>

<x-jet-dialog-modal wire:model="showPdf" max-width="5xl" focusable>
  <x-slot name="title">Memo PDF</x-slot>
  <x-slot name="content">

    <!-- https://onlineinsure.co.nz/portal -->
    <!-- https://onlineinsure.co.nz/stage/portal -->
    <!-- https://localhost/ei-portal/ -->

    <iframe src="https://localhost/ei-portal/memo_pdf?id={{$this->memoId}}" class="w-full" style="height: 600px;"></iframe>
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
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script type="text/javascript" src="http://keith-wood.name/js/jquery.signature.js"></script>
<link rel="stylesheet" type="text/css" href="http://keith-wood.name/css/jquery.signature.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>

<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>


<script type="text/javascript">


  function showConfirm(id){
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

    //  https://onlineinsure.co.nz/portal
    //  https://onlineinsure.co.nz/stage/portal
    //  https://localhost/ei-portal/
           $('#loadPage').load('https://localhost/ei-portal/memo_pdf?id='+id+'&mail=1');
            setTimeout(function() {
              swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Email Sent!',
                    showConfirmButton: false
                  })
              $(".sendEmailButton"+id).css('color','#0439b5');
            }, 2000);
          }else{

          }
    })

  }

var filter = 0;
$(document).ready( function () {
              $('#myTable').dataTable( {
         "pageLength": 25
        });
});


 $(document).ready(function(){
      $.fn.dataTable.ext.search.push(
      function (settings, data, dataIndex) {
          var min = $('#min').datepicker("getDate");
          var max = $('#max').datepicker("getDate");
          var startDate = new Date(data[2]);
          if (min == null && max == null) { return true; }
          if (min == null && startDate <= max) { return true;}
          if(max == null && startDate >= min) {return true;}
          if (startDate <= max && startDate >= min) { return true; }
          return false;
      }
      );

      $("#min").datepicker({ onSelect: function () { table.draw(); }, changeMonth: true, changeYear: true });
      $("#max").datepicker({ onSelect: function () { table.draw(); }, changeMonth: true, changeYear: true });
      var table = $('#myTable').DataTable();

      // Event listener to the two range filtering inputs to redraw on input
      $('#min, #max').change(function () {
          table.draw();
      });
});

function myFunction() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[3];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}

</script>
