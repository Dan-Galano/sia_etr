<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\SchoolOrganization;
use App\Models\Post;
use App\Models\PhotoPost;
use App\Models\Chat;
use App\Models\Report;
use App\Models\EnrolledStudent;
use App\Models\Attendance;
use App\Models\OrgRequiredDoc;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class GeneralController extends Controller
{
    public function checkSchoolOrg()
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['result' => false]);
        }

        $hasSchoolOrg = $user->schoolOrganizations()->exists();

        return response()->json(['result' => $hasSchoolOrg]);
    }

    public function storeOrganization(Request $request)
    {
        $request->validate([
            'orgname' => 'required|string|max:255',
            'course' => 'required|string',
            'bio' => 'required|string',
            'contact' => 'nullable|string',
            'facebook' => 'nullable',
            'instagram' => 'nullable',
            'twitter' => 'nullable',
            'tiktok' => 'nullable',
            'youtube' => 'nullable',
            'coverphoto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('coverphoto')) {
            $coverPhotoFile = $request->file('coverphoto');
            $coverPhotoFilename = time() . '_' . $coverPhotoFile->getClientOriginalName();
            $coverPhotoFile->move(public_path('cover-photos'), $coverPhotoFilename);
        }

        $organization = new SchoolOrganization([
            'orgname' => $request->input('orgname'),
            'course' => $request->input('course'),
            'bio' => $request->input('bio'),
            'contact' => $request->input('contact'),
            'facebook' => $request->input('facebook'),
            'instagram' => $request->input('instagram'),
            'twitter' => $request->input('twitter'),
            'tiktok' => $request->input('tiktok'),
            'youtube' => $request->input('youtube'),
            'coverphoto' => $coverPhotoFilename,
            'admin_id' => Auth::id(),
        ]);

        $organization->save();

        return redirect()->back()->with('success', 'Organization created successfully!');
    }

    //     public function showOrg($id)
    // {
    //     $orgid = SchoolOrganization::findOrFail($id);
    //     $organization = SchoolOrganization::findOrFail($id);
    //     $orgname = $orgid->orgname;
    //     $coverphoto = $orgid->coverphoto;

    //     $photos = DB::table('photo_posts')
    //     ->join('posts', 'photo_posts.post_id', '=', 'posts.id')
    //     ->where('posts.organization_id', $organization->id)
    //     ->orderBy('photo_posts.created_at', 'desc')
    //     ->select('photo_posts.photo_filename', 'posts.privacy')
    //     ->get();

    //     $organization->load(['posts' => function ($query) {
    //         $query->withCount(['reactions', 'comments'])->orderBy('created_at', 'desc')->with('comments.user');
    //     }]);

    //     $members = DB::table('organization_members')
    //         ->join('users', 'organization_members.member_id', '=', 'users.id')
    //         ->where('organization_members.organization_id', $organization->id)
    //         ->orderBy('organization_members.created_at', 'desc')
    //         ->select('users.id', 'users.photo', 'users.studentid', 'users.firstname', 'users.middlename', 'users.lastname', 'users.email', 'organization_members.status')
    //         ->get();

    //     // Check if the authenticated user is a member of the organization
    //     $isMember = false;
    //     if (Auth::check()) {
    //         $userId = Auth::id();
    //         $isMember = DB::table('organization_members')
    //             ->where('organization_id', $organization->id)
    //             ->where('member_id', $userId)
    //             ->where('status', 'approved')
    //             ->exists();

    //         if (!$isMember) {
    //             $isAdmin = DB::table('school_organizations')
    //                 ->where('id', $organization->id)
    //                 ->where('admin_id', $userId)
    //                 ->exists();
    //             $isMember = $isAdmin;
    //         }
    //     }
    //     $reports = Report::where('from_organization_id', $organization->id)
    //     ->with(['reportedUser', 'reporter'])
    //     ->get();

    //     return view('organization-dashboard', compact('orgid', 'orgname', 'coverphoto', 'organization', 'photos', 'members', 'isMember', 'reports'));
    // }

    public function showOrg($id)
    {
        $orgid = SchoolOrganization::findOrFail($id);
        $organization = $orgid; // Same variable for consistency
        $orgname = $orgid->orgname;
        $coverphoto = $orgid->coverphoto;
        $orgStatus = $orgid->status;

        // Fetch all organizations for the dropdown or another purpose
        $organizations = SchoolOrganization::all(); // Make sure you're getting the data

        // Fetch photos related to the organization
        $photos = DB::table('photo_posts')
            ->join('posts', 'photo_posts.post_id', '=', 'posts.id')
            ->where('posts.organization_id', $organization->id)
            ->orderBy('photo_posts.created_at', 'desc')
            ->select('photo_posts.photo_filename', 'posts.privacy')
            ->get();

        // Load posts for the organization
        $organization->load([
            'posts' => function ($query) {
                $query
                    ->withCount(['reactions', 'comments'])
                    ->orderBy('created_at', 'desc')
                    ->with('comments.user');
            },
        ]);

        // Fetch organization members
        $members = DB::table('organization_members')
            ->join('users', 'organization_members.member_id', '=', 'users.id')
            ->where('organization_members.organization_id', $organization->id)
            ->orderBy('organization_members.created_at', 'desc')
            ->select('users.photo', 'users.studentid', 'users.firstname', 'users.middlename', 'users.lastname', 'users.email', 'organization_members.status', 'organization_members.payment_status', 'organization_members.id', 'organization_members.member_id')
            ->get();

        // Check if the authenticated user is a member or the admin (owner) of the organization
        $isMember = false;
        if (Auth::check()) {
            $userId = Auth::id();
            $isMember = DB::table('organization_members')
                ->where('organization_id', $organization->id)
                ->where('member_id', $userId)
                ->where('status', 'approved')
                ->exists();

            if (!$isMember) {
                $isAdmin = DB::table('school_organizations')
                    ->where('id', $organization->id)
                    ->where('admin_id', $userId)
                    ->exists();
                $isMember = $isAdmin; // Check if the user is the admin
            }
        }

        // Fetch reports for the organization
        $reports = Report::where('from_organization_id', $organization->id)
            ->with(['reportedUser', 'reporter'])
            ->get();

        // Pass the variables to the view, including $organizations
        return view('organization-dashboard', compact('orgid', 'orgname', 'orgStatus', 'coverphoto', 'organization', 'photos', 'members', 'isMember', 'reports', 'organizations'));
    }

    public function toggleMember($id, $member_id)
    {
        $member = DB::table('organization_members')->where('id', $member_id)->first();

        if ($member) {
            $newStatus = $member->status === 'approved' ? 'rejected' : 'approved';
            DB::table('organization_members')
                ->where('id', $member_id)
                ->update(['status' => $newStatus]);
        }

        return redirect("/organization/{$id}");
    }

    // TOGGLE ORG 
    public function toggleOrganization($organization_id)
    {
        $organization = DB::table('school_organizations')->where('id', $organization_id)->first();

        if ($organization) {
            $newStatus = $organization->status === 'approved' ? 'reaccred' : 'approved';
            DB::table('school_organizations')
                ->where('id', $organization_id)
                ->update(['status' => $newStatus]);
        }

        return redirect()->back()->with('success', 'Organization status updated successfully.');
    }

    // DISABLE ALL ORGS
    public function setAllReaccred()
    {
        try {
            // Update all organizations to 'reaccred' status
            SchoolOrganization::whereIn('status', ['approved', 'pending', 'rejected'])->update(['status' => 'reaccred']);

            return redirect()->back()->with('success', 'All organizations have been set to reaccred.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while updating the statuses. Please try again.');
        }
    }




    public function createPost($id)
    {
        return view('posts.create', compact('id'));
    }

    // public function storePost(Request $request, $id)
    // {
    //     $request->validate([

    //         'content' => 'nullable|string',
    //         'photos.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    //         'event_title' => 'nullable|string',
    //         'event_start_time' => 'nullable|date',
    //         'event_end_time' => 'nullable|date|after_or_equal:event_start_time',
    //         'privacy' => 'nullable',
    //     ]);

    //     $post = new Post();
    //     $post->organization_id = $id;
    //     $post->user_id = auth()->id();
    //     $post->content = $request->content;
    //     $post->event_title = $request->event_title;
    //     $post->event_start_time = $request->event_start_time;
    //     $post->event_end_time = $request->event_end_time;
    //     $post->privacy = $request->privacy;

    //     if ($request->hasFile('photos') && $request->event_start_time && $request->event_end_time) {
    //         $post->type = 'eventwithphoto';
    //     } elseif ($request->event_start_time && $request->event_end_time) {
    //         $post->type = 'event';
    //     } elseif ($request->hasFile('photos')) {
    //         $post->type = 'withphoto';
    //     } elseif ($request->content) {
    //         $post->type = 'text';
    //     } else {
    //         $post->type = 'unknown';
    //     }

    //     $post->save();

    //     if ($request->hasFile('photos')) {
    //         foreach ($request->file('photos') as $photoFile) {
    //             $photoFilename = time() . '_' . $photoFile->getClientOriginalName();
    //             $photoFile->move(public_path('post-imgs'), $photoFilename);

    //             $photo = new PhotoPost();
    //             $photo->post_id = $post->id;
    //             $photo->photo_filename = $photoFilename;
    //             $photo->save();
    //         }
    //     }

    //     return redirect()->route('organization.show', $id)->with('success', 'Post created successfully.');
    // }

    public function storePost(Request $request, $id)
    {
        $request->validate([
            'content' => 'nullable|string',
            'photos.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'event_title' => 'nullable|string',
            'event_start_time' => 'nullable|date',
            'event_end_time' => 'nullable|date|after_or_equal:event_start_time',
            'privacy' => 'nullable',
            'taggedOrg_id' => 'nullable|integer|exists:school_organizations,id',
        ]);

        // Function to create a post
        $createPost = function ($organization_id, $taggedOrg_id = null) use ($request) {
            $post = new Post();
            $post->organization_id = $organization_id;
            $post->user_id = auth()->id();
            $post->content = $request->content;
            $post->event_title = $request->event_title;
            $post->event_start_time = $request->event_start_time;
            $post->event_end_time = $request->event_end_time;
            $post->privacy = $request->privacy;

            // Set the tagged organization if available
            $post->withTag = $taggedOrg_id;

            // Determine post type based on available data
            if ($request->hasFile('photos') && $request->event_start_time && $request->event_end_time) {
                $post->type = 'eventwithphoto';
            } elseif ($request->event_start_time && $request->event_end_time) {
                $post->type = 'event';
            } elseif ($request->hasFile('photos')) {
                $post->type = 'withphoto';
            } elseif ($request->content) {
                $post->type = 'text';
            } else {
                $post->type = 'unknown';
            }

            $post->save(); // Save the post first

            return $post;
        };

        // Handle photos if they are uploaded
        $uploadedPhotos = $request->hasFile('photos') ? $request->file('photos') : [];

        // Create the post for the primary organization
        $primaryPost = $createPost($id, $request->taggedOrg_id);

        // Add photos to the primary post
        $photoFilenames = [];
        if (!empty($uploadedPhotos)) {
            foreach ($uploadedPhotos as $photoFile) {
                if ($photoFile->isValid()) {
                    // Generate a sanitized filename
                    $photoFilename = time() . '_' . uniqid() . '_' . preg_replace('/[^a-zA-Z0-9-_\.]/', '', $photoFile->getClientOriginalName());

                    // Manually move the uploaded file to the public/post-imgs directory
                    $photoFile->move(public_path('post-imgs'), $photoFilename);

                    // Store the filename for future use
                    $photoFilenames[] = $photoFilename;

                    // Create a new PhotoPost record for the primary post
                    PhotoPost::create([
                        'post_id' => $primaryPost->id,
                        'photo_filename' => $photoFilename,
                    ]);
                }
            }
        }

        // Create the post for the tagged organization if taggedOrg_id is provided and is different from the primary organization
        if ($request->taggedOrg_id && $request->taggedOrg_id != $id) {
            // Create a post for the tagged organization
            $taggedPost = $createPost($request->taggedOrg_id, $id);

            // Add photos to the tagged post (same photos as primary post)
            if (!empty($photoFilenames)) {
                foreach ($photoFilenames as $photoFilename) {
                    // Create a new PhotoPost record for the tagged organization's post
                    PhotoPost::create([
                        'post_id' => $taggedPost->id, // Use the tagged post's ID here
                        'photo_filename' => $photoFilename,
                    ]);
                }
            }
        }

        $message = 'Post created successfully.';
        if ($request->taggedOrg_id) {
            $message .= ' Also posted in the tagged organization.';
        }

        return redirect()->route('organization.show', $id)->with('success', $message);
    }

    public function showProfile()
    {
        $user = Auth::user();
        return view('accountprofile', compact('user'));
    }

    public function updateProfile(Request $request, $id)
    {
        $user = Auth::user();

        if ($user->id != $id) {
            abort(403);
        }

        if ($request->hasFile('profile_photo')) {
            $photoFile = $request->file('profile_photo');

            $request->validate([
                'profile_photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $photoFilename = $photoFile->getClientOriginalName();
            $photoFile->move(public_path('profile-imgs'), $photoFilename);

            $user->photo = $photoFilename;
        }

        $user->update($request->except('profile_photo'));

        $request->session()->put('user', $user);

        return redirect()->route('profile.show')->with('success', 'Profile updated successfully!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'password' => 'required|confirmed|min:8',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->old_password, $user->password)) {
            throw ValidationException::withMessages(['old_password' => 'The old password is incorrect.']);
        }

        $user->password = bcrypt($request->password);
        $user->save();

        return redirect()->route('profile.show')->with('success', 'Password updated successfully!');
    }

    public function checkMembership()
    {
        $user = Auth::user();

        if (!$user) {
            return false;
        }

        $hasMembership = DB::table('organization_members')
            ->where('member_id', $user->id)
            ->where('status', 'approved')
            ->exists();

        return $hasMembership;
    }
    public function getSchoolOrganizations()
    {
        $user = Auth::user();

        // Fetch all organizations
        $organizations = SchoolOrganization::all();

        // Determine the current user's organization (for organizers)
        $orgname = null;
        if ($user->type === 'organizer') {
            $orgOwnedByUser = $user
                ->schoolOrganizations()
                ->where('admin_id', $user->id)
                ->first();
            $orgname = $orgOwnedByUser ? $orgOwnedByUser->name : null;
        }

        // Return all organizations and the orgname (if applicable)
        return compact('organizations', 'orgname');
    }

    public function getSchoolOrganizationsMember()
    {
        $user = Auth::user();

        if ($user->type === 'organizer') {
            // Return organizations owned/administered by the organizer
            return $user
                ->schoolOrganizations()
                ->where('admin_id', $user->id)
                ->get();
        } elseif ($user->type === 'member') {
            // Return organizations the member belongs to
            return $user->organizationsMember()->wherePivot('status', 'approved')->orderBy('organization_members.created_at', 'desc')->get();
        }

        return collect(); // Return an empty collection for undefined user types
    }

    public function getSchoolOrganizationsNotMember()
    {
        $user = Auth::user();

        $memberOrganizationIds = $user->organizationsMember()->pluck('school_organizations.id')->toArray();

        $organizationsNotMembers = SchoolOrganization::whereNotIn('id', $memberOrganizationIds)->get();

        return $organizationsNotMembers;
    }

    public function loadChatView($orgId)
    {
        $chats = Chat::where('organization_id', $orgId)->orderBy('created_at', 'asc')->with('user')->get();

        $organization = SchoolOrganization::find($orgId);

        return view('chat', ['chats' => $chats, 'organization' => $organization]);
    }




    public function sendMessage(Request $request, $orgId)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        Chat::create([
            'organization_id' => $orgId,
            'user_id' => Auth::id(),
            'message' => $request->input('message'),
        ]);

        return redirect()->route('chat.view', ['org_id' => $orgId]);
    }

//New code for attendance
public function attendance($orgId, $eventId)
{  
    $post = Post::where('id', $eventId)->where('organization_id', $orgId)->first();

    if (!$post) {
        return abort(404, 'Event not found');
    }


    return view('attendance', ['post' => $post, 'orgId' => $orgId]);
}

public function storeAttendance(Request $request, $orgId, $eventId)
{
    $request->validate([
        'studentId' => 'required',
    ]);

    $attendance = Attendance::where('post_id', $eventId)->first();

    $student = EnrolledStudent::where('studentId', $request->studentId)->first();
    if (!$student) {
        if(!$attendance){
            return redirect()->back()->with('error', 'Student ID not found.');
        }
        $totalAttendanceToDisplay = $attendance->totalAttendance;
        session()->flash('totalAttendance', $totalAttendanceToDisplay);
        return redirect()->back()->with('error', 'Student ID not found.');
    }

    if (!$attendance) {
        $attendance = new Attendance();
        $attendance->post_id = $eventId;
        $attendance->totalAttendance = 1;
        $attendance->save();
    } else {
        $attendance->totalAttendance += 1;
        $attendance->save();
    }
    $totalAttendanceToDisplay = $attendance->totalAttendance;

    session()->flash('totalAttendance', $totalAttendanceToDisplay);

    return redirect()->back()->with('success', 'Attendance recorded successfully!');
}

public function deleteEvent($orgId, $eventId)
{
    $event = Post::findOrFail($eventId);
    $event->delete();

    return redirect()->route('organization.show', ['id' => $orgId]);
}

public function adminHome()
{
    $organizations = SchoolOrganization::where('status', 'approved')->get();
    return view('admin', compact('organizations'))->with('tab', 'validated');
}

public function validated()
    {
        $organizations = SchoolOrganization::whereIn('status', ['approved', 'reaccred'])->get();
        return view('admin', compact('organizations'))->with('tab', 'validated');
    }

public function notValidated()
{
    $organizations = SchoolOrganization::where('status', 'pending')->get();
    return view('admin', compact('organizations'))->with('tab', 'not-validated');
}

public function validationScreen($id)
{
    $organization = SchoolOrganization::where('id', $id)->get();
    $orgDocs = OrgRequiredDoc::where('school_org_id', $id)->get(); // Fetch documents properly
    return view('validate-org', compact('organization', 'orgDocs')); // Pass orgDocs to the view
}


public function updateStatus($id)
    {
        $org = SchoolOrganization::find($id);
        // dd($org);
        if ($org) {
            // Update the status to 'approved'
            $org->status = 'approved';
            $org->save();

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 400);
    }


    public function deleteOrganization($id)
    {
        $org = SchoolOrganization::find($id);

        if ($org) {
            $org->delete();

            return response()->json(['success' => true, 'message' => 'Organization deleted successfully!']);
        }

        return response()->json(['success' => false, 'message' => 'Organization not found!'], 404);
    }



    // CHECKING STUDENT FOR MEMBER ADD
    public function checkStudent($studentId)
    {
        // Assuming you're using the EnrolledStudent model to check
        $student = DB::table('users')->where('studentid', $studentId)->first();

        if ($student) {
            return response()->json([
                'success' => true,
                'data' => $student,
            ]);
        } else {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'No student found',
                ],
                404,
            ); // Return a 404 error if no student is found
        }
    }
    // MEMBER ADD
    public function addMember(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'studentid' => 'required|string|max:255',
            'organization_id' => 'required|integer',
            // 'payment_status' => 'nullable|string|max:20',
        ]);

        // Find the user by studentid
        $user = DB::table('users')
            ->where('studentid', $validated['studentid'])
            ->first();

        if ($user) {
            // Insert the member into the organization_members table
            DB::table('organization_members')->insert([
                'organization_id' => $validated['organization_id'],
                'member_id' => $user->id,
                // 'payment_status' => $validated['payment_status'],
                'status' => 'approved', // Default status
                'is_admin' => 0, // Default to non-admin
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Member added successfully to the organization.',
            ]);
        } else {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'No student found with the provided student ID.',
                ],
                404,
            );
        }
    }

    //DELETE MEMBER

    public function deleteMember($org_id, $member_id)
    {
        // Log the received parameters
        Log::info("Deleting member with org_id: $org_id and member_id: $member_id");

        // Check if the member exists in the organization
        $member = DB::table('organization_members')->where('organization_id', $org_id)->where('member_id', $member_id)->first();

        if (!$member) {
            Log::error("Member not found in organization. org_id: $org_id, member_id: $member_id");
            return redirect()->back()->with('error', 'Member not found.');
        }

        // Log the member details before deletion
        Log::info('Member found: ', (array) $member);

        // Perform the deletion
        DB::table('organization_members')->where('organization_id', $org_id)->where('member_id', $member_id)->delete();

        // Log deletion success
        Log::info("Member deleted successfully: org_id: $org_id, member_id: $member_id");

        return redirect()->back()->with('success', 'Member deleted successfully.');
    }

    // REACCREDITATION UPLOAD
    public function uploadRequiredDocs(Request $request)
    {
        try {
            // Validate inputs
            $validated = $request->validate([
                'school_org_id' => 'required|integer',
                'files' => 'required|array|min:1',
                'files.*' => 'file|mimes:pdf,doc,docx|max:2048', // Only pdf and doc file types allowed
                'type' => 'required|in:reaccreditation,other',
                'description' => 'nullable|string|max:255',
            ]);

            // Initialize an array to store uploaded filenames
            $uploadedFiles = [];

            // Check if the request has files
            if ($request->hasFile('files')) {
                // Loop through each uploaded file
                foreach ($request->file('files') as $file) {
                    // Generate a unique filename for each file
                    $filename = time() . '_' . $file->getClientOriginalName();
                    // Store the file in the 'uploads' directory
                    $filePath = $file->storeAs('uploads', $filename, 'public');

                    // Save each file's information in the database
                    OrgRequiredDoc::create([
                        'school_org_id' => $validated['school_org_id'],
                        'doc_filename' => $filename,
                        'type' => $validated['type'], // Save the submission type (reaccreditation or other)
                        'description' => $validated['description'], // Save the description if provided
                    ]);

                    // Add the filename to the response list
                    $uploadedFiles[] = $filename;
                }

                // Return a successful response with the uploaded files
                return response()->json([
                    'success' => true,
                    'message' => 'Files uploaded successfully.',
                    'files' => $uploadedFiles,
                ]);
            }

            // If no files are uploaded, return a failure response
            return response()->json([
                'success' => false,
                'message' => 'No files uploaded.',
            ], 400);
        } catch (ValidationException $e) {
            // Return validation errors if validation fails
            return response()->json([
                'success' => false,
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            // Return generic error if an exception occurs
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    //upload reaccred if rejected
    public function uploadReaccreditationDocument(Request $request)
    {
        // Validate the file, description, and school_org_id
        $request->validate([
            'doc_file' => 'required|file|mimes:pdf,doc,docx|max:10240', // Maximum file size 10MB
            'description' => 'nullable|string|max:255', // Description max length
            'school_org_id' => 'required|exists:school_organizations,id', // Ensure school_org_id is valid
        ]);

        try {
            // Handle file upload
            if ($request->hasFile('doc_file') && $request->file('doc_file')->isValid()) {
                // Get the uploaded file
                $file = $request->file('doc_file');
                
                // Generate a unique file name for the document
                $fileName = time() . '-' . $file->getClientOriginalName();
                
                // Store the file in the "uploads" folder (or any other folder you prefer)
                $file->storeAs('uploads', $fileName, 'public');

                // Create a new OrgRequiredDoc record with the passed school_org_id
                OrgRequiredDoc::create([
                    'school_org_id' => $request->school_org_id, // Use the passed school_org_id
                    'doc_filename' => $fileName,
                    'type' => 'reaccreditation', // Set type as 'reaccreditation'
                    'description' => $request->description, // Save the description
                ]);

                // Return success response
                return response()->json([
                    'message' => 'Document uploaded successfully!',
                    'status' => 'success',
                    'success' => true  // Indicate success
                ]);
            }

            return response()->json([
                'message' => 'Failed to upload document. Please try again.',
                'status' => 'error',
                'success' => false  // Indicate failure
            ]);
        } catch (\Exception $e) {
            // Handle any errors that may occur
            \Log::error('Document upload error: ' . $e->getMessage());  // Log error
            return response()->json([
                'message' => 'An error occurred while uploading the document. Please try again.',
                'status' => 'error',
                'error' => $e->getMessage(),
                'success' => false
            ]);
        }
    }

 
}
