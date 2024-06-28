<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Service;
use Illuminate\Http\Request;

class TransactionController extends Controller {
    public function selectProduct(Request $req)
    {
        $query = Product::select('id', 'selling_price', 'quantity', 'name as text')
            ->where(function ($q) use ($req) {
                if (!empty($req->q))
                    $q->whereRaw('LOWER(name) like ' . "'%" . strtolower($req->q) . "%'");
            })
            ->orderBy('name');

        $data['total_record'] = count($query->get());

        $start = ($req->input('page') - 1) * $req->input('page_limit');
        $length = $req->input('page_limit');

        $query->offset($start)
            ->limit($length);

        $data['more'] = $data['total_record'] > $req->input('page') * $req->input('page_limit');

        $data['items'] = $query->get()->toArray();

        return $data;
    }
    public function selectService(Request $req)
    {
        $query = Service::select('id', 'selling_price', 'name as text')
            ->where(function ($q) use ($req) {
                if (!empty($req->q))
                    $q->whereRaw('LOWER(name) like ' . "'%" . strtolower($req->q) . "%'");
            })
            ->orderBy('name');

        $data['total_record'] = count($query->get());

        $start = ($req->input('page') - 1) * $req->input('page_limit');
        $length = $req->input('page_limit');

        $query->offset($start)
            ->limit($length);

        $data['more'] = $data['total_record'] > $req->input('page') * $req->input('page_limit');

        $data['items'] = $query->get()->toArray();

        return $data;
    }
}
