<?php

namespace App\Controllers;

use App\Models\AuthException;
use function App\Helpers\handleAuthException;
use function App\Helpers\user;

class IndexController extends BaseController
{
    public function index()
    {
        helper('auth');

        try {
            $user = user();


            return $this->render('IndexView');
        } catch (AuthException $e) {
            return handleAuthException($e);
        }
    }
}
