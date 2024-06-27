<?php

namespace App\Livewire;

use App\Models\Provinsi;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use App\Models\Kabupaten as Model;
use Livewire\WithPagination;

class Kabupaten extends Component {
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search_provinsi_id;
    public $provinsi_id;
    public $provinsi_nama;
    public $provinsi;
    public $kabupaten_id;
    public $nama;
    public $populasi;

    public function __construct()
    {
        $this->kabupaten = (object) [];
        $this->provinsi = Provinsi::orderBy('nama')->get();
    }
    public function updateProvinsiId()
    {
        $this->resetPage();
    }
    public function render()
    {
        $kabupaten = Model::where(function ($query) {
            if ($this->search_provinsi_id) {
                $query->where('provinsi_id', $this->search_provinsi_id);
            }
        })
            ->with('provinsi')
            ->orderBy('nama')
            ->paginate(10);
        return view('livewire.kabupaten.index', ['kabupaten' => $kabupaten]);
    }
    public function create()
    {
        $this->nama = '';
        $this->openModal();
    }
    public function store()
    {

        $this->validate([
            'nama' => ['required'],
            'provinsi_id' => ['required', Rule::exists('provinsi', 'id')],
            'populasi' => ['gt:0', 'numeric']
        ]);

        $existingKabupaten = Model::where('provinsi_id', $this->provinsi_id)
            ->where('nama', $this->nama)
            ->first();

        if (empty($this->kabupaten_id) && $existingKabupaten) {
            $error = ValidationException::withMessages([
                'name' => ['Name already exist'],
            ]);
            throw $error;
        }

        Model::updateOrCreate(['id' => $this->kabupaten_id], [
            'nama' => $this->nama,
            'provinsi_id' => $this->provinsi_id,
            'populasi' => $this->populasi
        ]);
        session()->flash(
            'message',
            $this->kabupaten_id ? 'Kabupaten Updated Successfully.' : 'Kabupaten Created Successfully.'
        );
        $this->closeModal();
    }
    public function delete($id)
    {
        Model::find($id)->delete();
        session()->flash('message', 'Provinsi Deleted Successfully.');
    }
    public function edit($id)
    {
        $kabupaten = Model::where('id', $id)->with('provinsi')->first();
        $this->kabupaten_id = $id;
        $this->provinsi_id = $kabupaten->provinsi->id;
        $this->provinsi_nama = $kabupaten->provinsi->nama;
        $this->nama = $kabupaten->nama;
        $this->populasi = $kabupaten->populasi;
        $this->openModal();
    }
    public function openModal()
    {
        $this->dispatch('openModal');
    }
    public function closeModal()
    {
        $this->nama = null;
        $this->kabupaten_id = null;
        $this->provinsi_id = null;
        $this->provinsi_nama = null;
        $this->populasi = null;
        $this->dispatch('closeModal');
    }
}
