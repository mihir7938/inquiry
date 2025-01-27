<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\EmailService;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    private $emailService;

    public function __construct (
        EmailService $emailService
    )
    {
        $this->emailService = $emailService;
    }

    public function index(Request $request)
    {
        return view('index');
    }
}
