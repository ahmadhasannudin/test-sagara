<div class="modal fade" id="form" tabindex="-1" role="dialog" wire:ignore.self>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $transaction_id ? 'Edit' : 'Tambah' }} Transaction</h5>
                <button type="button" class="btn-close" wire:click="closeForm"></button>
            </div>
            <div class="modal-body">
                <div class="mb-2 row">
                    <div class="col-4">
                        <label>Type</label>
                        <select class="form-control" id='type' onchange="changeType(this)">
                            <option value="">-- Select Type --</option>
                            <option value="product">Product</option>
                            <option value="service">Service</option>
                        </select>
                    </div>
                    <div class="col-4">
                        <label>item</label>
                        <select class="form-control" id="item"></select>
                    </div>
                    <div class="col-4">
                        <button type="button" id="addItemButton" class="mt-4 btn btn-sm btn-primary">
                            + Item
                        </button>
                    </div>
                </div>
                <div>
                    <table class="table table-borderd">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th></th>
                                <th></th>
                                <th width="50px"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!empty($transactionItem))
                                @foreach ($transactionItem as $item)
                                    <tr>
                                        <td>{{ $item['item_type'] }} - {{ $item['item_name'] }}</td>
                                        <td>
                                            @if ($item['item_type'] == 'product')
                                                <input style="width:100px" class="updateQuantity"
                                                    wire:change="updateQuantity('{{ $item['item_type'] . '-' . $item['item_id'] }}',$event.target.value)"
                                                    type="number" class="form-control" value="{{ $item['quantity'] }}">
                                                @error($item['item_type'] . '-' . $item['item_id'])
                                                    <span class="text-red-500">{{ $message }}</span>
                                                @enderror
                                            @endif
                                        </td>
                                        <td>{{ $item['price'] }}</td>
                                        <td>
                                            <button
                                                wire:click="removeItem('{{ $item['item_type'] }}-{{ $item['item_id'] }}')"
                                                class="btn btn-danger">-</button>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            <tr>
                                <td>
                                </td>
                                <td>
                                    Total
                                </td>
                                <td>
                                    {{ $this->calculateTotal() }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" wire:click="store"
                    class="btn btn-primary">{{ $transaction_id ? 'Update' : 'Save' }}</button>
                <button type="button" wire:click="closeForm" class="btn btn-secondary">Cancel</button>
            </div>
        </div>
    </div>
</div>

<script>
    window.addEventListener('closeForm', event => {
        $('#tagInput').empty();
        $('#form').modal('hide');
    });

    window.addEventListener('openForm', event => {
        $('.updateQuantity').trigger('change');
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

    $('#addItemButton').on('click', function() {
        var type = $('#type').val();
        var item = $('#item').val();
        if (!type || !item) {
            alert('Please select type and item');
            return;
        }
        $('#type').val('').trigger('change');
        $('#item').val('').trigger('change');
        @this.addItem(type, item, itemSelect2[type][item]);
    });
    // $('#business_partner').select2('data')[0]
    function changeType(ths) {
        if ($(ths).val() == 'product') {
            $('#item').select2({
                dropdownParent: $('#form'),
                placeholder: '- Select Product -',
                width: '100%',
                ajax: get_select2_ajax_options("{{ route('select-product') }}", 'product')
            });
        } else if ($(ths).val() == 'service') {
            $('#item').select2({
                dropdownParent: $('#form'),
                placeholder: '- Select Service -',
                width: '100%',
                ajax: get_select2_ajax_options("{{ route('select-service') }}", 'service')
            });
        }
    }
</script>
