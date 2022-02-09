<?php

namespace App\Http\Livewire\Memos;

use App\Actions\Memo\CreateMemo;
use App\Actions\Memo\UpdateMemo;
use App\Models\Memo;
use App\Traits\Validators\FocusError;
use Livewire\Component;



class Form extends Component
{
    use FocusError;

    public $memoId;

    public $content;

    public $input;

    public $memo_type;

    public $showModal = false;

    public $options = [
        'status' => [],
    ];

    protected $listeners = ['add', 'edit'];


    public function getTitleProperty()
    {
        if ($this->memoId) {
            return auth()->user()->hasPermissionTo('memos.update') ? 'Update Memo' : 'Memo Details';
        } else {
            return 'Register a Memo';
        }
    }


    public function getMemoProperty()
    {
        return Memo::findOrFail($this->memoId);
    }


    public function mount()
    {
        $this->resetInput();

        foreach ($this->options as $key => $option) {
            $this->options[$key] = collect(config('services.memo.' . $key))->map(function ($item) {
                return [
                    'value' => $item,
                    'label' => $item,
                ];
            })->all();
        }
    }


    public function render()
    {
        return view('livewire.memos.form');
    }

    public function resetInput()
    {
        $this->input = [
            'memo_date' => '',
        ];

        // $this->dispatchBrowserEvent('memo-lookup-value');

    }


    public function add()
    {
        abort_unless(auth()->user()->hasPermissionTo('memos.create'), 403);

        $this->memoId = null;

        $this->resetInput();

        $this->showModal = true;
    }




    public function edit($id)
    {
        abort_unless(auth()->user()->hasPermissionTo('memos.update'), 403);

        $this->memoId = $id;

        $this->content = $this->memo->content;

        $this->memo_type = $this->memo->memo_type;

        $this->input = collect($this->memo)->except(['id', 'created_at', 'updated_at'])->all();

        $this->showModal = true;
    }


    public function dehydrate()
    {
        $this->focusError();
    }



    public function submit()
    {
        $this->memoId ? $this->update(new UpdateMemo()) : $this->create(new CreateMemo());
    }




    public function create(CreateMemo $action)
    {
        abort_unless(auth()->user()->hasPermissionTo('memos.create'), 403);

        $action->create($this->input);

        $this->emitTo('memos.index', 'render');

        $this->showModal = false;

        $this->dispatchBrowserEvent('banner-message', [
            'style' => 'success',
            'message' => 'Memo has been registered.',
        ]);
    }


    public function update(UpdateMemo $action)
    {
        abort_unless(auth()->user()->hasPermissionTo('memos.update'), 403);

        $action->update($this->input, $this->memo);

        $this->emitTo('memos.index', 'render');

        $this->showModal = false;

        $this->dispatchBrowserEvent('banner-message', [
            'style' => 'success',
            'message' => 'Memo has been updated.',
        ]);
    }
}
