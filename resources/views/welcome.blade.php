
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Create Post</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Create New Post</h1>
        
        <!-- Login/Session Status -->
        <div id="auth-status" class="mb-3">
            @if(auth()->check())
                <div class="alert alert-success">
                    Logged in as: {{ auth()->user()->name }}
                    <button id="logout-btn" class="btn btn-sm btn-danger ms-3">Logout</button>
                </div>
            @else
                <div class="alert alert-warning">
                    You need to login first!
                    <a href="/login" class="btn btn-sm btn-primary ms-3">Login</a>
                </div>
            @endif
        </div>

        <!-- Success/Error Messages -->
        <div id="message-container">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <!-- Form -->
        <form id="post-form" enctype="multipart/form-data">
            @csrf
            
            <!-- Title -->
            <div class="mb-3">
                <label for="title" class="form-label">Title*</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>

            <!-- Content -->
            <div class="mb-3">
                <label for="content" class="form-label">Content*</label>
                <textarea class="form-control" id="content" name="content" rows="5" required></textarea>
            </div>

            <!-- Post Type -->
             <div class="mb-3">
                <label for="post_type" class="form-label">Post Type*</label>
                <select class="form-select" id="post_type" name="post_type" required>
                    <option value="">Select Post Type</option>
                    <option value="campaign">Campaign</option>
                    <option value="news" selected>News</option>
                    <option value="event">Event</option>
                    <option value="policy">Policy</option>
                </select>
            </div>
<!-- Image Upload -->
            <div class="mb-3">
                <label for="image" class="form-label">Post Image (Optional)</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*">
            </div>
<div class="mb-3">
    <label for="pdf_file" class="form-label">PDF File (Optional)</label>
    <input type="file" class="form-control" id="pdf_file" name="pdf_file" accept=".pdf">
</div>
            <!-- Attachments (Dynamic Fields) -->
            <div class="mb-3">
                <label class="form-label">Attachments (Optional)</label>
                <div id="attachments-container">
                    <div class="attachment-group mb-2">
                        <div class="row g-2">
                            <div class="col-md-6">
                                <input type="url" class="form-control" name="attachments[0][file_url]" placeholder="File URL (e.g., https://example.com/file.pdf)">
                            </div>
                            <div class="col-md-4">
                                <select class="form-select" name="attachments[0][file_type]">
                                    <option value="pdf">PDF</option>
                                    <option value="image">Image</option>
                                    <option value="video">Video</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-danger btn-sm" onclick="removeAttachment(this)">Remove</button>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-secondary btn-sm mt-2" onclick="addAttachment()">+ Add Attachment</button>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary" id="submit-btn">Create Post</button>
        </form>
    </div>

    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
                <div class="attachment-group mb-2">
                    <div class="row g-2">
                        <div class="col-md-6">
                            <input type="url" class="form-control" name="attachments[${attachmentCounter}][file_url]" placeholder="File URL">
                        </div>
                        <div class="col-md-4">
                            <select class="form-select" name="attachments[${attachmentCounter}][file_type]">
                                <option value="pdf">PDF</option>
                                <option value="image">Image</option>
                                <option value="video">Video</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-danger btn-sm" onclick="removeAttachment(this)">Remove</button>
                        </div>
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
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Creating...';
            
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
                        'Authorization': Bearer ${getAuthToken()}
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
                <div class="alert alert-${type} alert-dismissible fade show">
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `;
        }
    </script>
</body>
</html>