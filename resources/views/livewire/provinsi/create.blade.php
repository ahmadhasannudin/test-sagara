<div class="modal fade" id="modalProvinsi" tabindex="-1" role="dialog" wire:ignore.self>
    <div class="modal-dialog">
        <div class="modal-content">
            <form wire:submit.prevent="store">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $provinsi_id ? 'Edit' : 'Tambah' }} Provinsi</h5>
                    <button type="button" class="btn-close" wire:click="$set('isModalOpen', false)"></button>
                </div>
                <div class="modal-body">
                    <div class="mt-2">
                        <input type="text" class="form-control" placeholder="Nama Provinsi" wire:model="name">
                        @error('name')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">{{ $provinsi_id ? 'Update' : 'Save' }}</button>
                    <button wire:click="closeModal()" class="btn btn-secondary">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    window.addEventListener('closeModal', event => {
        $('#modalProvinsi').modal('hide')
    });

    window.addEventListener('openModal', event => {
        $('#modalProvinsi').modal('show')
    });
</script>
