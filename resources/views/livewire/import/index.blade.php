<div>

    @include('livewire.import.form')
    <div>
        <h1>Imports</h1>
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif

        <button wire:click="openForm" class="btn float-end mb-3 btn-primary">+ Import</button>

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
                @foreach ($imports as $val)
                    <tr>
                        <td>1</td>
                        {{-- <td>{{ $val->nama }}</td>
                        <td class="text-end">{{ $val->kabupaten_count }}</td>
                        <td class="text-end">{{ number_format($val->kabupaten_sum_populasi, 0, ',') }}</td>
                        <td class="text-center">
                            <button wire:click="edit({{ $val->id }})" class="btn btn-primary">Edit</button>
                            <button wire:click="delete({{ $val->id }})" class="btn btn-danger">Delete</button>
                        </td> --}}
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $imports->links() }}
    </div>
</div>
