<?php

namespace App\Controllers;

use App\Models\OAuthException;
use CodeIgniter\HTTP\RedirectResponse;
use function App\Helpers\logout;
use function App\Helpers\user;

class CredentialsController extends BaseController
{
    public function index(): RedirectResponse|string
    {
        $user = user();
        $procuratId = $user->getProcuratId();
        if (!$procuratId) {
            return redirect('/')->with('error', lang('credentials.error.noProcuratId'));
        }

        $threemaCredentials = getThreemaCredentials($procuratId);
        return view('credentials/CredentialsView', ['user' => $user, 'threemaCredentials' => $threemaCredentials]);
    }
}
