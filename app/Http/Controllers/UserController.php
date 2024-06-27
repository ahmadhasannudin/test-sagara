<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepositRequest;
use App\Http\Requests\OrderListRequest;
use App\Http\Requests\WithdrawRequest;
use App\Jobs\OrderProcess;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller {
    public function index(): Response
    {
        return response()->json([
            'message' => 'Success!',
            'data' => Auth::user()->makeHidden(['id'])
        ]);
    }
    public function deposit(DepositRequest $req): Response
    {
        OrderProcess::dispatch(
            Auth::user(),
            $req->only('amount', 'timestamp')
        );
        return response()->json([
            'message' => 'Success, your request has been processed!',
        ]);
    }
    public function withdraw(WithdrawRequest $req): Response
    {
        $user = Auth::user();
        if ($req->validated('amount') > $user->balance)
            return response()->json(['message' => 'balance insufficient'], 400);
        $user->balance -= $req->validated('amount');
        $user->save();
        return response()->json([
            'message' => 'Success, your request has been processed!',
            'data' => $user->makeHidden(['id'])
        ]);
    }
    public function order(OrderListRequest $req)
    {
        $order = Auth::user()
            ->orders()
            ->paginate($req->validated('show'), ['*'], 'page', $req->validated('page'));
        return response()->json(['message' => 'Success', 'data' => $order]);
    }
}
