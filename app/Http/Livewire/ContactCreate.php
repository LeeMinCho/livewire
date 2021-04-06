<?php

namespace App\Http\Livewire;

use App\Contact;
use Livewire\Component;

class ContactCreate extends Component
{
    /* public $contacts;

    public function mount($contacts)
    {
        dd($contacts);
        $this->contacts = $contacts;
    } */

    public $name;
    public $phone;

    public function render()
    {
        return view('livewire.contact-create');
    }

    public function store()
    {
        $this->validate([
            'name' => 'required',
            'phone' => 'required'
        ]);
        $contact = Contact::create([
            'name' => $this->name,
            'phone' => $this->phone,
        ]);
        $this->_resetInput();
        $this->emit('contactStored', $contact);
    }

    private function _resetInput()
    {
        $this->name = null;
        $this->phone = null;
    }
}
