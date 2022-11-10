<?php

namespace App\Controllers;

use CodeIgniter\HTTP\IncomingRequest;
use function App\Helpers\getAllRoles;
use function App\Helpers\protectRoute;

class CredentialController extends BaseController
{

    public function index()
    {
        helper('auth');


        return $this->render('credentials/CredentialsView');

    }

    public function create()
    {


        return $this->render('credentials/CreateCredentialsView', ['roles' => getAllRoles()]);
    }

    public function store()
    {
        $request = $this->request;




        echo "<pre>";
        print_r($body);
        echo "</pre>";

    }


}