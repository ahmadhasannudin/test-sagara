<div>
    <div class="flex justify-center align-center">
        <div class="w-1/2">
            <x-card title="{{ $user->name }}" subtitle="{{ $user->email }}" separator progress-indicator="save2">
                <p>balance: $ {{ $user->balance }}</p>
                <div class="text-end mt-10">
                    <x-button label="refresh balance" wire:click="getUser" />
                    <x-button label="Withdraw" @click="$wire.modelWithdraw = true" />
                    <x-button label="Deposit" @click="$wire.modelDeposit = true" />
                </div>
            </x-card>
        </div>
        <x-modal wire:model="modelDeposit" class="backdrop-blur">
            <x-form wire:submit="deposit">
                <x-input label="timestamp" wire:model="timestamp" />
                <x-input label="Amount" wire:model="amount" prefix="USD" money />

                <x-slot:actions>
                    <x-button label="Cancel" @click="$wire.modelDeposit = false" />
                    <x-button label="Submit" class="btn-primary" type="submit" spinner="deposit" />
                </x-slot:actions>
            </x-form>
        </x-modal>
        <x-modal wire:model="modelWithdraw" class="backdrop-blur">
            <x-form wire:submit="withdraw">
                <x-input label="Amount" wire:model="amount" prefix="USD" money />

                <x-slot:actions>
                    <x-button label="Cancel" @click="$wire.modelWithdraw = false" />
                    <x-button label="Submit" class="btn-primary" type="submit" spinner="withdraw" />
                </x-slot:actions>
            </x-form>
        </x-modal>
    </div>
    <div class="pt-5 flex justify-center align-center">
        <div class="w-1/3">
            <div wire:livewire="api-data-table">

                @if ($order)
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">Amount</th>
                                <th scope="col" class="px-6 py-3">Time Stamp</th>
                                <th scope="col" class="px-6 py-3">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order as $item)
                                <tr>
                                    <th scope="col" class="px-6 py-3">{{ $item->amount }}</th>
                                    <th scope="col" class="px-6 py-3">{{ $item->timestamp }}</th>
                                    <th scope="col" class="px-6 py-3">{{ $item->status }}</th>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{ $order->links() }}
                @else
                    Loading data...
                @endif
            </div>
        </div>
    </div>
</div>
<script>
    window.addEventListener('show-toast', event => {
        const {
            message
        } = event.detail;
        toast().success(message).push();
    });
</script>
