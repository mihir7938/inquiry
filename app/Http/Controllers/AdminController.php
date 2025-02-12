<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Services\UploadImageService;
use App\Services\CityService;
use App\Services\BusinessService;
use App\Services\RequirementService;
use App\Services\StatusService;
use App\Services\AssignService;
use App\Services\UserService;
use App\Services\InquiryService;
use App\Services\InquiryPhotosService;
use App\Models\Inquiry;
use App\Models\User;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller {

	private $imageService, $cityService, $businessService, $requirementService, $statusService, $assignService, $userService, $inquiryService, $inquiryPhotosService;

    public function __construct(
        UploadImageService $imageService,
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
        $total_inquiry = Inquiry::count();
        $total_pending_inquiry = $this->inquiryService->getTotalInquiriesByStatus(1);
        $total_demo = $this->inquiryService->getTotalInquiriesByStatus(2);
        $total_followup = $this->inquiryService->getTotalInquiriesByStatus(3);
        $total_confirmed = $this->inquiryService->getTotalInquiriesByStatus(4);
        $total_cancelled = $this->inquiryService->getTotalInquiriesByStatus(5);
        $total_future_list = $this->inquiryService->getTotalInquiriesByStatus(6);
        $total_users = User::count();
        return view('admin.index')->with('total_inquiry', $total_inquiry)->with('total_pending_inquiry', $total_pending_inquiry)->with('total_demo', $total_demo)->with('total_followup', $total_followup)->with('total_confirmed', $total_confirmed)->with('total_cancelled', $total_cancelled)->with('total_future_list', $total_future_list)->with('total_users', $total_users);
    }
    public function cities(Request $request)
    {
        $cities = $this->cityService->getAllCities();
        return view('admin.cities.index')->with('cities', $cities);
    }
    public function addCity(Request $request)
    {
        return view('admin.cities.add');
    }
    public function saveCity(Request $request)
    {
        $data = $request->all();
        $data['name'] = $request->city;
        $this->cityService->create($data);
        $request->session()->put('message', 'City has been added successfully.');
        $request->session()->put('alert-type', 'alert-success');
        return redirect()->route('admin.cities');
    }
    public function editCity(Request $request, $id)
    {
        try{
            $city = $this->cityService->getCityById($id);
            if(!$city){
                throw new BadRequestException('Invalid Request id');
            }
            return view('admin.cities.edit')->with('city', $city);
        }catch(\Exception $e){
            $request->session()->put('message', $e->getMessage());
            $request->session()->put('alert-type', 'alert-warning');
            return redirect()->route('admin.cities');
        }
    }
    public function updateCity(Request $request)
    {
        try{
            $city = $this->cityService->getCityById($request->id);
            if(!$city){
                throw new BadRequestException('Invalid Request id');
            }
            $data['name'] = $request->city;
            $this->cityService->update($city, $data);
            $request->session()->put('message', 'City has been updated successfully.');
            $request->session()->put('alert-type', 'alert-success');
            return redirect()->route('admin.cities');
        }catch(\Exception $e){
            $request->session()->put('message', $e->getMessage());
            $request->session()->put('alert-type', 'alert-warning');
            return redirect()->route('admin.cities');
        }
    }
    public function deleteCity(Request $request, $id)
    {
        try{
            $city = $this->cityService->getCityById($id);
            if(!$city){
                throw new BadRequestException('Invalid Request id.');
            }
            $this->cityService->delete($city);
            $request->session()->put('message', 'City has been deleted successfully.');
            $request->session()->put('alert-type', 'alert-success');
            return redirect()->route('admin.cities');
        }catch(\Exception $e){
            $request->session()->put('message', $e->getMessage());
            $request->session()->put('alert-type', 'alert-warning');
            return redirect()->route('admin.cities');
        }
    }
    public function business(Request $request)
    {
        $businesses = $this->businessService->getAllBusiness();
        return view('admin.business.index')->with('businesses', $businesses);
    }
    public function addBusiness(Request $request)
    {
        return view('admin.business.add');
    }
    public function saveBusiness(Request $request)
    {
        $data = $request->all();
        $data['name'] = $request->name;
        $this->businessService->create($data);
        $request->session()->put('message', 'Business has been added successfully.');
        $request->session()->put('alert-type', 'alert-success');
        return redirect()->route('admin.business');
    }
    public function editBusiness(Request $request, $id)
    {
        try{
            $business = $this->businessService->getBusinessById($id);
            if(!$business){
                throw new BadRequestException('Invalid Request id');
            }
            return view('admin.business.edit')->with('business', $business);
        }catch(\Exception $e){
            $request->session()->put('message', $e->getMessage());
            $request->session()->put('alert-type', 'alert-warning');
            return redirect()->route('admin.business');
        }
    }
    public function updateBusiness(Request $request)
    {
        try{
            $business = $this->businessService->getBusinessById($request->id);
            if(!$business){
                throw new BadRequestException('Invalid Request id');
            }
            $data['name'] = $request->name;
            $this->businessService->update($business, $data);
            $request->session()->put('message', 'Business has been updated successfully.');
            $request->session()->put('alert-type', 'alert-success');
            return redirect()->route('admin.business');
        }catch(\Exception $e){
            $request->session()->put('message', $e->getMessage());
            $request->session()->put('alert-type', 'alert-warning');
            return redirect()->route('admin.business');
        }
    }
    public function deleteBusiness(Request $request, $id)
    {
        try{
            $business = $this->businessService->getBusinessById($id);
            if(!$business){
                throw new BadRequestException('Invalid Request id.');
            }
            $this->businessService->delete($business);
            $request->session()->put('message', 'Business has been deleted successfully.');
            $request->session()->put('alert-type', 'alert-success');
            return redirect()->route('admin.business');
        }catch(\Exception $e){
            $request->session()->put('message', $e->getMessage());
            $request->session()->put('alert-type', 'alert-warning');
            return redirect()->route('admin.business');
        }
    }
    public function requirements(Request $request)
    {
        $requirements = $this->requirementService->getAllRequirements();
        return view('admin.requirements.index')->with('requirements', $requirements);
    }
    public function addRequirement(Request $request)
    {
        return view('admin.requirements.add');
    }
    public function saveRequirement(Request $request)
    {
        $data = $request->all();
        $data['name'] = $request->name;
        $this->requirementService->create($data);
        $request->session()->put('message', 'Requirement has been added successfully.');
        $request->session()->put('alert-type', 'alert-success');
        return redirect()->route('admin.requirements');
    }
    public function editRequirement(Request $request, $id)
    {
        try{
            $requirement = $this->requirementService->getRequirementById($id);
            if(!$requirement){
                throw new BadRequestException('Invalid Request id');
            }
            return view('admin.requirements.edit')->with('requirement', $requirement);
        }catch(\Exception $e){
            $request->session()->put('message', $e->getMessage());
            $request->session()->put('alert-type', 'alert-warning');
            return redirect()->route('admin.requirements');
        }
    }
    public function updateRequirement(Request $request)
    {
        try{
            $requirement = $this->requirementService->getRequirementById($request->id);
            if(!$requirement){
                throw new BadRequestException('Invalid Request id');
            }
            $data['name'] = $request->name;
            $this->requirementService->update($requirement, $data);
            $request->session()->put('message', 'Requirement has been updated successfully.');
            $request->session()->put('alert-type', 'alert-success');
            return redirect()->route('admin.requirements');
        }catch(\Exception $e){
            $request->session()->put('message', $e->getMessage());
            $request->session()->put('alert-type', 'alert-warning');
            return redirect()->route('admin.requirements');
        }
    }
    public function deleteRequirement(Request $request, $id)
    {
        try{
            $requirement = $this->requirementService->getRequirementById($id);
            if(!$requirement){
                throw new BadRequestException('Invalid Request id.');
            }
            $this->requirementService->delete($requirement);
            $request->session()->put('message', 'Requirement has been deleted successfully.');
            $request->session()->put('alert-type', 'alert-success');
            return redirect()->route('admin.requirements');
        }catch(\Exception $e){
            $request->session()->put('message', $e->getMessage());
            $request->session()->put('alert-type', 'alert-warning');
            return redirect()->route('admin.requirements');
        }
    }
    public function status(Request $request)
    {
        $statuses = $this->statusService->getAllStatus();
        return view('admin.status.index')->with('statuses', $statuses);
    }
    public function addStatus(Request $request)
    {
        return view('admin.status.add');
    }
    public function saveStatus(Request $request)
    {
        $data = $request->all();
        $data['name'] = $request->name;
        $this->statusService->create($data);
        $request->session()->put('message', 'Status has been added successfully.');
        $request->session()->put('alert-type', 'alert-success');
        return redirect()->route('admin.status');
    }
    public function editStatus(Request $request, $id)
    {
        try{
            $status = $this->statusService->getStatusById($id);
            if(!$status){
                throw new BadRequestException('Invalid Request id');
            }
            return view('admin.status.edit')->with('status', $status);
        }catch(\Exception $e){
            $request->session()->put('message', $e->getMessage());
            $request->session()->put('alert-type', 'alert-warning');
            return redirect()->route('admin.status');
        }
    }
    public function updateStatus(Request $request)
    {
        try{
            $status = $this->statusService->getStatusById($request->id);
            if(!$status){
                throw new BadRequestException('Invalid Request id');
            }
            $data['name'] = $request->name;
            $this->statusService->update($status, $data);
            $request->session()->put('message', 'Status has been updated successfully.');
            $request->session()->put('alert-type', 'alert-success');
            return redirect()->route('admin.status');
        }catch(\Exception $e){
            $request->session()->put('message', $e->getMessage());
            $request->session()->put('alert-type', 'alert-warning');
            return redirect()->route('admin.status');
        }
    }
    public function deleteStatus(Request $request, $id)
    {
        try{
            $status = $this->statusService->getStatusById($id);
            if(!$status){
                throw new BadRequestException('Invalid Request id.');
            }
            $this->statusService->delete($status);
            $request->session()->put('message', 'Status has been deleted successfully.');
            $request->session()->put('alert-type', 'alert-success');
            return redirect()->route('admin.status');
        }catch(\Exception $e){
            $request->session()->put('message', $e->getMessage());
            $request->session()->put('alert-type', 'alert-warning');
            return redirect()->route('admin.status');
        }
    }
    public function assign(Request $request)
    {
        $assigns = $this->assignService->getAllAssign();
        return view('admin.assign.index')->with('assigns', $assigns);
    }
    public function addAssign(Request $request)
    {
        return view('admin.assign.add');
    }
    public function saveAssign(Request $request)
    {
        $data = $request->all();
        $data['name'] = $request->name;
        $this->assignService->create($data);
        $request->session()->put('message', 'Assign name has been added successfully.');
        $request->session()->put('alert-type', 'alert-success');
        return redirect()->route('admin.assign');
    }
    public function editAssign(Request $request, $id)
    {
        try{
            $assign = $this->assignService->getAssignById($id);
            if(!$assign){
                throw new BadRequestException('Invalid Request id');
            }
            return view('admin.assign.edit')->with('assign', $assign);
        }catch(\Exception $e){
            $request->session()->put('message', $e->getMessage());
            $request->session()->put('alert-type', 'alert-warning');
            return redirect()->route('admin.assign');
        }
    }
    public function updateAssign(Request $request)
    {
        try{
            $assign = $this->assignService->getAssignById($request->id);
            if(!$assign){
                throw new BadRequestException('Invalid Request id');
            }
            $data['name'] = $request->name;
            $this->assignService->update($assign, $data);
            $request->session()->put('message', 'Assign name has been updated successfully.');
            $request->session()->put('alert-type', 'alert-success');
            return redirect()->route('admin.assign');
        }catch(\Exception $e){
            $request->session()->put('message', $e->getMessage());
            $request->session()->put('alert-type', 'alert-warning');
            return redirect()->route('admin.assign');
        }
    }
    public function deleteAssign(Request $request, $id)
    {
        try{
            $assign = $this->assignService->getAssignById($id);
            if(!$assign){
                throw new BadRequestException('Invalid Request id.');
            }
            $this->assignService->delete($assign);
            $request->session()->put('message', 'Assign name has been deleted successfully.');
            $request->session()->put('alert-type', 'alert-success');
            return redirect()->route('admin.assign');
        }catch(\Exception $e){
            $request->session()->put('message', $e->getMessage());
            $request->session()->put('alert-type', 'alert-warning');
            return redirect()->route('admin.assign');
        }
    }
    public function getUsers()
    {
        $users = $this->userService->getAllUsers();
        return view('admin.users.index')->with('users', $users);
    }
    public function addUser()
    {
        return view('admin.users.add');
    }
    public function saveUser(UserRequest $request)
    {
        $user = $this->userService->create($request);
        $request->session()->put('message', 'User has been added successfully.');
        $request->session()->put('alert-type', 'alert-success');
        return redirect()->route('admin.users');
    }
    public function editUser(Request $request, $id)
    {
        try{
            $user = $this->userService->getUserById($id);
            if(!$user){
                throw new BadRequestException('Invalid Request id');
            }
            return view('admin.users.edit')->with('user', $user);
        }catch(\Exception $e){
            $request->session()->put('message', $e->getMessage());
            $request->session()->put('alert-type', 'alert-warning');
            return redirect()->route('admin.users');
        }
    }
    public function updateUser(Request $request)
    {
        try{
            $user = $this->userService->getUserById($request->id);
            if(!$user){
                throw new BadRequestException('Invalid Request id');
            }
            $data['name'] = $request->name;
            $data['email'] = $request->email;
            if($user->isUser()) {
                $data['status'] = $request->active;
            }
            $this->userService->update($user, $data);
            $request->session()->put('message', 'User has been updated successfully.');
            $request->session()->put('alert-type', 'alert-success');
            return redirect()->route('admin.users');
        }catch(\Exception $e){
            $request->session()->put('message', $e->getMessage());
            $request->session()->put('alert-type', 'alert-warning');
            return redirect()->route('admin.users');
        }
    }
    public function deleteUser(Request $request, $id)
    {
        try{
            $user = $this->userService->getUserById($id);
            if(!$user){
                throw new BadRequestException('Invalid Request id.');
            }
            $this->userService->delete($user);
            $request->session()->put('message', 'User has been deleted successfully.');
            $request->session()->put('alert-type', 'alert-success');
            return redirect()->route('admin.users');
        }catch(\Exception $e){
            $request->session()->put('message', $e->getMessage());
            $request->session()->put('alert-type', 'alert-warning');
            return redirect()->route('admin.users');
        }
    }
    public function getInquiries(Request $request)
    {
        $statuses = $this->statusService->getAllStatus();
        $status_id = "";
        if( $request->has('status') ) {
            $status_id = $request->input('status');
            $inquiries = $this->inquiryService->getInquiriesByStatus($status_id);
        } else {
            $inquiries = $this->inquiryService->getAllInquiries();
        }
        return view('admin.inquiries.index')->with('statuses', $statuses)->with('status_id', $status_id)->with('inquiries', $inquiries);
    }
    public function fetchInquiriesByStatus(Request $request)
    {
        $status_id = $request->status_id;
        $inquiries = $this->inquiryService->getAllInquiries();
        if($status_id == 1) {
            $inquiries = $this->inquiryService->getInquiriesByStatus($status_id);
        } elseif($status_id == 2) {
            $inquiries = $this->inquiryService->getInquiriesByStatus($status_id);
        } elseif($status_id == 3) {
            $inquiries = $this->inquiryService->getInquiriesByStatus($status_id);
        } elseif($status_id == 4) {
            $inquiries = $this->inquiryService->getInquiriesByStatus($status_id);
        } elseif($status_id == 5) {
            $inquiries = $this->inquiryService->getInquiriesByStatus($status_id);
        } elseif($status_id == 6) {
            $inquiries = $this->inquiryService->getInquiriesByStatus($status_id);
        }
        return view('admin.inquiries.list')->with('inquiries', $inquiries)->render();
    }
    public function addInquiry(Request $request)
    {
        $businesses = $this->businessService->getAllBusiness();
        $requirements = $this->requirementService->getAllRequirements();
        $statuses = $this->statusService->getAllStatus();
        $users = $this->userService->getAllUsers();
        return view('admin.inquiries.add')->with('businesses', $businesses)->with('requirements', $requirements)->with('statuses', $statuses)->with('users', $users);
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
        return redirect()->route('admin.inquiries');
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
            return view('admin.inquiries.edit')->with('inquiry', $inquiry)->with('businesses', $businesses)->with('requirements', $requirements)->with('statuses', $statuses)->with('users', $users);
        }catch(\Exception $e){
            $request->session()->put('message', $e->getMessage());
            $request->session()->put('alert-type', 'alert-warning');
            return redirect()->route('admin.inquiries');
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
            $data['company_name'] = $request->company_name;
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
            return redirect()->route('admin.inquiries');
        }catch(\Exception $e){
            $request->session()->put('message', $e->getMessage());
            $request->session()->put('alert-type', 'alert-warning');
            return redirect()->route('admin.inquiries');
        }
    }
}