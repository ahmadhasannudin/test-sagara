<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\WithPagination;

class TransactionManager extends Component {
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $transaction_id, $transactionItem = [];

    public function render()
    {
        return view(
            'livewire.transaction.index',
            [
                'transactions' => Transaction::orderBy('created_at', 'desc')
                    ->paginate(10)
            ]
        );
    }
    public function addItem($type, $item, $data)
    {
        $this->transactionItem[$type . '-' . $item] = [
            'item_type' => $type,
            'item_id' => $item,
            'item_name' => $data['text'],
            'quantity' => 1,
            'available_quantity' => $type == 'product' ? $data['quantity'] : -1,
            'price' => $data['selling_price'],
        ];
    }
    public function updateQuantity($key, $quantity)
    {
        if ($this->transactionItem[$key]['available_quantity'] < $quantity || $quantity <= 0) {
            $error = ValidationException::withMessages([
                $key => ['Quantity Insufficient'],
            ]);
            throw $error;
        }
        $this->transactionItem[$key]['quantity'] = $quantity;
    }
    public function removeItem($key)
    {
        unset($this->transactionItem[$key]);
    }
    public function create()
    {
        $this->name = '';
        $this->openForm();
    }
    public function store()
    {
        try {
            DB::beginTransaction();
            $transaction = Transaction::updateOrCreate(['id' => $this->transaction_id], [
                'amount' => $this->calculateTotal(),
            ]);
            $updatedProduct = [];
            foreach ($this->transactionItem as $item) {
                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'item_id' => $item['item_id'],
                    'item_type' => $item['item_type'] == 'product' ? 'App\Models\Product' : 'App\Models\Service',
                    'item_name' => $item['item_name'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
                if ($item['item_type'] == 'product') {
                    if (!isset($updatedProduct[$item['item_id']]))
                        $updatedProduct[$item['item_id']] = 0;
                    $updatedProduct[$item['item_id']] += $item['quantity'];
                }
            }
            foreach ($updatedProduct as $id => $quantity) {
                Product::find($id)->decrement('quantity', empty($this->transaction_id) ? $quantity : $this->transactionItem['product-' . $id]['old_quantity'] - $quantity);
            }
            DB::commit();
            session()->flash(
                'message',
                $this->transaction_id ? 'Transaction Updated Successfully.' : 'Transaction Created Successfully.'
            );
            $this->transactionItem = [];
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->closeForm();
            session()->flash(
                'error',
                $th->getMessage()
            );
        } finally {
            $this->closeForm();
        }
    }
    public function delete($id)
    {
        try {
            DB::beginTransaction();
            $transaction = Transaction::find($id);
            $updatedProduct = [];
            $transactionItem = $transaction->items();
            foreach ($transactionItem->get() as $item) {
                if ($item->item_type == 'App\Models\Product') {
                    if (!isset($updatedProduct[$item->item_id]))
                        $updatedProduct[$item->item_id] = 0;
                    $updatedProduct[$item->item_id] += $item->quantity;
                }
            }
            foreach ($updatedProduct as $id => $quantity) {
                Product::find($id)->increment('quantity', $quantity);
            }
            $transactionItem->delete();
            $transaction->delete();
            DB::commit();
            session()->flash('message', 'Transaction Deleted Successfully.');
        } catch (\Throwable $th) {
            DB::rollBack();
            session()->flash(
                'error',
                $th->getMessage()
            );
        }
    }
    public function calculateTotal()
    {
        $total = 0;
        foreach ($this->transactionItem as $items) {
            $total += $items['quantity'] * $items['price'];
        }
        return $total;
    }
    public function edit($id)
    {
        $transaction = Transaction::find($id);
        $this->transaction_id = $transaction->id;
        $transactionItem = $transaction->items()->get();
        foreach ($transactionItem as $key => $value) {
            $this->transactionItem[('App\Models\Product' ? 'product' : 'service') . '-' . $value['item_id']] = [
                'item_type' => $value['item_type'] == 'App\Models\Product' ? 'product' : 'service',
                'item_id' => $value['item_id'],
                'item_name' => $value['item_name'],
                'quantity' => $value['quantity'],
                'old_quantity' => $value['quantity'],
                'available_quantity' => $value['item_type'] == 'App\Models\Product' ? $value['quantity'] + ($value['quantity_available'] ?? 0) : -1,
                'price' => $value['price'],
            ];
        }
        $this->openForm();
    }

    public function openForm()
    {
        $this->dispatch('openForm');
    }
    public function closeForm()
    {
        $this->dispatch('closeForm');
    }
    public function updateSearchTerm()
    {
        $this->resetPage();
    }
}
