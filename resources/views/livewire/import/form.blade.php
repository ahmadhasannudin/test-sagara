<div class="modal fade" id="modal" tabindex="-1" role="dialog" wire:ignore.self>
    <div class="modal-dialog">
        <div class="modal-content">
            <form wire:submit.prevent="import">
                <div class="modal-header">
                    <h5 class="modal-title">Import</h5>
                    <button type="button" class="btn-close" wire:click="closeForm"></button>
                </div>
                <div class="modal-body">
                    <div class="mt-2">
                        <input type="file" class="form-control" placeholder="Select File" wire:model="file">
                        @error('file')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" wire:click="closeForm" class="btn btn-secondary">Cancel</button>
                    <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">Import</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    window.addEventListener('closeForm', event => {
        $('#modal').modal('hide')
    });

    window.addEventListener('openForm', event => {
        $('#modal').modal('show')
    });
</script>
