@extends('layouts.extens')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Create Post</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-b from-gray-50 to-white">
    <main class="container mx-auto px-6 py-24 flex justify-center">
        <div class="w-full max-w-2xl">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Create New Post</h1>
                <p class="text-gray-600">Share your content with the community</p>
            </div>

            <!-- Auth Status -->
            <div id="auth-status" class="mb-6">
                @if(auth()->check())
                    <div class="rounded-md bg-green-50 p-4 text-green-800 text-sm font-medium">
                        Logged in as: {{ auth()->user()->name }}
                        <button id="logout-btn" class="ml-3 text-sm font-medium text-green-700 hover:text-green-600">
                            Logout
                        </button>
                    </div>
                @else
                    <div class="rounded-md bg-yellow-50 p-4 text-yellow-800 text-sm font-medium">
                        You need to login first!
                        <a href="/login" class="ml-3 text-sm font-medium text-yellow-700 hover:text-yellow-600">
                            Login
                        </a>
                    </div>
                @endif
            </div>

            <!-- Messages -->
            <div id="message-container" class="mb-6">
                @if(session('success'))
                    <div class="rounded-md bg-green-50 p-4 text-green-800 text-sm font-medium">
                        {{ session('success') }}
                    </div>
                @endif
                @if($errors->any())
                    <div class="rounded-md bg-red-50 p-4 text-red-800 text-sm font-medium">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            <!-- Form -->
            <form id="post-form" enctype="multipart/form-data" class="space-y-6">
                @csrf
                
                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">Title*</label>
                    <input 
                        type="text" 
                        id="title" 
                        name="title" 
                        required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm p-2 border"
                    >
                </div>

                <!-- Content -->
                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700">Content*</label>
                    <textarea 
                        id="content" 
                        name="content" 
                        rows="5" 
                        required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm p-2 border"
                    ></textarea>
                </div>

                <!-- Post Type -->
                <div>
                    <label for="post_type" class="block text-sm font-medium text-gray-700">Post Type*</label>
                    <select 
                        id="post_type" 
                        name="post_type" 
                        required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm p-2 border"
                    >
                        <option value="">Select Post Type</option>
                        <option value="campaign">Campaign</option>
                        <option value="news" selected>News</option>
                        <option value="event">Event</option>
                        <option value="policy">Policy</option>
                    </select>
                </div>

                <!-- Image Upload -->
                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700">Post Image (Optional)</label>
                    <input 
                        type="file" 
                        id="image" 
                        name="image" 
                        accept="image/*"
                        class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100"
                    >
                </div>

                <!-- Attachments -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Attachments (Optional)</label>
                    <div id="attachments-container" class="mt-2 space-y-2">
                        <div class="attachment-group">
                            <div class="flex space-x-2">
                                <div class="flex-grow">
                                    <input 
                                        type="url" 
                                        name="attachments[0][file_url]" 
                                        placeholder="File URL (e.g., https://example.com/file.pdf)"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm p-2 border"
                                    >
                                </div>
                                <div class="w-32">
                                    <select 
                                        name="attachments[0][file_type]"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm p-2 border"
                                    >
                                        <option value="pdf">PDF</option>
                                        <option value="image">Image</option>
                                        <option value="video">Video</option>
                                    </select>
                                </div>
                                <button 
                                    type="button" 
                                    onclick="removeAttachment(this)"
                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-red-700 bg-red-100 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                                >
                                    Remove
                                </button>
                            </div>
                        </div>
                    </div>
                    <button 
                        type="button" 
                        onclick="addAttachment()"
                        class="mt-2 inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-amber-700 bg-amber-100 hover:bg-amber-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500"
                    >
                        + Add Attachment
                    </button>
                </div>

                <!-- Submit Button -->
                <div>
                    <button
                        type="submit"
                        id="submit-btn"
                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-amber-600 hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500"
                    >
                        Create Post
                    </button>
                </div>
            </form>
        </div>
    </main>

    <script>
        // Get token from localStorage or meta tag
        function getAuthToken() {
            // Check localStorage first
            const storedToken = localStorage.getItem('sanctum_token');
            if (storedToken) {
                return storedToken;
            }
            
            // Check if user is authenticated via session
            return document.querySelector('meta[name="csrf-token"]')?.content;
        }

        // Add new attachment field
        let attachmentCounter = 1;
        function addAttachment() {
            const container = document.getElementById('attachments-container');
            const newAttachment = `
                <div class="attachment-group">
                    <div class="flex space-x-2">
                        <div class="flex-grow">
                            <input 
                                type="url" 
                                name="attachments[${attachmentCounter}][file_url]" 
                                placeholder="File URL"
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm p-2 border"
                            >
                        </div>
                        <div class="w-32">
                            <select 
                                name="attachments[${attachmentCounter}][file_type]"
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm p-2 border"
                            >
                                <option value="pdf">PDF</option>
                                <option value="image">Image</option>
                                <option value="video">Video</option>
                            </select>
                        </div>
                        <button 
                            type="button" 
                            onclick="removeAttachment(this)"
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-red-700 bg-red-100 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                        >
                            Remove
                        </button>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', newAttachment);
            attachmentCounter++;
        }

        // Remove attachment field
        function removeAttachment(button) {
            button.closest('.attachment-group').remove();
        }

        // Handle form submission
        document.getElementById('post-form').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const submitBtn = document.getElementById('submit-btn');
            submitBtn.disabled = true;
            submitBtn.innerHTML = `
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Creating...
            `;
            
            const formData = new FormData(this);
            const token = getAuthToken();
            
            try {
                const response = await fetch('/api/posts', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': `Bearer ${token}`
                    },
                    body: formData
                });
                
                const data = await response.json();
                
                if (response.ok) {
                    showMessage('Post created successfully!', 'success');
                    this.reset();
                } else {
                    showMessage(data.message || 'Error creating post', 'danger');
                    if (data.errors) {
                        const errors = Object.values(data.errors).flat();
                        showMessage(errors.join('<br>'), 'danger');
                    }
                }
            } catch (error) {
                showMessage('Network error: ' + error.message, 'danger');
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerHTML = 'Create Post';
            }
        });

        // Handle logout
        document.getElementById('logout-btn')?.addEventListener('click', async function() {
            try {
                const response = await fetch('/api/logout', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': `Bearer ${getAuthToken()}`
                    }
                });
                
                if (response.ok) {
                    localStorage.removeItem('sanctum_token');
                    window.location.reload();
                }
            } catch (error) {
                showMessage('Logout failed: ' + error.message, 'danger');
            }
        });

        // Show message
        function showMessage(message, type) {
            const container = document.getElementById('message-container');
            container.innerHTML = `
                <div class="rounded-md bg-${type}-50 p-4 text-${type}-800 text-sm font-medium">
                    ${message}
                </div>
            `;
        }
    </script>
</body>
</html>
@endsection
