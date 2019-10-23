<?php

namespace App\Http\Controllers;

use App\FineType;

class FineTypeController extends Controller
{
    public function __construct(FineType $fineType)
    {
        $this->fineType = $fineType;
    }

    public function indexApi()
    {
        return $this->fineType->orderBy('updated_at', 'desc')->get();
    }

    public function store(Request $request)
    {
        return $this->fineType->create($request->all());
    }
}
