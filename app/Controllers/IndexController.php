<?php

namespace App\Controllers;

class IndexController extends BaseController
{
    public function index(): string
    {
        $entries = json_decode(file_get_contents(ROOTPATH . 'entries.json'));
        return view('IndexView', ['entries' => $entries]);
    }
}
