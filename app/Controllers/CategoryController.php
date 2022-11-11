<?php

namespace App\Controllers;

use CodeIgniter\HTTP\IncomingRequest;
use function App\Helpers\protectRoute;

class CategoryController extends BaseController
{
    public function index()
    {
        helper('auth');
        protectRoute();







    }

    public function store(IncomingRequest $request){

    }


}