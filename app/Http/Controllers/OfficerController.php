<?php

namespace App\Http\Controllers;

use App\Models\Officer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OfficerController extends Controller{
    
    public function store(Request $request)
{
    $request->validate([
        'from_organization_id' => 'required',
        'officer_first_name' => 'required',
        'officer_last_name' => 'required',
        'position' => 'required',
        'officer_contact' => 'required',
        'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $photoFilename = 'defaultpfp.png';
    if ($request->hasFile('photo')) {
        $photoFile = $request->file('photo');
        $photoFilename = uniqid() . '.' . $photoFile->getClientOriginalExtension();
        $photoFile->move(public_path('profile-imgs'), $photoFilename);
    }

    Officer::create([
        'from_organization_id' => $request->input('from_organization_id'),
        'officer_first_name' => $request->input('officer_first_name'),
        'officer_last_name' => $request->input('officer_last_name'),
        'position' => $request->input('position'),
        'officer_contact' => $request->input('officer_contact'),
        'photo' => $photoFilename,
        'is_current' => $request->input('is_current') ? 1 : 0,
        'term_start' => $request->input('term_start'),
        'term_end' => $request->input('term_start') + 1,
    ]);

    return redirect()->back()->with('success', 'Officer has been successfully added.');
}

    public function updateIsCurrent($id)
    {
        $officer = Officer::findOrFail($id);

        $officer->update([
            'is_current' => 0
        ]);

        return redirect()->back()->with('success', 'Officer status has been updated.');
    }

    public function markAllAsPrevious()
{
    Officer::where('is_current', 1)->update(['is_current' => 0]);

    return redirect()->back()->with('success', 'All officers have been marked as previous officers.');
}

    public function delete(Request $request, $id){
        $post = Officer::findOrFail($id);
        $post->delete();
    return redirect()->back()->with('success', 'Officer has been removed.');
    }
}