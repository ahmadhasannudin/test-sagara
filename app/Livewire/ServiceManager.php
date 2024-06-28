<?php

namespace App\Livewire;

use App\Models\Service;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class ServiceManager extends Component {
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $name;
    public $provinsi_id;

    public function render()
    {
        return view(
            'livewire.service.index',
            [
                'services' => Service::orderBy('name')
                    ->paginate(10)
            ]
        );
    }
    public function create()
    {
        $this->name = '';
        $this->openModal();
    }
    public function store()
    {
        $this->validate([
            'name' => ['required', Rule::unique('provinsi', 'nama')]
        ]);

        Service::updateOrCreate(['id' => $this->provinsi_id], [
            'nama' => $this->name
        ]);
        session()->flash(
            'message',
            $this->provinsi_id ? 'Provinsi Updated Successfully.' : 'Provinsi Created Successfully.'
        );
        $this->closeModal();
        $this->name = null;
        $this->provinsi_id = null;
    }
    public function delete($id)
    {
        Service::find($id)->delete();
        session()->flash('message', 'Provinsi Deleted Successfully.');
    }
    public function edit($id)
    {
        $provinsi = Service::find($id);
        $this->provinsi_id = $id;
        $this->name = $provinsi->nama;
        $this->openModal();
    }

    public function openModal()
    {
        $this->dispatch('openModal');
    }
    public function closeModal()
    {
        $this->dispatch('closeModal');
    }
}
