<div>
  <x-form-modal wire:model="showModal" submit="submit" focusable>
    <x-slot name="title">{{ $this->title }}</x-slot>


    <x-slot name="content">
      <div class="space-y-6">


        {{-- <div class="form-input">
          <x-jet-label for="memo_num" value="Memo Number" />
          <x-jet-input type="text" id="memo_num" class="block w-full mt-1" wire:model.defer="input.memo_num" />
          <x-jet-input-error for="memo_num" class="mt-2" />
        </div> --}}
        <div class="form-input">
          <x-jet-label for="position_of_writer" value="Writer Position" />
          <x-jet-input type="text" id="update_data" class="block w-full mt-1 hidden" wire:model.defer="memoId" />
          <x-jet-input-error for="position_of_writer" class="mt-2" />
        </div>





        <div class="form-input">
          <x-jet-label for="recipient" value="Recipient" />
          <x-jet-input type="text" id="recipient" class="block w-full mt-1" wire:model.defer="input.recipient" />
          <x-jet-input-error for="recipient" class="mt-2" />
        </div>

        <div class="form-input">
          <x-jet-label for="recipient_company" value="Recipient Company" />
          <x-jet-input type="text" id="recipient_company" class="block w-full mt-1" wire:model.defer="input.recipient_company" />
          <x-jet-input-error for="recipient_company" class="mt-2" />
        </div>

        <div class="form-input">
          <x-jet-label for="recipient_address" value="Recipient Address" />
          <x-jet-input type="text" id="recipient_address" class="block w-full mt-1" wire:model.defer="input.recipient_address" />
          <x-jet-input-error for="recipient_address" class="mt-2" />
        </div>

        <div class="form-input">
          <x-jet-label for="subject" value="Subject" />
          <x-jet-input type="text" id="subject" class="block w-full mt-1" wire:model.defer="input.subject" />
          <x-jet-input-error for="subject" class="mt-2" />
        </div>

        <div class="form-input">
          <x-jet-label for="content" value="Content" />
          <x-textarea id="content" class="block w-full mt-1 resize-y" wire:model.defer="input.content" />
          <x-jet-input-error for="content" class="mt-2" />
        </div>



        <div class="form-input">
          <x-jet-label for="memo_date" value="Memo Date" />
          <x-date-picker id="memo_date" wire:model.defer="input.memo_date" />
          <x-jet-input-error for="memo_date" class="mt-2" />
        </div>




        <div class="form-input">
          <x-jet-label for="name_of_writer" value="Writer Name" />
          <x-jet-input type="text" id="name_of_writer" class="block w-full mt-1" wire:model.defer="input.name_of_writer" />
          <x-jet-input-error for="name_of_writer" class="mt-2" />
        </div>

        <div class="form-input">
          <x-jet-label for="position_of_writer" value="Writer Position" />
          <x-jet-input type="text" id="position_of_writer" class="block w-full mt-1" wire:model.defer="input.position_of_writer" />
          <x-jet-input-error for="position_of_writer" class="mt-2" />
        </div>




        <div class="form-input">
          <x-jet-label for="signature_of_writer" value="Writer Signature" />
          <div id="signaturePad"></div>
          &ensp;
          <x-jet-secondary-button id="clear" class="ml-2">Clear signature</x-jet-secondary-button>
          {{-- <x-jet-input type="text" id="signature64" class="block w-full mt-1" wire:model.defer="input.signature_of_writer" /> --}}
          {{-- <x-textarea id="signature64" name="signature_of_writer" class="block w-full mt-1 resize-y" wire:model="input.signature_of_writer" /> --}}
          <x-jet-input type="text" id="signature64" class="block w-full mt-1 hidden" wire:model.defer="input.signature_of_writer"/>

          {{-- <textarea id="signature64" name="signature_of_writer" style="display: none"></textarea> --}}

          <x-jet-input-error for="signature_of_writer" class="mt-2" />
        </div>

      </div>
    </x-slot>






    <x-slot name="footer">
      {{-- @if (auth()->user()->getPermissionNames()->intersect(['memos.create', 'memos.update'])->count()) --}}

      @if (auth()->user()->getPermissionNames()->intersect(['memos.create'])->count())
      {{-- @if (auth()->user()->hasPermissionTo('memos.create')) --}}
      {{-- <form action="javascript:void(0)">
        @csrf --}}
        {{-- <x-jet-button type="button">test create</x-jet-button> --}}
        <x-jet-button type="button" onclick="submit_button();">{{ isset($memoId) ? 'Update' : 'Register' }}</x-jet-button>
        {{-- <x-jet-button type="submit">{{ isset($memoId) ? 'Update' : 'Register' }}</x-jet-button> --}}
        {{-- </form> --}}
        @elseif (auth()->user()->getPermissionNames()->intersect(['memos.update'])->count())

        {{-- <x-jet-button type="button">test update</x-jet-button> --}}

        @endif





        <x-jet-secondary-button type="button" class="ml-2" wire:click="$set('showModal', false)">
          @if (auth()->user()->getPermissionNames()->intersect(['memos.create', 'memos.update'])->count())
          Cancel
          @else
          Close
          @endif
        </x-jet-secondary-button>

      </x-slot>

    </x-form-modal>
  </div>








  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  {{-- <link type="text/css" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/south-street/jquery-ui.css" rel="stylesheet"> --}}
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script type="text/javascript" src="http://keith-wood.name/js/jquery.signature.js"></script>
  <link rel="stylesheet" type="text/css" href="http://keith-wood.name/css/jquery.signature.css">







  <script type="text/javascript">


    var signaturePad = $('#signaturePad').signature({syncField: '#signature64', syncFormat: 'PNG'});

    // console.log($('#signature64').val());
    $('#clear').click(function(e) {
      e.preventDefault();
      signaturePad.signature('clear');
      $("#signature64").val('');
    });



    function submit_button(){

      var val = $('#update_data').val();
      var url_update = '/updategetmsg';

      // alert(val);

      if(val !== null){

        url_update = '/updategetmsg';



      }
      else{

        url_update = '/getmsg';

      }


      console.log($('#update_data').val());
      alert(url_update);

      $.ajax({
        type:'POST',
        url: url_update,
        data:{
          "_token": "{{ csrf_token() }}",
          id:$("#update_data").val(),
          signature64:$("#signature64").val(),
          memo_date:$("#memo_date").val(),

          recipient:$("#recipient").val(),
          recipient_company:$("#recipient_company").val(),
          recipient_address:$("#recipient_address").val(),
          subject:$("#subject").val(),
          content:$("#content").val(),
          name_of_writer:$("#name_of_writer").val(),
          position_of_writer:$("#position_of_writer").val(),
          // signature_of_writer:$("#signature_of_writer").val()

        },
        success:function(data) {

          console.log(data.message);
          alert(data.message);

          signature64:$("#signature64").val('');
          memo_date:$("#memo_date").val('');

          recipient:$("#recipient").val('');
          recipient_company:$("#recipient_company").val('');
          recipient_address:$("#recipient_address").val('');
          subject:$("#subject").val('');
          content:$("#content").val('');
          name_of_writer:$("#name_of_writer").val('')
          position_of_writer:$("#position_of_writer").val('');




        }
      });




    }
  </script>



  {{-- <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
  <script>
    document.addEventListener('alpine:init', ()  => {
      Alpine.data('signaturePad', () => ({
        signaturePadInstance: null,
        init(){
          this.signaturePadInstance = new signaturePad(this.$refs.signature_canvas);
        }
      }))
    })
  </script> --}}
