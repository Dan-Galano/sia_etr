<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\SignupController;
use App\Http\Controllers\Auth\SigninController;
use App\Http\Controllers\OrganizerController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\OfficerController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ReportController;
use App\Models\SchoolOrganization;
use Illuminate\Support\Facades\Auth;

Route::get('/signin', function () {
    // If the user is logged in, determine their redirection path
    if (Auth::check()) {
        $user = Auth::user();

        if ($user->type === 'member') {
            // Redirect members to their home page
            return redirect()->route('member-home');
        }

        if ($user->type === 'organizer') {
            // Find the organization associated with the organizer
            $organization = SchoolOrganization::where('admin_id', $user->id)->first();

            if (!$organization) {
                // If not an admin, check if the organizer is a member of an organization
                $organization = $user->schoolOrganizations()->first();
            }

            if ($organization) {
                // Redirect to the organizer's organization page
                return redirect()->route('organization.show', ['id' => $organization->id]);
            }

            // If no organization is found, redirect to a fallback route
            return redirect('/')->withErrors(['message' => 'No organization found for the user']);
        }
    }

    // If not authenticated, show the signin form
    return view('auth.signin');
})->name('signin');

Route::get('/signup', function () {
    // If the user is logged in, determine their redirection path
    if (Auth::check()) {
        $user = Auth::user();

        if ($user->type === 'member') {
            // Redirect members to their home page
            return redirect()->route('member-home');
        }
 
        if ($user->type === 'organizer') {
            // Find the organization associated with the organizer
            $organization = SchoolOrganization::where('admin_id', $user->id)->first();

            if (!$organization) {
                // If not an admin, check if the organizer is a member of an organization
                $organization = $user->schoolOrganizations()->first();
            }

            if ($organization) {
                // Redirect to the organizer's organization page
                return redirect()->route('organization.show', ['id' => $organization->id]);
            }

            // If no organization is found, redirect to a fallback route
            return redirect('/')->withErrors(['message' => 'No organization found for the user']);
        }
    }

    // If not authenticated, show the signup form
    return view('auth.signup');
})->name('signup');


Route::post('/signup/student', [SignupController::class, 'signupStudent'])->name('signupStudent');
Route::post('/signup/organization', [SignupController::class, 'signupOrganization'])->name('signupOrganization');


Route::get('/', [SigninController::class, 'showLanding'])->name('landing');

Route::post('/signin', [SigninController::class, 'signin']);



Route::get('/organizer-home', function () {
    $hasSchoolOrg = app(GeneralController::class)->checkSchoolOrg()->original['result'];
    return view('organizer-home', compact('hasSchoolOrg'));
})->middleware(['auth', 'redirect.home'])->name('organizer-home');


Route::get('/organizer-home/all', function () {
    // Get all organizations and the current user's organization name (if applicable)
    $data = app(GeneralController::class)->getSchoolOrganizations();
    $organizations = $data['organizations'];
    $orgname = $data['orgname'] ?? null; // Handle cases where orgname is not set

    // Return the view with all data
    return view('organizer-home-all', compact('organizations', 'orgname'));
})->name('organizer-home-all');


Route::get('/member-home', function () {
    $hasMembership = app(GeneralController::class)->checkMembership();
    $organizations = app(GeneralController::class)->getSchoolOrganizations();
    $organizationsM = app(GeneralController::class)->getSchoolOrganizationsMember();
    $organizationsNotMembers = app(GeneralController::class)->getSchoolOrganizationsNotMember(); 
    return view('member-home', compact('hasMembership', 'organizations', 'organizationsM', 'organizationsNotMembers'));
})->middleware(['auth', 'redirect.home'])->name('member-home');

Route::get('/member-home/all', function () {
    // Fetch necessary data for the member's home page
    $hasMembership = app(GeneralController::class)->checkMembership();
    $data = app(GeneralController::class)->getSchoolOrganizations();
    $organizations = $data['organizations'];
    $organizationsM = app(GeneralController::class)->getSchoolOrganizationsMember();
    $organizationsNotMembers = app(GeneralController::class)->getSchoolOrganizationsNotMember();

    // Return the view with all data
    return view('member-home-all', compact('hasMembership', 'organizations', 'organizationsM', 'organizationsNotMembers'));
})->middleware(['auth', 'redirect.home'])->name('member-home-all');

// Admin Dashboard
Route::get('/admin', [GeneralController::class, 'adminHome'])
    ->middleware(['auth', 'redirect.home'])
    ->name('admin-home');

