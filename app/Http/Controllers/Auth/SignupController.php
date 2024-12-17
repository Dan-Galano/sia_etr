<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\SchoolOrganization;
use App\Models\OrgRequiredDoc;

class SignupController extends Controller
{
    public function showSignupForm()
    {
        return view('auth.signup');
    }

    public function signupStudent(Request $request)
    { 
        try {
            $request->validate([
                'firstname' => 'required|string|max:255',
                'middlename' => 'nullable|string|max:255',
                'lastname' => 'required|string|max:255',
                'studentid' => 'required|string|max:255|unique:users,studentid',
                'stud_email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8',
                'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
    
            $photoFilename = 'defaultpfp.png';
            if ($request->hasFile('photo')) {
                $photoFile = $request->file('photo');
                $photoFilename = uniqid() . '.' . $photoFile->getClientOriginalExtension();
                $photoFile->move(public_path('profile-imgs'), $photoFilename);
            }
    
            DB::table('users')->insert([
                'type' => 'member',
                'firstname' => $request->input('firstname'),
                'middlename' => $request->input('middlename'),
                'lastname' => $request->input('lastname'),
                'studentid' => $request->input('studentid'),
                'email' => $request->input('stud_email'),
                'photo' => $photoFilename,
                'password' => Hash::make($request->input('password')),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
    
            return response()->json(['success' => true, 'message' => 'Student account created successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
    
    
    // Signup method for Organization
    public function signupOrganization(Request $request)
    {
        try {
            \Log::info('Received Request:', $request->all()); // Log request data
    
            // Validate the form input
            $request->validate([
                'orgname' => 'required|string|max:255',
                'org_email' => 'required|email|unique:users,email',
                'org_password' => 'required|string|min:8',
                'program' => 'required|string|max:255',
                'bio' => 'nullable|string', 
                'mission' => 'nullable|string', 
                'vision' => 'nullable|string', 
                'org_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif', 
                'documents' => 'nullable|array', 
                'documents.*' => 'nullable|mimes:pdf,docx,jpg,png,jpeg|max:10240',
            ]);
    
       // Save the user's information (the organizer)
$userPhoto = null;
if ($request->hasFile('org_logo')) {
    // Generate a unique filename for the logo
    $userPhoto = time() . '_' . uniqid() . '.' . $request->file('org_logo')->getClientOriginalExtension();
    
    // Move the logo to the 'profile-imgs' folder
    $request->file('org_logo')->move(public_path('profile-imgs'), $userPhoto);

    // Copy the logo to the 'cover-photos' folder
    \File::copy(public_path('profile-imgs/' . $userPhoto), public_path('cover-photos/' . $userPhoto));
}

    
            $user = User::create([
                'type' => 'organizer',
                'firstname' => $request->orgname,
                'lastname' => null,
                'email' => $request->org_email,
                'photo' => $userPhoto ?? 'defaultpfp.png',  // Use unique filename for user photo
                'password' => Hash::make($request->org_password),
            ]);
    
            // Save the school organization information
            $schoolLogo = $userPhoto; // If logo is uploaded, use the same filename
            if ($request->hasFile('org_logo') && !$userPhoto) {
                // If no logo uploaded, use the default filename
                $schoolLogo = 'defaultpfp.png';
            }
    
            $schoolOrganization = SchoolOrganization::create([
                'status' => 'pending',
                'orgname' => $request->orgname,
                'course' => $request->program,
                'bio' => $request->bio ?? null,
                'mission' => $request->mission ?? null,
                'vision' => $request->vision ?? null,
                'contact' => $request->contact ?? null,
                'facebook' => $request->facebook ?? null,
                'instagram' => $request->instagram ?? null,
                'twitter' => $request->twitter ?? null,
                'tiktok' => $request->tiktok ?? null,
                'youtube' => $request->youtube ?? null,
                'coverphoto' => $schoolLogo,  // Store the unique filename for the organization logo
                'admin_id' => $user->id,
            ]);
    
            // Save the document filenames with uniqueness if they are uploaded
            if ($request->hasFile('documents')) {
                foreach ($request->file('documents') as $document) {
                    // Generate a unique filename for the document
                    $documentFilename = time() . '_' . uniqid() . '.' . $document->getClientOriginalExtension();
    
                    // Store the document using the unique filename
                    OrgRequiredDoc::create([
                        'school_org_id' => $schoolOrganization->id,
                        'doc_filename' => $documentFilename, // Store the unique filename
                    ]);
    
                    // Store the document in the desired folder with the unique filename
                    $document->storeAs('organization_documents', $documentFilename);
                }
            }
    
            \Log::info('Organization and user created successfully.');
            
            return response()->json(['success' => true, 'message' => 'Organization successfully registered!']);
            
        } catch (\Exception $e) {
            \Log::error('Error in signupOrganization method: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' =>  $e->getMessage()], 500);
        }
    }
    
    
}
