<?php

namespace App\Http\Livewire;

use App\Contact;
use Livewire\Component;
use Livewire\WithPagination;

class ContactIndex extends Component
{
    use WithPagination;

    public $statusUpdate = false;
    public $paginate = 5;
    public $search;

    protected $paginationTheme = 'bootstrap';

    protected $listeners = [
        'contactStored' => 'handleStored',
        'contactUpdated' => 'handleUpdated',
    ];

    public function render()
    {
        return view('livewire.contact-index', [
            'contacts' => $this->search === null ? Contact::latest()->paginate($this->paginate) : Contact::latest()->where('name', 'like', '%' . $this->search . '%')->paginate($this->paginate)
        ])->layout('layouts.template');
    }

    public function getContact($id)
    {
        $this->statusUpdate = true;
        $contact = Contact::find($id);
        $this->emit('getContact', $contact);
    }

    public function destroy($id)
    {
        if ($id) {
            $contact = Contact::find($id);
            $contact->delete();
            session()->flash('message', 'Contact was deleted');
        }
    }

    public function handleStored($contact)
    {
        // dd($contact);
        session()->flash('message', 'Contact ' . $contact['name'] . " was stored");
    }

    public function handleUpdated($contact)
    {
        // dd($contact);
        $this->statusUpdate = false;
        session()->flash('message', 'Contact ' . $contact['name'] . " was updated");
    }
}