// Admin Organization Routes
Route::get('/admin/validated', [GeneralController::class, 'validated'])->name('organizations.validated');
Route::get('/admin/not-validated', [GeneralController::class, 'notValidated'])->name('organizations.not-validated');
Route::get('/admin/not-validated/{orgId}', [GeneralController::class, 'validationScreen'])->name('organizations.validation');


Route::post('/update-status/{id}', [GeneralController::class, 'updateStatus']);
Route::delete('/delete-organization/{id}', [GeneralController::class, 'deleteOrganization']);

Route::post('/organizations', [GeneralController::class, 'storeOrganization'])->name('organizations.store');


Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');




Route::get('/organization/{id}', [GeneralController::class, 'showOrg'])->name('organization.show');



Route::get('/organization/{id}/create-post', [GeneralController::class, 'createPost'])->name('posts.create');
Route::post('/organization/{id}/create-post', [GeneralController::class, 'storePost'])->name('posts.store');




Route::get('post/{postId}/edit', [PostController::class, 'edit'])->name('post.edit');
Route::put('post/{postId}', [PostController::class, 'update'])->name('post.update');
Route::get('post/{postId}/editWithPhoto', [PostController::class, 'editWithPhoto'])->name('post.editWithPhoto');
Route::put('post/{postId}/updateWithPhoto', [PostController::class, 'updateWithPhoto'])->name('post.updateWithPhoto');



Route::get('post/{postId}/delete', [PostController::class, 'delete'])->name('post.delete');



Route::post('/posts/{post}/like', [PostController::class, 'toggleLike'])->name('posts.like');




Route::get('/posts/{post}/comments', [PostController::class, 'showComments'])->name('posts.comments');



Route::post('/posts/{post}/comments', [PostController::class, 'storeComment'])->name('comments.store');




Route::put('/events/{id}', [PostController::class, 'updateEventPost'])->name('events.update');
Route::put('/eventwithphoto/{id}', [PostController::class, 'updateEventWithPhoto'])->name('eventwithphoto.update');


Route::put('/organization/{id}/toggle-member/{member_id}', [GeneralController::class, 'toggleMember'])->name('organization.toggleMember');


Route::get('/profile', [GeneralController::class, 'showProfile'])->name('profile.show');
Route::put('/profile/{id}/update',[GeneralController::class, 'updateProfile'])->name('profile.update');

Route::post('/profile/update-password', [GeneralController::class, 'updatePassword'])->name('profile.updatePassword');



Route::post('/membership', [MemberController::class, 'store'])->name('membership.store');


// student checking
Route::get('/check-student/{studentid}', [GeneralController::class, 'checkStudent']);

// student adding
Route::post('organization/add-member', [GeneralController::class, 'addMember']);

//student delete
Route::delete('/organization/{org_id}/member/{member_id}', [MemberController::class, 'deleteMember'])->name('organization.deleteMember');



Route::get('/organization/{org_id}/chat', [GeneralController::class, 'loadChatView'])->name('chat.view');
Route::post('/organization/{org_id}/chat/send', [GeneralController::class, 'sendMessage'])->name('chat.send');

Route::post('/organization/{id}/toggleJoin', [MemberController::class, 'toggleJoin'])->name('organization.toggleJoin');

Route::post('/officers', [OfficerController::class, 'store'])->name('officer.add');
Route::put('/officers/{id}', [OfficerController::class, 'delete'])->name('officer.delete');

Route::post('/reports', [ReportController::class, 'store'])->name('reports.store');
Route::get('/export-reports-pdf/{orgId}', [ReportController::class, 'exportReportsPDF'])->name('export.reports.pdf');
Route::get('/export-reports-csv/{orgId}', [ReportController::class, 'exportReportsCSV'])->name('export.reports.csv');

//New code for attendance
Route::get('organization/{org_id}/attendance/{event_id}', [GeneralController::class, 'attendance'])->name('event.attendance');
Route::post('organization/{org_id}/attendance/{event_id}/store', [GeneralController::class, 'storeAttendance'])->name('attendance.store');
Route::get('organization/{org_id}/events/{event_id}/delete', [GeneralController::class, 'deleteEvent'])->name('delete.event');


//accreditation
Route::post('/upload-required-docs', [GeneralController::class, 'uploadRequiredDocs'])->name('upload.required.docs');

//accreditation if rejected 
Route::post('/org/required-doc/store', [GeneralController::class, 'uploadReaccreditationDocument'])->name('org.requiredDoc.store');
