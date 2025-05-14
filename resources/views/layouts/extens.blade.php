<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ምርጫዬ - Political Party Platform</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="bg-gray-50">
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center">
                    <a href="/" class="text-xl font-bold text-amber-600">ምርጫዬ</a>
                </div>
                
                <div class="flex items-center space-x-4">
                    <div class="relative" id="profile-dropdown-container">
                        <button id="profile-dropdown-button" class="flex items-center space-x-2 focus:outline-none">
                            <img id="party-logo" src="{{ asset('images/default-party-logo.png') }}" alt="Party Logo" class="w-8 h-8 rounded-full object-cover">
                            <span class="hidden md:inline text-gray-700" id="party-name"></span>
                            <i class="fas fa-chevron-down text-gray-500 text-xs"></i>
                        </button>
                        
                        <div id="profile-dropdown-menu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                            <a href="#" id="view-profile-link" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">View Profile</a>
                            <a href="#" id="edit-profile-link" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Edit Profile</a>
                            <a href="#" id="logout-link" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Load party data if authenticated
            const token = localStorage.getItem('access_token');
            if (token) {
                fetchPartyProfile();
            }

            // Profile dropdown toggle
            const dropdownButton = document.getElementById('profile-dropdown-button');
            const dropdownMenu = document.getElementById('profile-dropdown-menu');
            
            dropdownButton.addEventListener('click', function() {
                dropdownMenu.classList.toggle('hidden');
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(event) {
                const isClickInside = document.getElementById('profile-dropdown-container').contains(event.target);
                if (!isClickInside) {
                    dropdownMenu.classList.add('hidden');
                }
            });

            // Logout functionality
            document.getElementById('logout-link').addEventListener('click', function(e) {
                e.preventDefault();
                logoutUser();
            });

            // View profile link
           // View profile link
document.getElementById('view-profile-link').addEventListener('click', function(e) {
    e.preventDefault();
    window.location.href = '/dashboard/profile';
});

            // Edit profile link
            document.getElementById('edit-profile-link').addEventListener('click', function(e) {
                e.preventDefault();
                window.location.href = '/party/profile#edit';
            });
        });

       async function fetchPartyProfile() {
    try {
        const response = await fetch('/api/party/profile', {
            method: 'GET',
            headers: {
                'Authorization': 'Bearer ' + localStorage.getItem('access_token'),
                'Accept': 'application/json',
            }
        });

        if (response.ok) {
            const data = await response.json();
            console.log('Profile data:', data); // Debug log
            
            if (data.logo_url) {
                // Construct the full URL by prepending your storage path
                const fullLogoUrl = `/storage/${data.logo_url}`;
                const logoElement = document.getElementById('party-logo');
                logoElement.src = fullLogoUrl;
                console.log('Image source set to:', logoElement.src); // Debug log
                
                // Add error handling in case the image fails to load
                logoElement.onerror = function() {
                    console.error('Failed to load image:', this.src);
                    this.src = '{{ asset('images/default-party-logo.png') }}';
                };
            }
            if (data.party_name) {
                document.getElementById('party-name').textContent = data.party_name;
            }
        } else {
            console.error('Failed to fetch profile:', response.status);
        }
    } catch (error) {
        console.error('Error fetching party profile:', error);
    }
}
        async function logoutUser() {
            try {
                const response = await fetch('/api/logout', {
                    method: 'POST',
                    headers: {
                        'Authorization': 'Bearer ' + localStorage.getItem('access_token'),
                        'Accept': 'application/json',
                    }
                });

                if (response.ok) {
                    localStorage.removeItem('access_token');
                    window.location.href = '/login';
                }
            } catch (error) {
                console.error('Error logging out:', error);
            }
        }
    </script>
</body>
</html>