<div>

    @include('livewire.transaction.form')
    <div>
        <h1>Transaction</h1>
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

        <button wire:click="openForm" class="btn float-end mb-3 btn-primary">+ Transaction</button>
        <table class="table table-bordered mt-5">
            <thead>
                <tr>
                    <th class="text-center">ID</th>
                    <th width="150px" class="text-center">Date</th>
                    <th width="150px" class="text-center">Amount</th>
                    <th width="200px" class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transactions as $p)
                    <tr>
                        <td>{{ $p->id }}</td>
                        <td class="text-end">{{ number_format($p->amount, 0, ',') }}</td>
                        <td class="text-end">{{ date('d-m-Y H:i:s', strtotime($p->created_at)) }}</td>
                        <td class="text-center">
                            <button wire:click="edit(`{{ $p->id }}`)" class="btn btn-primary">Edit</button>
                            <button wire:click="delete(`{{ $p->id }}`)" class="btn btn-danger">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $transactions->links() }}
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
