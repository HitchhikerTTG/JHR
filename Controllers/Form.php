<?php

namespace App\Controllers;

use Config\Services;

class Form extends BaseController
{
    protected $helpers = ['form'];

    public function index()
    {
        if (strtolower($this->request->getMethod()) !== 'post') {
            return view('test_form', [
                'validation' => Services::validation(),
            ]);
        }
        $rules = [
            'email' => 'required|valid_email|nadawcaCheck[{okno}]',

        ];
        $errors = [
            'email'=>[
                'required'=>"dawaj email",
                'valid_email'=>'poprawny email dawaj',
                'nadawcaCheck'=>'Wedle mojej najlepszej wiedzy, dla tego okna ten email jest już wykorzystywany',

            ]
        ];

        if (! $this->validate($rules,$errors)) {
            return view('test_form', [
                'validation' => $this->validator,
            ]);
        }

        return view('success');
    }
}