<div>

    @include('livewire.tag.form')
    <div>
        <h1>Provinsi</h1>
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif

        <button wire:click="openForm" class="btn float-end mb-3 btn-primary">+ Tag</button>

        <table class="table table-bordered mt-5">
            <thead>
                <tr>
                    <th class="text-center">Name</th>
                    <th width="200px" class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tags as $p)
                    <tr>
                        <td>{{ $p->name }}</td>
                        <td class="text-center">
                            <button wire:click="edit(`{{ $p->id }}`)" class="btn btn-primary">Edit</button>
                            <button wire:click="delete(`{{ $p->id }}`)" class="btn btn-danger">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $tags->links() }}
    </div>
</div>
