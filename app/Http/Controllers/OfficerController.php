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
    ]);

    Officer::create([
        'from_organization_id' => $request->input('from_organization_id'),
        'officer_first_name' => $request->input('officer_first_name'),
        'officer_last_name' => $request->input('officer_last_name'),
        'position' => $request->input('position'),
        'officer_contact' => $request->input('officer_contact'),
    ]);

    return redirect()->back()->with('success', 'Officer has been successfully added.');
}


    public function delete(Request $request, $id){
        $post = Officer::findOrFail($id);
        $post->delete();
    return redirect()->back()->with('success', 'Officer has been removed.');
    }
}