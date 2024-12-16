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
use Illuminate\Validation\ValidationException;

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
    $organization = $orgid;  // Same variable for consistency
    $orgname = $orgid->orgname;
    $coverphoto = $orgid->coverphoto;

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
    $organization->load(['posts' => function ($query) {
        $query->withCount(['reactions', 'comments'])->orderBy('created_at', 'desc')->with('comments.user');
    }]);

    // Fetch organization members
    $members = DB::table('organization_members')
        ->join('users', 'organization_members.member_id', '=', 'users.id')
        ->where('organization_members.organization_id', $organization->id)
        ->orderBy('organization_members.created_at', 'desc')
        ->select('users.id', 'users.photo', 'users.studentid', 'users.firstname', 'users.middlename', 'users.lastname', 'users.email', 'organization_members.status')
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
            $isMember = $isAdmin;  // Check if the user is the admin
        }
    }

    // Fetch reports for the organization
    $reports = Report::where('from_organization_id', $organization->id)
        ->with(['reportedUser', 'reporter'])
        ->get();

    // Pass the variables to the view, including $organizations
    return view('organization-dashboard', compact('orgid', 'orgname', 'coverphoto', 'organization', 'photos', 'members', 'isMember', 'reports', 'organizations'));
}

    public function toggleMember($id, $member_id)
    {
        $member = DB::table('organization_members')
            ->where('organization_id', $id)
            ->where('member_id', $member_id)
            ->first();

        if ($member) {
            $newStatus = $member->status === 'approved' ? 'rejected' : 'approved';
            DB::table('organization_members')
                ->where('organization_id', $id)
                ->where('member_id', $member_id)
                ->update(['status' => $newStatus]);
        }

        return redirect("/organization/{$id}");
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

        $post->save();  // Save the post first

        // Save associated photos for the post
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photoFile) {
                // Sanitize filename to avoid issues with special characters
                $photoFilename = time() . '_' . preg_replace('/[^a-zA-Z0-9-_\.]/', '', $photoFile->getClientOriginalName());

                // Use Laravel's store method to move the file to 'public/post-imgs' directory
                // Make sure the file is stored in the 'public' disk for easy access via URL
                $path = $photoFile->storeAs('public/post-imgs', $photoFilename); // Store in 'public/post-imgs'

                // Create a new PhotoPost record for each uploaded photo
                PhotoPost::create([
                    'post_id' => $post->id,  // Associate the photo with the current post
                    'photo_filename' => $photoFilename,  // Store the file name
                ]);
            }
        }

        return $post;
    };

    // Create the post for the primary organization
    $createPost($id, $request->taggedOrg_id);

    // Create the post for the tagged organization if taggedOrg_id is provided and is different from the primary organization
    if ($request->taggedOrg_id && $request->taggedOrg_id != $id) {
        // Set the taggedOrg_id for the primary organization in the tagged organization’s post
        $createPost($request->taggedOrg_id, $id);
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
             $orgOwnedByUser = $user->schoolOrganizations()->where('admin_id', $user->id)->first();
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
        return $user->schoolOrganizations()->where('admin_id', $user->id)->get();
    } elseif ($user->type === 'member') {
        // Return organizations the member belongs to
        return $user->organizationsMember()
            ->wherePivot('status', 'approved')
            ->orderBy('organization_members.created_at', 'desc')
            ->get();
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
    
    $chats = Chat::where('organization_id', $orgId)
                 ->orderBy('created_at', 'asc')
                 ->with('user') 
                 ->get();
    
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
}


