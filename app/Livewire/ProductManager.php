<?php

namespace App\Livewire;

use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\WithPagination;

class ProductManager extends Component {
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $name, $quantity, $purchasing_price, $selling_price, $tagInput, $product_id,
    $searchTags, $searchName;


    public function render()
    {
        return view(
            'livewire.product.index',
            [
                'products' => Product::orderBy('name')
                    ->where(function ($query) {
                        if (!empty($this->searchName))
                            $query->whereRaw('LOWER(name) like ?', ['%' . strtolower($this->searchName) . '%']);
                    })
                    ->where(function ($query) {
                        if (!empty($this->searchTags)) {
                            $query->whereHas('tags', function ($q) {
                                $q->whereIn('tags.id', $this->searchTags);
                            });
                        }
                    })
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
            'quantity' => 'required|numeric|gt:0',
            'purchasing_price' => 'required|numeric|gt:0',
            'selling_price' => 'required|numeric|gt:0',
        ]);
        if (
            Product::where('name', $this->name)
                ->where('id', '!=', $this->product_id)->exists()
        ) {
            $error = ValidationException::withMessages([
                'name' => ['Name already exist'],
            ]);
            throw $error;
        }

        try {
            DB::beginTransaction();
            $product = Product::updateOrCreate(['id' => $this->product_id], [
                'name' => $this->name,
                'quantity' => $this->quantity,
                'purchasing_price' => $this->purchasing_price,
                'selling_price' => $this->selling_price,
            ]);
            $product->tags()->sync($this->tagInput);
            DB::commit();
            session()->flash(
                'message',
                $this->product_id ? 'Product Updated Successfully.' : 'Product Created Successfully.'
            );
            $this->name = null;
            $this->product_id = null;
            $this->purchasing_price = null;
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
        $product = Product::find($id);
        $product->delete();
        $product->tags()->detach();
        session()->flash('message', 'Product Deleted Successfully.');
    }
    public function edit($id)
    {
        $product = Product::find($id);
        $tags = $product->tags;
        $this->product_id = $id;
        $this->name = $product->name;
        $this->quantity = $product->quantity;
        $this->purchasing_price = $product->purchasing_price;
        $this->selling_price = $product->selling_price;
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
    public function updateSearchTerm()
    {
        $this->resetPage();
    }
}
