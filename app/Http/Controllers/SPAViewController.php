<?php

namespace App\Http\Controllers;


class SPAViewController
{
    /**
     * Single page application catch-all route.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        return view('home', [
            'scriptVariables' => [
                'permissions' => request()->user()->permissions->pluck('slug'),
                'user_id' => request()->user()->id,
            ],
        ]);
    }
}