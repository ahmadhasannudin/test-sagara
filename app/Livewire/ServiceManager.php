<?php

namespace App\Livewire;

use App\Models\Service;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\WithPagination;

class ServiceManager extends Component {
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $name, $base_price, $selling_price;
    public $tagInput;
    public $service_id;

    public function render()
    {
        return view(
            'livewire.service.index',
            [
                'services' => Service::orderBy('name')
                    ->with('tags')
                    ->paginate(10)
            ]
        );
    }
    public function create()
    {
        $this->name = '';
        $this->openForm();
    }
    public function store()
    {
        $this->validate([
            'name' => ['required'],
            'tagInput' => 'nullable|array',
            'base_price' => 'required|numeric',
            'selling_price' => 'required|numeric',
        ]);
        if (
            Service::where('name', $this->name)
                ->where('id', '!=', $this->service_id)->exists()
        ) {
            $error = ValidationException::withMessages([
                'name' => ['Name already exist'],
            ]);
            throw $error;
        }


        try {
            DB::beginTransaction();
            $service = Service::updateOrCreate(['id' => $this->service_id], [
                'name' => $this->name,
                'base_price' => $this->base_price,
                'selling_price' => $this->selling_price,
            ]);
            $service->tags()->sync($this->tagInput);
            DB::commit();
            session()->flash(
                'message',
                $this->service_id ? 'Service Updated Successfully.' : 'Service Created Successfully.'
            );
            $this->name = null;
            $this->service_id = null;
            $this->base_price = null;
            $this->selling_price = null;
            $this->tagInput = null;
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->closeForm();
            session()->flash(
                'error',
                $th->getMessage()
            );
        } finally {
            $this->closeForm();
        }
    }
    public function delete($id)
    {
        $service = Service::find($id);
        $service->delete();
        $service->tags()->detach();
        session()->flash('message', 'Service Deleted Successfully.');
    }
    public function edit($id)
    {
        $service = Service::find($id);
        $tags = $service->tags;
        $this->service_id = $id;
        $this->name = $service->name;
        $this->base_price = $service->base_price;
        $this->selling_price = $service->selling_price;
        $this->openForm();
        $this->dispatch('changeTag', $tags);
    }

    public function openForm()
    {
        $this->dispatch('openForm');
    }
    public function closeForm()
    {
        $this->dispatch('closeForm');
    }
}
