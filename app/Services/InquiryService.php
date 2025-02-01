<?php

namespace App\Services;

use App\Models\Inquiry;

class InquiryService
{

    public function getAllInquiries($per_page = -1)
    {
        if($per_page == -1){
            return Inquiry::orderBy('created_at','desc')->get();    
        }
        return Inquiry::orderBy('created_at','desc')->paginate($per_page);
    }

    public function getInquiryById($id)
    {
        return Inquiry::find($id);
    }

    public function create($data)
    {
        return Inquiry::create($data);
    }

    public function update($inquiry, $data)
    {
        return $inquiry->update($data);
    }

    public function delete($inquiry)
    {
        return $inquiry->delete($inquiry);
    }

    public function getInquiriesByStatus($status_id)
    {
        return Inquiry::where('status_id', $status_id)->orderBy('created_at','desc')->get();
    }

    public function getInquiriesByUser($user_id)
    {
        return Inquiry::where('user_id', $user_id)->orderBy('created_at','desc')->get();
    }

    public function getInquiriesByUserByStatus($user_id, $status_id)
    {
        return Inquiry::where('user_id', $user_id)->where('status_id', $status_id)->orderBy('created_at','desc')->get();
    }

    public function getInquiriesByAssign($assign_id)
    {
        return Inquiry::where('assign_id', $assign_id)->orderBy('created_at','desc')->get();
    }

    public function getInquiriesByAssignByStatus($assign_id, $status_id)
    {
        return Inquiry::where('assign_id', $assign_id)->where('status_id', $status_id)->orderBy('created_at','desc')->get();
    }

    public function getTotalInquiriesByStatus($status_id)
    {
        return Inquiry::where('status_id', $status_id)->count();
    }

    public function getTotalInquiriesByUser($user_id)
    {
        return Inquiry::where('user_id', $user_id)->count();
    }

    public function getTotalInquiriesByAssign($assign_id)
    {
        return Inquiry::where('assign_id', $assign_id)->count();
    }

    public function getTotalInquiriesByUserByStatus($user_id, $status_id)
    {
        return Inquiry::where('user_id', $user_id)->where('status_id', $status_id)->count();
    }
    
}
