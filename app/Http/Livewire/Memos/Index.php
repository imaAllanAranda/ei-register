<?php

namespace App\Http\Livewire\Memos;

use App\Models\Memo;
use App\Traits\WithColumnSorter;
use Illuminate\Support\Str;
// use Exception;
use Illuminate\Support\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    use WithColumnSorter;

    public $memoId;

    public $search;

    public $showDelete = false;

    public $listeners = ['render'];

    public $showPdf = false;

    public function getMemoProperty()
    {
        return Memo::findOrFail($this->memoId);
    }

    public function getPdfUrlProperty()
    {
        if (!$this->memoId) {
            return '';
        }

        return route('reports.memos.pdf', ['memo' => $this->memoId, 'now' => time()]);
    }

    public function render()
    {

        $query = Memo::when($this->search, function ($query) {
            return $query->where(function ($query) {
                // $stringColumns = ['memo_num', 'recipient', 'recipient_company', 'recipient_address', 'subject', 'name_of_writer', 'position_of_writer'];
                $stringColumns = ['memo_num', 'subject', 'name_of_writer', 'recipient'];

                foreach ($stringColumns as $column) {
                    $query->orWhere($column, 'like', '%' . $this->search . '%');
                }
            });
        });
        $query = $this->sortQuery($query, 'memo_num', 'asc');

        $memos = $query->paginate();

        return view('livewire.memos.index', compact('memos'));
    }






    public function updatingSearch()
    {
        $this->resetPage();

        $this->resetSort();
    }


    public function confirmDelete($id)
    {
        abort_unless(auth()->user()->hasPermissionTo('memos.delete'), 403);
        $this->memoId = $id;
        $this->showDelete = true;
    }


    public function delete()
    {
        abort_unless(auth()->user()->hasPermissionTo('memos.delete'), 403);

        $this->memo->delete();

        $this->showDelete = false;

        $this->dispatchBrowserEvent('banner-message', [
            'style' => 'success',
            'message' => 'Memo has been deleted.',
        ]);
    }


    public function showPdf($id)
    {
        // abort_unless(auth()->user()->hasPermissionTo('memos.view-pdf'), 403);

        $this->memoId = $id;

        $this->showPdf = true;
    }
}
