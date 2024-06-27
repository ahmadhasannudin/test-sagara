<?php

namespace App\Livewire;

use App\Jobs\ProcessImport;
use App\Models\Import;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Session;

class ImportManager extends Component {
    use WithPagination, WithFileUploads;

    protected $paginationTheme = 'bootstrap';
    public $file;
    public $detailImport = [];
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

        $import = Import::create([
            'status' => 'Pending',
            'total_rows' => 0,
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

    public function detail($id)
    {
        $this->detailImport = Import::find($id);
        $this->dispatch('openDetail');
    }

    public function download($file)
    {
        // if file not exist throw error
        if (!file_exists(storage_path($file))) {
            session()->flash('error', "File doesn't exist");
            $this->dispatch('closeDetail');
            return;
        }

        return response()->download(storage_path($file));

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
