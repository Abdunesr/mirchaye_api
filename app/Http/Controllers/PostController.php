<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with(['user.politicalParty', 'attachments'])->latest()->get();
        return response()->json($posts);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'post_type' => 'required|in:campaign,news,event,policy',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                  'pdf_file' => 'nullable|file|mimes:pdf|max:5120',

            'attachments' => 'nullable|array',
            'attachments.*.file_url' => 'required|url',
            'attachments.*.file_type' => 'required|in:image,video,pdf',
        ]);

        $data = [
            'user_id' => auth()->id(),
            'title' => $request->title,
            'content' => $request->content,
            'post_type' => $request->post_type,
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('posts', 'public');
        }
  // Add PDF file handling
   if ($request->hasFile('pdf_file')) {
        $pdfPath = $request->file('pdf_file')->store('pdfs', 'public');
        $data['pdf_file'] = $pdfPath; 
    }
        $post = Post::create($data);

        foreach ($request->attachments ?? [] as $attachment) {
            $post->attachments()->create([
                'file_url' => $attachment['file_url'],
                'file_type' => $attachment['file_type'],
            ]);
        }

        return response()->json($post->load(['attachments']), 201);
    }

    public function show(Post $post)
    {
        return response()->json($post->load(['user.politicalParty', 'attachments']));
    }

    public function update(Request $request, Post $post)
    {
        if ($post->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'title' => 'sometimes|string|max:255',
            'content' => 'sometimes|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['title', 'content']);

        if ($request->hasFile('image')) {
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $data['image'] = $request->file('image')->store('posts', 'public');
        }

        $post->update($data);

        return response()->json($post->load(['attachments']));
    }

    public function destroy(Post $post)
    {
        if ($post->user_id !== auth()->id() && !auth()->user()->isNebe()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        $post->attachments()->delete();
        $post->delete();

        return response()->json(['message' => 'Post deleted successfully']);
    }
}
