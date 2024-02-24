<?php

namespace App\Controllers;

use function App\Helpers\sendAbsenceNotifications;

class EmailController extends BaseController
{
    public function index(): void
    {
        sendAbsenceNotifications();
    }
}