<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Register extends Component {
    public $name;
    public $email;
    public $password;
    public $confirm_password;

    protected $rules = [
        'name' => 'required|min:6',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:8',
        'confirm_password' => 'required|min:8|same:password'
    ];

    public function register()
    {
        $this->validate();

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        auth()->login($user);

        return redirect()->intended('import');
    }

    public function render()
    {
        return view('livewire.auth.register');
    }
}
