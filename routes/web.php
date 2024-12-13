<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\SignupController;
use App\Http\Controllers\Auth\SigninController;
use App\Http\Controllers\OrganizerController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ReportController;


Route::get('/signup', [SignupController::class, 'showSignupForm'])->name('signup');
Route::post('/signup', [SignupController::class, 'signup']);


Route::get('/', [SigninController::class, 'showLanding'])->name('landing');
Route::get('/signin', [SigninController::class, 'showSigninForm'])->middleware('guest')->name('signin');
Route::post('/signin', [SigninController::class, 'signin']);



Route::get('/organizer-home', function () {
    $hasSchoolOrg = app(GeneralController::class)->checkSchoolOrg()->original['result'];
    return view('organizer-home', compact('hasSchoolOrg'));
})->middleware(['auth', 'redirect.home'])->name('organizer-home');


Route::get('/organizer-home/all', function () {
    $organizations = app(GeneralController::class)->getSchoolOrganizations();
    $organizationsM = app(GeneralController::class)->getSchoolOrganizationsMember(); 
    return view('organizer-home-all', compact('organizations', 'organizationsM'));
})->middleware(['auth', 'redirect.home'])->name('organizer-home-all');


Route::get('/member-home', function () {
    $hasMembership = app(GeneralController::class)->checkMembership();
    $organizations = app(GeneralController::class)->getSchoolOrganizations();
    $organizationsM = app(GeneralController::class)->getSchoolOrganizationsMember();
    $organizationsNotMembers = app(GeneralController::class)->getSchoolOrganizationsNotMember(); 
    return view('member-home', compact('hasMembership', 'organizations', 'organizationsM', 'organizationsNotMembers'));
})->middleware(['auth', 'redirect.home'])->name('member-home');

Route::get('/member-home/all', function () {
    $hasMembership = app(GeneralController::class)->checkMembership();
    $organizations = app(GeneralController::class)->getSchoolOrganizations();
    $organizationsM = app(GeneralController::class)->getSchoolOrganizationsMember();
    $organizationsNotMembers = app(GeneralController::class)->getSchoolOrganizationsNotMember(); 
    return view('member-home-all', compact('hasMembership', 'organizations', 'organizationsM', 'organizationsNotMembers'));
})->middleware(['auth', 'redirect.home'])->name('member-home-all');




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




Route::get('/organization/{org_id}/chat', [GeneralController::class, 'loadChatView'])->name('chat.view');
Route::post('/organization/{org_id}/chat/send', [GeneralController::class, 'sendMessage'])->name('chat.send');

Route::post('/organization/{id}/toggleJoin', [MemberController::class, 'toggleJoin'])->name('organization.toggleJoin');


Route::post('/reports', [ReportController::class, 'store'])->name('reports.store');
Route::get('/export-reports-pdf/{orgId}', [ReportController::class, 'exportReportsPDF'])->name('export.reports.pdf');
Route::get('/export-reports-csv/{orgId}', [ReportController::class, 'exportReportsCSV'])->name('export.reports.csv');
