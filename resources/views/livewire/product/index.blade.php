<div>

    @include('livewire.product.form')
    <div>
        <h1>Product</h1>
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
        @if (session()->has('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="row">
            <div class="col-6">
                <form class="form-inline my-2 my-lg-0" wire:submit.prevent="updateSearchTerm">
                    <div class="row">
                        <div class="col-4">
                            <input class="form-control mr-sm-2" type="search" placeholder="Search Name"
                                aria-label="Search" onchange="@this.set('searchName',$(this).val())">
                        </div>
                        <div class="col-4" wire:ignore>
                            <select class="form-control" id="searchTags" multiple="multiple"
                                onchange="@this.set('searchTags',$(this).select2('val'))">
                            </select>
                        </div>
                        <div class="col-4">
                            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-6">
                <button wire:click="openForm" class="btn float-end mb-3 btn-primary">+ Product</button>
            </div>
        </div>
        <table class="table table-bordered mt-5">
            <thead>
                <tr>
                    <th class="text-center">Name</th>
                    <th width="150px" class="text-center">Quantity</th>
                    <th width="150px" class="text-center">Purchase</th>
                    <th width="150px" class="text-center">Sell</th>
                    <th class="text-center">Tags</th>
                    <th width="200px" class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $p)
                    <tr>
                        <td>{{ $p->name }}</td>
                        <td class="text-end">{{ $p->quantity }}</td>
                        <td class="text-end">{{ number_format($p->purchasing_price, 0, ',') }}</td>
                        <td class="text-end">{{ number_format($p->selling_price, 0, ',') }}</td>
                        <td class="text-start">{{ $p->readableTags() }}</td>
                        <td class="text-center">
                            <button wire:click="edit(`{{ $p->id }}`)" class="btn btn-primary">Edit</button>
                            <button wire:click="delete(`{{ $p->id }}`)" class="btn btn-danger">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $products->links() }}
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#searchTags').select2({
            placeholder: '- Select Tags -',
            width: '100%',
            ajax: get_select2_ajax_options("{{ route('select-tag') }}")
        });
    });
</script>
