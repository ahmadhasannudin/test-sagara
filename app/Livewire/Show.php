<?php

namespace App\Livewire;

use App\Models\Order;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

use Livewire\WithPagination;
use Mary\Traits\Toast;


class Show extends Component {
    use WithPagination, Toast;

    private $token = '';
    public $user = null;
    public $modelDeposit = false;
    public $modelWithdraw = false;
    public $timestamp = '';
    public $amount = 0;

    public function mount()
    {
        $this->timestamp = now()->format('Y-m-d H:i:s.v');
        $this->amount = 0;
        $this->getUser();
    }
    public function getUser()
    {
        $response = Http::withHeaders(['Authorization' => 'Bearer QWhtYWQgSGFzYW51ZGlu'])
            ->get(
                'host.docker.internal:8000/api/v1/user',
                []
            );
        if ($response->ok()) {
            $this->user = (object) $response->json('data');
        }
    }
    public function deposit()
    {
        $response = Http::withHeaders(['Authorization' => 'Bearer QWhtYWQgSGFzYW51ZGlu'])
            ->post(
                'host.docker.internal:8000/api/v1/user/deposit',
                ['amount' => $this->amount, 'timestamp' => $this->timestamp]
            );

        $toast = 'success';
        if (!$response->ok()) {
            $toast = 'error';
        }
        $this->modelDeposit = false;
        $this->timestamp = now()->format('Y-m-d H:i:s.v');
        $this->amount = 0;
        $this->toast($toast, $response->json('message'));
    }
    public function withdraw()
    {
        $response = Http::withHeaders(['Authorization' => 'Bearer QWhtYWQgSGFzYW51ZGlu'])
            ->post(
                'host.docker.internal:8000/api/v1/user/withdraw',
                ['amount' => $this->amount]
            );

        $toast = 'success';
        if (!$response->ok()) {
            $toast = 'error';
        }
        $this->modelWithdraw = false;
        $this->user = (object) $response->json('data');
        $this->timestamp = now()->format('Y-m-d H:i:s.v');
        $this->amount = 0;
        $this->toast($toast, $response->json('message'));
    }
    public function render()
    {
        $order = Order::orderBy('timestamp', 'desc')->paginate(5);
        return view('livewire.show', ['order' => $order]);
    }
}
