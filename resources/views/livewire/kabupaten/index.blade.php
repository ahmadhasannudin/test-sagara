<div>

    @include('livewire.kabupaten.create')
    <div>
        <h1>Kabupaten</h1>
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif

        <div class="row">
            <div class="col-6">
                <select wire:model="search_provinsi_id" class="form-select" wire:change="updateProvinsiId">
                    <option value="">Semua Provinsi</option>
                    @foreach ($provinsi as $prov)
                        <option value="{{ $prov->id }}">{{ $prov->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-6">
                <button wire:click="openModal()" class="btn float-end mb-3 btn-primary">+ Kabupaten</button>
            </div>
        </div>

        <table class="table table-bordered mt-5">
            <thead>
                <tr>
                    <th class="text-center">Kabupaten</th>
                    <th width="200px" class="text-center">Provinsi</th>
                    <th width="200px" class="text-center">Penduduk</th>
                    <th width="200px" class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($kabupaten as $k)
                    <tr>
                        <td>{{ $k->nama }}</td>
                        <td>{{ $k->provinsi->nama }}</td>
                        <td class="text-end">{{ number_format($k->populasi, 0, ',') }}</td>
                        <td class="text-center">
                            <button wire:click="edit({{ $k->id }})" class="btn btn-primary">Edit</button>
                            <button wire:click="delete({{ $k->id }})" class="btn btn-danger">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $kabupaten->links() }}
    </div>
</div>
