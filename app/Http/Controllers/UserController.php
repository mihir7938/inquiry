<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\EmailService;
use App\Services\CityService;
use App\Services\BusinessService;
use App\Services\RequirementService;
use App\Services\StatusService;
use App\Services\AssignService;
use App\Services\UserService;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    private $emailService, $cityService, $businessService, $requirementService, $statusService, $assignService, $userService;

    public function __construct (
        EmailService $emailService,
        CityService $cityService,
        BusinessService $businessService,
        RequirementService $requirementService,
        StatusService $statusService,
        AssignService $assignService,
        UserService $userService
    )
    {
        $this->emailService = $emailService;
        $this->cityService = $cityService;
        $this->businessService = $businessService;
        $this->requirementService = $requirementService;
        $this->statusService = $statusService;
        $this->assignService = $assignService;
        $this->userService = $userService;
    }

    public function index(Request $request)
    {
    	$businesses = $this->businessService->getAllBusiness();
    	$requirements = $this->requirementService->getAllRequirements();
    	$statuses = $this->statusService->getAllStatus();
    	$users = $this->userService->getAllUsers();
        return view('users.index')->with('businesses', $businesses)->with('requirements', $requirements)->with('statuses', $statuses)->with('users', $users);
    }
}