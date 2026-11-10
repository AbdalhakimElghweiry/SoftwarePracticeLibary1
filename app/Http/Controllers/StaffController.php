<?php

namespace App\Http\Controllers;
use App\Http\Requests\StaffStoreRequest;
use App\Http\Requests\StaffUpdateRequest;
use App\Http\Resources\StaffResource;
use Illuminate\Http\Request;
use App\Models\Staff;

class StaffController extends Controller
{
    public function index()
    {
        $staff = Staff::all();
        return StaffResource::collection($staff);
    }
    public function store(StaffStoreRequest $request)
    {
        $validated = $request->validated();
        $staff = Staff::create($validated);
        return StaffResource::make($staff);;
    }
    public function show ($id){
        $staff = Staff::find($id);
        return StaffResource::make($staff);
    }
    public function update( $id,StaffUpdateRequest $request)
    {
        $staff = Staff::find($id);
        $validated = $request->validated();
        $staff->update($validated);
        return StaffResource::make($staff);;
    }

    public function destroy ($id)
    {
        $staff = Staff::findorfile($id);
        $staff->delete();
        return response()->json(['message'=> 'Staff Deleteed']);
    }

}
