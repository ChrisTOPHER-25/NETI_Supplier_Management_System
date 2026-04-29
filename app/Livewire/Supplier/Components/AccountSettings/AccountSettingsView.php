<?php

namespace App\Livewire\Supplier\Components\AccountSettings;

use Livewire\Component;

class AccountSettingsView extends Component
{
    protected $listeners = ["showForm"];
    public $selectedForm, $test;


    public function render()
    {
        return view('livewire.supplier.components.account-settings.account-settings-view');
    }

    public function mount() {
        $this->selectedForm = 'ProfileInfo';
    }

    public function showForm($name){
        $this->selectedForm = $name;
    }

}
