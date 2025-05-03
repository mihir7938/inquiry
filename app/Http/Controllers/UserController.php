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
use App\Services\InquiryPhotosService;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    private $imageService, $emailService, $cityService, $businessService, $requirementService, $statusService, $assignService, $userService, $inquiryService, $inquiryPhotosService;

    public function __construct (
        UploadImageService $imageService,
        EmailService $emailService,
        CityService $cityService,
        BusinessService $businessService,
        RequirementService $requirementService,
        StatusService $statusService,
        AssignService $assignService,
        UserService $userService,
        InquiryService $inquiryService,
        InquiryPhotosService $inquiryPhotosService
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
        $this->inquiryPhotosService = $inquiryPhotosService;
    }

    public function index(Request $request)
    {
        $user_id = Auth::user()->id;
    	$total_inquiry = $this->inquiryService->getTotalInquiriesByUser($user_id);
        $total_pending_inquiry = $this->inquiryService->getTotalInquiriesByUserByStatus($user_id, 1);
        $total_demo = $this->inquiryService->getTotalInquiriesByUserByStatus($user_id, 2);
        $total_followup = $this->inquiryService->getTotalInquiriesByUserByStatus($user_id, 3);
        $total_confirmed = $this->inquiryService->getTotalInquiriesByUserByStatus($user_id, 4);
        $total_cancelled = $this->inquiryService->getTotalInquiriesByUserByStatus($user_id, 5);
        $total_future_list = $this->inquiryService->getTotalInquiriesByUserByStatus($user_id, 6);
        $total_assign_inquiry = $this->inquiryService->getTotalInquiriesByAssign($user_id, $user_id);
        return view('users.index')->with('total_inquiry', $total_inquiry)->with('total_pending_inquiry', $total_pending_inquiry)->with('total_demo', $total_demo)->with('total_followup', $total_followup)->with('total_confirmed', $total_confirmed)->with('total_cancelled', $total_cancelled)->with('total_future_list', $total_future_list)->with('total_assign_inquiry', $total_assign_inquiry);
    }
    public function addInquiry(Request $request)
    {
        $businesses = $this->businessService->getAllBusiness();
        $requirements = $this->requirementService->getAllRequirements();
        $statuses = $this->statusService->getAllStatus();
        $users = $this->userService->getAllUsers();
        return view('users.add')->with('businesses', $businesses)->with('requirements', $requirements)->with('statuses', $statuses)->with('users', $users);
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
        $data['inquiry_date'] = date('Y-m-d');
        $inquiry_data = $this->inquiryService->create($data);
        $inquiry_id = $inquiry_data->id;
        if($request->has('image')){
            $data['inquiry_id'] = $inquiry_id;
            foreach($request->image as $img) {
                $filename = $this->imageService->uploadFile($img, "assets/inquiry");
                $data['image'] = '/inquiry/'.$filename;
                $this->inquiryPhotosService->create($data);
            }
        }
        $request->session()->put('message', 'inquiry has been generated successfully.');
        $request->session()->put('alert-type', 'alert-success');
        return redirect()->route('users.inquiries');
    }
    public function getInquiries(Request $request)
    {
        $statuses = $this->statusService->getAllStatus();
        $user_id = Auth::user()->id;
        $status_id = "";
        $flag = 1;
        if( $request->has('status') ) {
            $status_id = $request->input('status');
            $inquiries = $this->inquiryService->getInquiriesByUserByStatus($user_id, $status_id);
        } else {
            $inquiries = $this->inquiryService->getInquiriesByUser($user_id);
        }
        return view('users.inquiries')->with('statuses', $statuses)->with('status_id', $status_id)->with('flag', $flag)->with('inquiries', $inquiries);
    }
    public function fetchInquiriesByStatus(Request $request)
    {
        $status_id = $request->status_id;
        $user_id = Auth::user()->id;
        $inquiries = $this->inquiryService->getInquiriesByUser($user_id);
        $flag = 1;
        if($status_id == 1) {
            $inquiries = $this->inquiryService->getInquiriesByUserByStatus($user_id, $status_id);
        } elseif($status_id == 2) {
            $inquiries = $this->inquiryService->getInquiriesByUserByStatus($user_id, $status_id);
        } elseif($status_id == 3) {
            $inquiries = $this->inquiryService->getInquiriesByUserByStatus($user_id, $status_id);
        } elseif($status_id == 4) {
            $inquiries = $this->inquiryService->getInquiriesByUserByStatus($user_id, $status_id);
        } elseif($status_id == 5) {
            $inquiries = $this->inquiryService->getInquiriesByUserByStatus($user_id, $status_id);
        } elseif($status_id == 6) {
            $inquiries = $this->inquiryService->getInquiriesByUserByStatus($user_id, $status_id);
        }
        return view('users.list')->with('inquiries', $inquiries)->with('flag', $flag)->render();
    }
    public function editInquiry(Request $request, $id)
    {
        try{
            $inquiry = $this->inquiryService->getInquiryById($id);
            if(!$inquiry){
                throw new BadRequestException('Invalid Request id');
            }
            $businesses = $this->businessService->getAllBusiness();
            $requirements = $this->requirementService->getAllRequirements();
            $statuses = $this->statusService->getAllStatus();
            $users = $this->userService->getAllUsers();
            return view('users.edit')->with('inquiry', $inquiry)->with('businesses', $businesses)->with('requirements', $requirements)->with('statuses', $statuses)->with('users', $users);
        }catch(\Exception $e){
            $request->session()->put('message', $e->getMessage());
            $request->session()->put('alert-type', 'alert-warning');
            return redirect()->route('users.inquiries');
        }
    }
    public function updateInquiry(Request $request)
    {
        try{
            $inquiry = $this->inquiryService->getInquiryById($request->id);
            if(!$inquiry){
                throw new BadRequestException('Invalid Request id');
            }
            $data['assign_id'] = $request->assign;
            $data['contact_person'] = $request->contact_person;
            $data['phone'] = $request->phone;
            $data['city'] = $request->city;
            $data['business_id'] = $request->business;
            $data['requirement_id'] = $request->requirement;
            $data['status_id'] = $request->status;
            $data['reff'] = $request->reff;
            $data['remarks'] = $request->remarks;
            $data['followup_remarks_1'] = $request->followup_remarks_1;
            $data['followup_date_1'] = NULL;
            if($request->followup_date_1) {
                $data['followup_date_1'] = date("Y-m-d", strtotime(str_replace('/', '-', $request->followup_date_1)));
            }
            $data['followup_remarks_2'] = $request->followup_remarks_2;
            $data['followup_date_2'] = NULL;
            if($request->followup_date_2) {
                $data['followup_date_2'] = date("Y-m-d", strtotime(str_replace('/', '-', $request->followup_date_2)));
            }
            $data['followup_remarks_3'] = $request->followup_remarks_3;
            $data['followup_date_3'] = NULL;
            if($request->followup_date_3) {
                $data['followup_date_3'] = date("Y-m-d", strtotime(str_replace('/', '-', $request->followup_date_3)));
            }
            $data['followup_remarks_4'] = $request->followup_remarks_4;
            $data['followup_date_4'] = NULL;
            if($request->followup_date_4) {
                $data['followup_date_4'] = date("Y-m-d", strtotime(str_replace('/', '-', $request->followup_date_4)));
            }
            $data['followup_remarks_5'] = $request->followup_remarks_5;
            $data['followup_date_5'] = NULL;
            if($request->followup_date_5) {
                $data['followup_date_5'] = date("Y-m-d", strtotime(str_replace('/', '-', $request->followup_date_5)));
            }
            $this->inquiryService->update($inquiry, $data);
            if($request->has('image')){
                $data['inquiry_id'] = $request->id;
                foreach($request->image as $img) {
                    $filename = $this->imageService->uploadFile($img, "assets/inquiry");
                    $data['image'] = '/inquiry/'.$filename;
                    $this->inquiryPhotosService->create($data);
                }
            }
            $request->session()->put('message', 'inquiry has been updated successfully.');
            $request->session()->put('alert-type', 'alert-success');
            return redirect()->route('users.inquiries');
        }catch(\Exception $e){
            $request->session()->put('message', $e->getMessage());
            $request->session()->put('alert-type', 'alert-warning');
            return redirect()->route('users.inquiries');
        }
    }
    public function getAssignInquiries(Request $request)
    {
        $statuses = $this->statusService->getAllStatus();
        $assign_id = Auth::user()->id;
        $user_id = Auth::user()->id;
        $flag = 0;
        $inquiries = $this->inquiryService->getInquiriesByAssign($assign_id, $user_id);
        return view('users.assign')->with('statuses', $statuses)->with('inquiries', $inquiries)->with('flag', $flag);
    }
    public function fetchAssignInquiriesByStatus(Request $request)
    {
        $status_id = $request->status_id;
        $assign_id = Auth::user()->id;
        $user_id = Auth::user()->id;
        $flag = 0;
        $inquiries = $this->inquiryService->getInquiriesByAssign($assign_id, $user_id);
        if($status_id == 1) {
            $inquiries = $this->inquiryService->getInquiriesByAssignByStatus($assign_id, $status_id);
        } elseif($status_id == 2) {
            $inquiries = $this->inquiryService->getInquiriesByAssignByStatus($assign_id, $status_id);
        } elseif($status_id == 3) {
            $inquiries = $this->inquiryService->getInquiriesByAssignByStatus($assign_id, $status_id);
        } elseif($status_id == 4) {
            $inquiries = $this->inquiryService->getInquiriesByAssignByStatus($assign_id, $status_id);
        } elseif($status_id == 5) {
            $inquiries = $this->inquiryService->getInquiriesByAssignByStatus($assign_id, $status_id);
        } elseif($status_id == 6) {
            $inquiries = $this->inquiryService->getInquiriesByAssignByStatus($assign_id, $status_id);
        }
        return view('users.list')->with('inquiries', $inquiries)->with('flag', $flag)->render();
    }
}