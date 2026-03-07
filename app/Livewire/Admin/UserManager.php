<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Enums\UserRole;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Mary\Traits\Toast;
use Illuminate\Support\Facades\Gate;

#[Layout('layouts.admin')]
class UserManager extends Component
{
    use Toast;

    public bool $userModal = false;
    public bool $isEditing = false;
    public $userId;

    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $role = 'customer';

    public function mount()
    {
        if (Gate::denies('admin')) {
            abort(403);
        }
        // Default role for new users
        $this->role = UserRole::CUSTOMER->value;
    }

    public function save()
    {
        $rules = [
            'name' => 'required|min:3',
            'email' => ['required', 'email', Rule::unique('users')->ignore($this->userId)],
            'role' => ['required', Rule::enum(UserRole::class)],
        ];

        if (!$this->isEditing) {
            $rules['password'] = 'required|min:6';
        } else {
            $rules['password'] = 'nullable|min:6';
        }

        $this->validate($rules);

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
        ];

        if (!empty($this->password)) {
            $data['password'] = Hash::make($this->password);
        }

        if ($this->isEditing) {
            $user = User::findOrFail($this->userId);
            $user->update($data);
            $this->success('Usuario actualizado correctamente.');
        } else {
            User::create($data);
            $this->success('Usuario creado correctamente.');
        }

        $this->userModal = false;
        $this->resetForm();
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->userId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->role->value;
        $this->password = ''; // Clear password field for security
        
        $this->isEditing = true;
        $this->userModal = true;
    }

    public function create()
    {
        $this->resetForm();
        $this->isEditing = false;
        $this->userModal = true;
    }

    public function delete($id)
    {
        if ($id === auth()->id()) {
            $this->error('No puedes eliminarte a ti mismo.');
            return;
        }

        User::destroy($id);
        $this->success('Usuario eliminado.');
    }

    public function resetForm()
    {
        $this->reset(['userId', 'name', 'email', 'password', 'role']);
        $this->role = UserRole::CUSTOMER->value;
        $this->resetErrorBag();
    }

    public function render()
    {
        $users = User::orderBy('name')->get();
        $roles = collect(UserRole::cases())->map(fn($role) => [
            'id' => $role->value,
            'name' => $role->label()
        ]);

        return view('livewire.admin.user-manager', [
            'users' => $users,
            'roles' => $roles,
        ]);
    }
}
