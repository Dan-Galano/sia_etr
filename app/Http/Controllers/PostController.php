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
use App\Models\Reaction;
use App\Models\Comment;

class PostController extends Controller
{
    public function edit($postId)
    {
        $postid = Post::findOrFail($postId);
        
        return view('edit_post_modal', compact('postid'));
    }
    
    public function update(Request $request, $postId)
    {
        $postid = Post::findOrFail($postId);
        $postid->content = $request->input('content');
        $postid->save();
        return redirect()->back()->with('success', 'Post updated successfully!');
    }

    
    public function delete($postId)
{
    $post = Post::findOrFail($postId);
    $post->delete();

    

    return redirect()->back()->with('success', 'Post deleted successfully.');
}


public function editWithPhoto($postId)
{
    $post = Post::with('photos')->findOrFail($postId);
    return view('edit_post_modal_with_photo', compact('post'));
}

public function updateWithPhoto(Request $request, $postId)
{
    $post = Post::findOrFail($postId);
    $post->content = $request->input('content');
    $post->save();
    $post->photos()->delete();
    
    if ($request->hasFile('photos')) {
        foreach ($request->file('photos') as $photo) {
            $filename = time() . '_' . $photo->getClientOriginalName();
            $photo->move(public_path('post-imgs'), $filename);

            PhotoPost::create([
                'post_id' => $post->id,
                'photo_filename' => $filename,
            ]);
        }
    }

    return redirect()->back()->with('success', 'Post updated successfully!');
}

public function toggleLike($postId)
{
    $post = Post::findOrFail($postId);
    $user = Auth::user();

    
    $like = Reaction::where('post_id', $post->id)->where('user_id', $user->id)->first();

    if ($like) {
        
        $like->delete();
    } else {
        
        Reaction::create([
            'post_id' => $post->id,
            'user_id' => $user->id,
            'reaction_type' => 'like',
        ]);
    }

    return redirect()->back();
}

public function showComments($postId)
{
    $post = Post::findOrFail($postId);
    $comments = $post->comments()->with('user')->latest()->get();
    return view('comments', compact('post', 'comments'));
}

public function storeComment(Request $request, $postId)
{
    $request->validate([
        'comment' => 'required|string',
    ]);

    $post = Post::findOrFail($postId);

    
    $comment = new Comment();
    $comment->post_id = $post->id;
    $comment->user_id = Auth::id();
    $comment->content = $request->input('comment');
    $comment->save();

    return redirect()->back()->with('success', 'Comment added successfully!');
}

public function showPost($postId)
{
    $post = Post::findOrFail($postId);
    $organization = $post->organization; 

    return view('post', compact('post', 'organization'));
}



public function updateEventPost(Request $request, $id)
{
    $request->validate([
        'event_title' => 'required|string',
        'content' => 'nullable|string',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after:start_date',
    ]);

    $post = Post::findOrFail($id);
    $post->update([
        'event_title' => $request->input('event_title'),
        'content' => $request->input('content'),
        'event_start_time' => $request->input('start_date'),
        'event_end_time' => $request->input('end_date'),
    ]);

    return redirect()->back()->with('success', 'Event updated successfully!');
}


public function updateEventWithPhoto(Request $request, $id)
{
    $request->validate([
        'event_title' => 'required|string',
        'content' => 'nullable|string',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after:start_date',
        'photos.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    $post = Post::findOrFail($id);
    $post->update([
        'event_title' => $request->input('event_title'),
        'content' => $request->input('content'),
        'event_start_time' => $request->input('start_date'),
        'event_end_time' => $request->input('end_date'),
    ]);

    
    $post->photos()->delete();

    if ($request->hasFile('photos')) {
        foreach ($request->file('photos') as $photo) {
            $filename = time() . '-' . $photo->getClientOriginalName();
            $photo->move(public_path('post-imgs'), $filename);

            DB::table('photo_posts')->insert([
                'post_id' => $post->id,
                'photo_filename' => $filename,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
    
    return redirect()->back()->with('success', 'Event updated successfully!');
}

}
