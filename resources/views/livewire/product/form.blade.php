<div class="modal fade" id="form" tabindex="-1" role="dialog" wire:ignore.self>
    <div class="modal-dialog">
        <div class="modal-content">
            <form wire:submit.prevent="store">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $product_id ? 'Edit' : 'Tambah' }} Product</h5>
                    <button type="button" class="btn-close" wire:click="closeForm"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-2">
                        <label>Product Name</label>
                        <input type="text" class="form-control" wire:model="name">
                        @error('name')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <label>Quantity</label>
                        <input type="number" class="form-control" wire:model="quantity">
                        @error('quantity')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <label>Purchasing Price</label>
                        <input type="number" class="form-control" wire:model="purchasing_price">
                        @error('purchasing_price')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <label>Selling Price</label>
                        <input type="number" class="form-control" wire:model="selling_price">
                        @error('selling_price')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-2" wire:ignore>
                        <label>Tags</label>
                        <select name="tagInput[]" class="form-control" id="tagInput" multiple="multiple"
                            onchange="@this.set('tagInput',$(this).select2('val'))">
                        </select>
                        @error('tagInput')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">{{ $product_id ? 'Update' : 'Save' }}</button>
                    <button type="button" wire:click="closeForm" class="btn btn-secondary">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    window.addEventListener('closeForm', event => {
        $('#tagInput').empty();
        $('#form').modal('hide');
    });


    window.addEventListener('openForm', event => {
        $('#form').modal('show')
        $(document).ready(function() {
            $('#tagInput').select2({
                dropdownParent: $('#form'),
                placeholder: '- Select Tags -',
                width: '100%',
                ajax: get_select2_ajax_options("{{ route('select-tag') }}")
            });
        });
    });
    window.addEventListener('changeTag', event => {
        $('#tagInput').empty();
        setSelect2MultiDimensional('#tagInput',
            event.detail[0].map(item => item.id),
            event.detail[0].map(item => item.name)
        );
    })
</script>
