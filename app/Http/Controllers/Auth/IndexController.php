<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class IndexController extends Controller
{
    public function __invoke(): View
    {
        Session::flash('info', 'You need to be logged in to view this page.');

        return view('auth.login');
    }
}
