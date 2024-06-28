<div class="modal fade" id="form" tabindex="-1" role="dialog" wire:ignore.self>
    <div class="modal-dialog">
        <div class="modal-content">
            <form wire:submit.prevent="store">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $tag_id ? 'Edit' : 'Tambah' }} Tag</h5>
                    <button type="button" class="btn-close" wire:click="closeForm"></button>
                </div>
                <div class="modal-body">
                    <div class="mt-2">
                        <input type="text" class="form-control" placeholder="Nama Tag" wire:model="name">
                        @error('name')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">{{ $tag_id ? 'Update' : 'Save' }}</button>
                    <button wire:click="closeModal()" class="btn btn-secondary">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    window.addEventListener('closeForm', event => {
        $('#form').modal('hide')
    });

    window.addEventListener('openForm', event => {
        $('#form').modal('show')
    });
</script>
