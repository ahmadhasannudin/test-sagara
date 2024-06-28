<div>

    @include('livewire.service.form')
    <div>
        <h1>Service</h1>
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
                <form class="form-inline my-2 my-lg-0">
                    <div class="row">
                        <div class="col-4">
                            <input class="form-control mr-sm-2" type="search" placeholder="Search Name"
                                aria-label="Search">
                        </div>
                        <div class="col-4">
                            <input class="form-control mr-sm-2" type="search" placeholder="Search Tag"
                                aria-label="Search">
                        </div>
                        <div class="col-4">
                            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-6">
                <button wire:click="openForm" class="btn float-end mb-3 btn-primary">+ Service</button>
            </div>
        </div>
        <table class="table table-bordered mt-5">
            <thead>
                <tr>
                    <th class="text-center">Name</th>
                    <th width="200px" class="text-center">Base</th>
                    <th width="200px" class="text-center">Selling</th>
                    <th class="text-center">Tags</th>
                    <th width="200px" class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($services as $p)
                    <tr>
                        <td>{{ $p->name }}</td>
                        <td class="text-end">{{ number_format($p->base_price, 0, ',') }}</td>
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
        {{ $services->links() }}
    </div>
</div>
