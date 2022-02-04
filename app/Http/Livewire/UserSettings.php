<?php

namespace App\Http\Livewire;

use App\Models\User;
use Hash;
use Livewire\Component;

class UserSettings extends Component
{

    public $username, $password;

    public function mount()
    {
        $this->username = \Auth::user()->username;
    }

    protected function rules()
    {
        return [
            'username' => 'required'
        ];
    }

    public function update()
    {
        $this->validate();
        $data = [];
        $data['username'] = $this->username;
        if(!empty($this->password)){
            $this->validate(['password' => 'min:6']);
            $data['password'] = \Hash::make($this->password);
        }
        \Auth::user()->update($data);
        toastr()->livewire()->addSuccess('User updated!');
    }

    public function render()
    {
        return view('livewire.user-settings');
    }
}
