<?php

namespace App\Livewire;

use App\Models\Tag;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class TagManager extends Component {
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $name;
    public $tag_id;

    public function render()
    {
        return view(
            'livewire.tag.index',
            [
                'tags' => Tag::orderBy('name')
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
            'name' => ['required', Rule::unique('tags', 'name')]
        ]);

        Tag::updateOrCreate(['id' => $this->tag_id], [
            'name' => $this->name
        ]);
        session()->flash(
            'message',
            $this->tag_id ? 'Provinsi Updated Successfully.' : 'Provinsi Created Successfully.'
        );
        $this->closeForm();
        $this->name = null;
        $this->tag_id = null;
    }
    public function delete($id)
    {
        Tag::find($id)->delete();
        session()->flash('message', 'Provinsi Deleted Successfully.');
    }
    public function edit($id)
    {
        $provinsi = Tag::find($id);
        $this->tag_id = $id;
        $this->name = $provinsi->name;
        $this->openForm();
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
