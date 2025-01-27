<?php

namespace App\Services;

use App\Models\Business;

class BusinessService
{

    public function getAllBusiness($per_page = -1)
    {
        if($per_page == -1){
            return Business::orderBy('created_at', 'desc')->get();    
        }
        return Business::orderBy('created_at', 'desc')->paginate($per_page);
    }

    public function getBusinessById($id)
    {
        return Business::find($id);
    }

    public function create($data)
    {
        return Business::create($data);
    }

    public function update($business, $data)
    {
        return $business->update($data);
    }

    public function delete($business)
    {
        return $business->delete($business);
    }
}
