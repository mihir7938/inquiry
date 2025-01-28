<?php

namespace App\Services;

use App\Models\Requirement;

class RequirementService
{

    public function getAllRequirements($per_page = -1)
    {
        if($per_page == -1){
            return Requirement::orderByRaw('field(name, "Other")')->orderBy('created_at')->get();    
        }
        return Requirement::orderByRaw('field(name, "Other")')->orderBy('created_at')->paginate($per_page);
    }

    public function getRequirementById($id)
    {
        return Requirement::find($id);
    }

    public function create($data)
    {
        return Requirement::create($data);
    }

    public function update($requirements, $data)
    {
        return $requirements->update($data);
    }

    public function delete($requirements)
    {
        return $requirements->delete($requirements);
    }
}
