<div class="d-flex justify-content-center" wire:ignore.self>
    <div class="card p-5" style="width: 500px">
        @if (session()->has('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <form wire:submit.prevent="register">
            <div class="form-group mb-3">
                <label>Name</label>
                <input type="text" wire:model="name" class="form-control" placeholder="Enter Name">
                @error('name')
                    <small class="form-text text-muted">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label>Email address</label>
                <input type="email" wire:model="email" class="form-control" placeholder="Enter email">
                @error('email')
                    <small class="form-text text-muted">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label>Password</label>
                <input type="password" wire:model="password" class="form-control" placeholder="Password">
                @error('password')
                    <small class="form-text text-muted">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label>Confirm Password</label>
                <input type="password" wire:model="confirm_password" class="form-control"
                    placeholder="Confirm Password">
                @error('confirm_password')
                    <small class="form-text text-muted">{{ $message }}</small>
                @enderror
            </div>
            <button type="submit" class="float-end btn btn-primary">Submit</button>
        </form>
    </div>
</div>
