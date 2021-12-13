<?php

namespace App\Http\Livewire\Complaints;

use App\Actions\Complaint\UpdateComplaintNote;
use App\Models\Complaint;
use Livewire\Component;

class UpdateNotes extends Component
{
    public $complaintId;

    public $noteId;

    public $showModal;

    public $input = [
        'created_at' => '',
    ];

    protected $listeners = ['show'];

    public function getComplaintProperty()
    {
        return Complaint::findOrFail($this->complaintId);
    }

    public function getNoteProperty()
    {
        return $this->complaint->notes()->findOrFail($this->noteId);
    }

    public function render()
    {
        return view('livewire.complaints.update-notes');
    }

    public function show($complaintId, $noteId)
    {
        abort_unless(auth()->user()->hasPermissionTo('complaint-notes.update'), 403);

        $this->complaintId = $complaintId;

        $this->noteId = $noteId;

        $this->input = $this->note->only(['created_at', 'notes']);
        $this->input['created_time'] = $this->note->created_at->format('H:i');

        $this->showModal = true;
    }

    public function submit(UpdateComplaintNote $action)
    {
        abort_unless(auth()->user()->hasPermissionTo('complaint-notes.update'), 403);

        abort_unless(auth()->user()->hasRole('admin'), 403);

        $action->update($this->input, $this->note);

        $this->showModal = false;

        $this->emitTo('complaints.notes', 'render');
    }
}
