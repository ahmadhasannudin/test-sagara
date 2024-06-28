<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller {
    public function select(Request $req)
    {
        $query = Tag::select('id', 'name as text')
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
