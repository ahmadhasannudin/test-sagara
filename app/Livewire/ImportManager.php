<?php

namespace App\Livewire;

use App\Jobs\ProcessImport;
use App\Models\Import;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Session;
use SplFileObject;

class ImportManager extends Component {
    use WithPagination, WithFileUploads;

    protected $paginationTheme = 'bootstrap';
    public $file;
    public function render()
    {
        Session::put('menu_active', 'import');
        return view('livewire.import.index', [
            'imports' => Import::orderBy('created_at', 'desc')->paginate(10)
        ]);
    }
    public function import()
    {
        $this->validate([
            'file' => 'required|mimes:csv,txt'
        ]);
        $file = $this->file;
        $filePath = $file->store('imports');
        // $storedFile = new SplFileObject(storage_path('app/' . $filePath), 'r');
        // dd(count(file(storage_path('app/' . $filePath))) - 1);

        $import = Import::create([
            'status' => 'Pending',
            'success_rows' => 0,
            'failed_rows' => 0,
            'time_elapsed' => 0,
            'link_to_failed_rows_file' => '',
            'file' => $filePath
        ]);
        ProcessImport::dispatch($filePath, $import->id);
        session()->flash('message', 'Import data has been submitted successfully.');
        $this->file = null;
        $this->closeForm();
    }
    public function closeForm()
    {
        $this->dispatch('closeForm');
    }
    public function openForm()
    {
        $this->dispatch('openForm');
    }
}
