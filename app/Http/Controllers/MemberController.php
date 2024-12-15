<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\OrganizationMember;
use App\Models\SchoolOrganization;
use Illuminate\Support\Facades\DB;


class MemberController extends Controller
{
    public function index()
    {
        
        return view('member-home');
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        
        
        $validatedData = $request->validate([
            'schoolorg' => 'required|exists:school_organizations,id',
        ]);
        
        
        OrganizationMember::create([
            'organization_id' => $validatedData['schoolorg'],
            'member_id' => $user->id,
            'status' => 'pending', 
        ]);
        
        return redirect()->back()->with('success', 'Membership request sent successfully!');
    }
    // OrganizationController.php
public function toggleJoin(Request $request, $id)
{
    $user = Auth::user();
    $organization = SchoolOrganization::findOrFail($id);

    $existingMembership = OrganizationMember::where('organization_id', $id)->where('member_id', $user->id)->first();

    if ($existingMembership) {
        $existingMembership->delete();
        return response()->json(['status' => 'unjoined']);
    } else {
        OrganizationMember::create([
            'organization_id' => $organization->id,
            'member_id' => $user->id,
            'status' => 'pending', 
        ]);
        return response()->json(['status' => 'joined']);
    }
}

public function deleteMember($org_id, $member_id)
    {
        // Log request for debugging

        // Perform the deletion
        DB::table('organization_members')
            ->where('organization_id', $org_id)
            ->where('id', $member_id)
            ->delete();

       

        return redirect()->back()->with('success', 'Member deleted successfully.');
    }

}
