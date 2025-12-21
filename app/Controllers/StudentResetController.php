<?php

namespace App\Controllers;

use App\Models\OAuthException;
use CodeIgniter\HTTP\RedirectResponse;
use function App\Helpers\logout;
use function App\Helpers\user;

class StudentResetController extends BaseController
{
    public function index(): string
    {
        return view('studentReset/StudentResetView');
    }
}
