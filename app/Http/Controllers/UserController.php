<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UploadImageService;
use App\Services\EmailService;
use App\Services\CityService;
use App\Services\BusinessService;
use App\Services\RequirementService;
use App\Services\StatusService;
use App\Services\AssignService;
use App\Services\UserService;
use App\Services\InquiryService;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    private $imageService, $emailService, $cityService, $businessService, $requirementService, $statusService, $assignService, $userService, $inquiryService;

    public function __construct (
        UploadImageService $imageService,
        EmailService $emailService,
        CityService $cityService,
        BusinessService $businessService,
        RequirementService $requirementService,
        StatusService $statusService,
        AssignService $assignService,
        UserService $userService,
        InquiryService $inquiryService
    )
    {
        $this->imageService = $imageService;
        $this->emailService = $emailService;
        $this->cityService = $cityService;
        $this->businessService = $businessService;
        $this->requirementService = $requirementService;
        $this->statusService = $statusService;
        $this->assignService = $assignService;
        $this->userService = $userService;
        $this->inquiryService = $inquiryService;
    }

    public function index(Request $request)
    {
    	$businesses = $this->businessService->getAllBusiness();
    	$requirements = $this->requirementService->getAllRequirements();
    	$statuses = $this->statusService->getAllStatus();
    	$users = $this->userService->getAllUsers();
        return view('users.index')->with('businesses', $businesses)->with('requirements', $requirements)->with('statuses', $statuses)->with('users', $users);
    }
    public function saveInquiry(Request $request)
    {
        $data['user_id'] = Auth::user()->id;
        $data['assign_id'] = $request->assign;
        $data['company_name'] = $request->company_name;
        $data['contact_person'] = $request->contact_person;
        $data['phone'] = $request->phone;
        $data['city'] = $request->city;
        $data['business_id'] = $request->business;
        $data['requirement_id'] = $request->requirement;
        $data['status_id'] = $request->status;
        $data['reff'] = $request->reff;
        $data['remarks'] = $request->remarks;
        if($request->has('image')){
            $filename = $this->imageService->uploadFile($request->image, "assets/inquiry");
            $data['image'] = '/inquiry/'.$filename;
        }
        $data['inquiry_date'] = date('Y-m-d');
        $this->inquiryService->create($data);
        $request->session()->put('message', 'inquiry has been generated successfully.');
        $request->session()->put('alert-type', 'alert-success');
        return redirect()->route('users.index');
    }
    public function getInquiries(Request $request)
    {
        $inquiries = $this->inquiryService->getInquiriesByUser(Auth::user()->id);
        return view('users.inquiries')->with('inquiries', $inquiries);
    }
}