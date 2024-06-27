<div>

    @include('livewire.import.form')
    @include('livewire.import.detail')
    <div>
        <h1>Imports</h1>
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

        <button wire:click="openForm" class="btn float-end mb-3 btn-primary">+ Import</button>

        <table class="table table-bordered mt-5">
            <thead>
                <tr>
                    <th class="text-center">Time</th>
                    <th width="100px" class="text-center">Status</th>
                    <th width="100px" class="text-center">Total</th>
                    <th width="100px" class="text-center">Success</th>
                    <th width="100px" class="text-center">Failed</th>
                    <th width="100px" class="text-center">Time Elapsed</th>
                    <th width="300px" class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($imports as $val)
                    <tr>
                        <td>{{ date('y-m-d H:i:s', strtotime($val->created_at)) }}</td>
                        <td class="text-center">
                            @if ($val->status == 'Completed')
                                <button class="btn btn-success btn-sm">Completed</button>
                            @else
                                <button class="btn btn-secondary btn-sm">Pending</button>
                            @endif
                        </td>
                        <td>{{ $val->total_rows }}</td>
                        <td>{{ $val->success_rows }}</td>
                        <td>{{ $val->failed_rows }}</td>
                        <td>
                            {{ gmdate("i \m\n s \s", $val->time_elapsed / 1000) }}
                        </td>
                        <td class="text-center">
                            <button class="btn btn-primary btn-sm"
                                wire:click="download(`{{ 'app/' . $val->link_to_failed_rows_file }}`)">
                                <i class="fa fa-download"></i>
                            </button>
                            <button wire:click="detail('{{ $val->id }}')"
                                class="btn btn-primary btn-sm">Detail</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $imports->links() }}
    </div>
</div>
