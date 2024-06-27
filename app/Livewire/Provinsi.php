<?php

namespace App\Livewire;

use Illuminate\Validation\Rule;
use Livewire\Component;
use App\Models\Provinsi as Model;
use Livewire\WithPagination;

class Provinsi extends Component {
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $name;
    public $provinsi_id;

    public function render()
    {
        return view(
            'livewire.provinsi.index',
            [
                'provinsi' => Model::orderBy('nama')
                    ->withCount('kabupaten')
                    ->withSum('kabupaten', 'populasi')
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

        Model::updateOrCreate(['id' => $this->provinsi_id], [
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
        Model::find($id)->delete();
        session()->flash('message', 'Provinsi Deleted Successfully.');
    }
    public function edit($id)
    {
        $provinsi = Model::find($id);
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
