<div class="modal fade" id="modalKabupaten" tabindex="-1" role="dialog" wire:ignore.self>
    <div class="modal-dialog">
        <div class="modal-content">
            <form wire:submit.prevent="store">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $kabupaten_id ? 'Edit' : 'Tambah' }} Kabupaten</h5>
                    <button type="button" class="btn-close" wire:click="closModal()"></button>
                </div>
                <div class="modal-body">
                    <div class="mt-2">
                        Nama Kabupaten
                        <select wire:model="provinsi_id" class="form-select">
                            @if (!empty($provinsi_id) && !empty($provinsi_nama))
                                <option value="{{ $provinsi_id }}" selected>{{ $provinsi_nama }}</option>
                            @else
                                <option value="">Semua Provinsi</option>
                            @endif
                            @foreach ($provinsi as $prov)
                                <option value="{{ $prov->id }}">{{ $prov->nama }}</option>
                            @endforeach
                        </select>
                        @error('provinsi_id')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mt-2">
                        Nama Kabupaten
                        <input type="text" class="form-control" placeholder="Nama Provinsi" wire:model="nama">
                        @error('name')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mt-2">
                        Populasi
                        <input type="number" class="form-control" placeholder="Nama Provinsi" wire:model="populasi">
                        @error('populasi')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">{{ $kabupaten_id ? 'Update' : 'Save' }}</button>
                    <button type="button" wire:click="closeModal()" class="btn btn-secondary">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    window.addEventListener('closeModal', event => {
        $('#modalKabupaten').modal('hide')
    });

    window.addEventListener('openModal', event => {
        $('#modalKabupaten').modal('show')
    });
</script>
