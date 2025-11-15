<?php

namespace App\Livewire\Supplier\Components\AccountSettings;

use Livewire\Component;

class AccountSettingsNav extends Component
{
    public $selectedForm = 'ProfileInfo';

    public function render()
    {
        return view('livewire.supplier.components.account-settings.account-settings-nav');
    }

    public function selectForm($name)
    {

        $this->selectedForm = $name;
        $this->dispatch('showForm', $name);
    }
}