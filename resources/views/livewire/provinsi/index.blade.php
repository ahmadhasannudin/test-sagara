<div>

    @include('livewire.provinsi.create')
    <div>
        <h1>Provinsi</h1>
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif

        <button wire:click="openModal()" class="btn float-end mb-3 btn-primary">+ Provinsi</button>

        <table class="table table-bordered mt-5">
            <thead>
                <tr>
                    <th class="text-center">Nama Provinsi</th>
                    <th width="200px" class="text-center">Kabupaten</th>
                    <th width="200px" class="text-center">Penduduk</th>
                    <th width="200px" class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($provinsi as $p)
                    <tr>
                        <td>{{ $p->nama }}</td>
                        <td class="text-end">{{ $p->kabupaten_count }}</td>
                        <td class="text-end">{{ number_format($p->kabupaten_sum_populasi, 0, ',') }}</td>
                        <td class="text-center">
                            <button wire:click="edit({{ $p->id }})" class="btn btn-primary">Edit</button>
                            <button wire:click="delete({{ $p->id }})" class="btn btn-danger">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $provinsi->links() }}
    </div>
</div>
