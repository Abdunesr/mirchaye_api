@extends('layouts.extens')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="lg:grid lg:grid-cols-12 lg:gap-8">
        <!-- Left sidebar -->
        <div class="lg:col-span-4">
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="p-6 text-center">
                    <img id="profile-logo" src="{{ asset('images/default-party-logo.png') }}" alt="Party Logo" class="w-32 h-32 rounded-full mx-auto object-cover border-4 border-amber-100">
                    <h2 id="profile-party-name" class="mt-4 text-2xl font-bold text-gray-900"></h2>
                    <p id="profile-party-acronym" class="text-amber-600 font-medium"></p>
                    <p id="profile-slogan" class="mt-2 text-gray-600 italic"></p>
                </div>
                
                <div class="border-t border-gray-200 px-6 py-4">
                    <h3 class="text-lg font-medium text-gray-900 mb-3">Contact Information</h3>
                    <ul class="space-y-3">
                        <li class="flex items-center">
                            <i class="fas fa-envelope text-gray-400 mr-2"></i>
                            <span id="profile-email" class="text-gray-600"></span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-phone text-gray-400 mr-2"></i>
                            <span id="profile-phone" class="text-gray-600"></span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-map-marker-alt text-gray-400 mr-2"></i>
                            <span id="profile-address" class="text-gray-600"></span>
                        </li>
                    </ul>
                </div>
                
                <div class="border-t border-gray-200 px-6 py-4">
                    <h3 class="text-lg font-medium text-gray-900 mb-3">Social Media</h3>
                    <div class="flex space-x-4" id="social-links">
                        <!-- Social links will be added here -->
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Main content -->
        <div class="mt-8 lg:mt-0 lg:col-span-8">
            <div id="view-profile-content">
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-200 flex justify-between items-center">
                        <h3 class="text-lg font-medium text-gray-900">Party Information</h3>
                        <button onclick="toggleEditMode()" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-amber-600 hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                            Edit Profile
                        </button>
                    </div>
                    
                    <div class="px-6 py-5 space-y-6">
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Registration Number</h4>
                            <p id="profile-registration" class="mt-1 text-sm text-gray-900"></p>
                        </div>
                        
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Founded Year</h4>
                            <p id="profile-founded" class="mt-1 text-sm text-gray-900"></p>
                        </div>
                        
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">President</h4>
                            <div class="mt-2 flex items-center">
                                <img id="profile-president-photo" src="{{ asset('images/default-profile.png') }}" class="w-12 h-12 rounded-full object-cover mr-3">
                                <p id="profile-president-name" class="text-sm text-gray-900"></p>
                            </div>
                        </div>
                        
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Certificate</h4>
                            <div class="mt-2">
                                <a id="profile-certificate-link" href="#" target="_blank" class="text-amber-600 hover:text-amber-500 text-sm font-medium">View Certificate</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Edit Profile Form (hidden by default) -->
            <div id="edit-profile-content" class="hidden bg-white shadow rounded-lg overflow-hidden mt-8">
                <div class="px-6 py-5 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Edit Profile</h3>
                </div>
                
                <form id="profile-form" class="px-6 py-5 space-y-6">
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div>
                            <label for="party_name" class="block text-sm font-medium text-gray-700">Party Name</label>
                            <input type="text" name="party_name" id="edit-party-name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm p-2 border">
                        </div>
                        
                        <div>
                            <label for="party_acronym" class="block text-sm font-medium text-gray-700">Party Acronym</label>
                            <input type="text" name="party_acronym" id="edit-party-acronym" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm p-2 border">
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div>
                            <label for="registration_number" class="block text-sm font-medium text-gray-700">Registration Number</label>
                            <input type="text" name="registration_number" id="edit-registration-number" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm p-2 border">
                        </div>
                        
                        <div>
                            <label for="founded_year" class="block text-sm font-medium text-gray-700">Founded Year</label>
                            <input type="text" name="founded_year" id="edit-founded-year" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm p-2 border">
                        </div>
                    </div>
                    
                    <div>
                        <label for="slogan" class="block text-sm font-medium text-gray-700">Slogan</label>
                        <input type="text" name="slogan" id="edit-slogan" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm p-2 border">
                    </div>
                    
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div>
                            <label for="president_name" class="block text-sm font-medium text-gray-700">President Name</label>
                            <input type="text" name="president_name" id="edit-president-name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm p-2 border">
                        </div>
                        
                        <div>
                            <label for="president_photo_url" class="block text-sm font-medium text-gray-700">President Photo URL</label>
                            <input type="text" name="president_photo_url" id="edit-president-photo" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm p-2 border">
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div>
                            <label for="contact_email" class="block text-sm font-medium text-gray-700">Contact Email</label>
                            <input type="email" name="contact_email" id="edit-contact-email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm p-2 border">
                        </div>
                        
                        <div>
                            <label for="contact_phone" class="block text-sm font-medium text-gray-700">Contact Phone</label>
                            <input type="text" name="contact_phone" id="edit-contact-phone" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm p-2 border">
                        </div>
                    </div>
                    
                    <div>
                        <label for="headquarters_address" class="block text-sm font-medium text-gray-700">Headquarters Address</label>
                        <textarea name="headquarters_address" id="edit-headquarters-address" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm p-2 border"></textarea>
                    </div>
                    
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div>
                            <label for="facebook_url" class="block text-sm font-medium text-gray-700">Facebook URL</label>
                            <input type="url" name="facebook_url" id="edit-facebook-url" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm p-2 border">
                        </div>
                        
                        <div>
                            <label for="twitter_url" class="block text-sm font-medium text-gray-700">Twitter URL</label>
                            <input type="url" name="twitter_url" id="edit-twitter-url" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm p-2 border">
                        </div>
                    </div>
                    
                    <div>
                        <label for="logo_url" class="block text-sm font-medium text-gray-700">Logo URL</label>
                        <input type="url" name="logo_url" id="edit-logo-url" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm p-2 border">
                    </div>
                    
                    <div>
                        <label for="certificate_url" class="block text-sm font-medium text-gray-700">Certificate URL</label>
                        <input type="url" name="certificate_url" id="edit-certificate-url" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm p-2 border">
                    </div>
                    
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="toggleEditMode()" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                            Cancel
                        </button>
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-amber-600 hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Check if we're in edit mode from URL hash
        if (window.location.hash === '#edit') {
            toggleEditMode(true);
        }
        
        // Load party profile data
        fetchPartyProfile();
        
        // Form submission
        document.getElementById('profile-form').addEventListener('submit', function(e) {
            e.preventDefault();
            updatePartyProfile();
        });
    });

    function toggleEditMode(showEdit = null) {
        const viewProfile = document.getElementById('view-profile-content');
        const editProfile = document.getElementById('edit-profile-content');
        
        if (showEdit === null) {
            showEdit = editProfile.classList.contains('hidden');
        }
        
        if (showEdit) {
            viewProfile.classList.add('hidden');
            editProfile.classList.remove('hidden');
            window.location.hash = 'edit';
        } else {
            viewProfile.classList.remove('hidden');
            editProfile.classList.add('hidden');
            window.location.hash = '';
        }
    }

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
                populateProfileData(data);
            }
        } catch (error) {
            console.error('Error fetching party profile:', error);
        }
    }

    function populateProfileData(data) {
        // View mode elements
        if (data.logo_url) {
            document.getElementById('profile-logo').src = data.logo_url;
        }
        if (data.party_name) {
            document.getElementById('profile-party-name').textContent = data.party_name;
        }
        if (data.party_acronym) {
            document.getElementById('profile-party-acronym').textContent = data.party_acronym;
        }
        if (data.slogan) {
            document.getElementById('profile-slogan').textContent = `"${data.slogan}"`;
        }
        if (data.contact_email) {
            document.getElementById('profile-email').textContent = data.contact_email;
        }
        if (data.contact_phone) {
            document.getElementById('profile-phone').textContent = data.contact_phone;
        }
        if (data.headquarters_address) {
            document.getElementById('profile-address').textContent = data.headquarters_address;
        }
        if (data.registration_number) {
            document.getElementById('profile-registration').textContent = data.registration_number;
        }
        if (data.founded_year) {
            document.getElementById('profile-founded').textContent = data.founded_year;
        }
        if (data.president_name) {
            document.getElementById('profile-president-name').textContent = data.president_name;
        }
        if (data.president_photo_url) {
            document.getElementById('profile-president-photo').src = data.president_photo_url;
        }
        if (data.certificate_url) {
            document.getElementById('profile-certificate-link').href = data.certificate_url;
        } else {
            document.getElementById('profile-certificate-link').classList.add('hidden');
        }
        
        // Social links
        const socialLinksContainer = document.getElementById('social-links');
        socialLinksContainer.innerHTML = '';
        
        if (data.facebook_url) {
            socialLinksContainer.innerHTML += `
                <a href="${data.facebook_url}" target="_blank" class="text-blue-600 hover:text-blue-800">
                    <i class="fab fa-facebook fa-lg"></i>
                </a>
            `;
        }
        
        if (data.twitter_url) {
            socialLinksContainer.innerHTML += `
                <a href="${data.twitter_url}" target="_blank" class="text-blue-400 hover:text-blue-600">
                    <i class="fab fa-twitter fa-lg"></i>
                </a>
            `;
        }
        
        // Edit mode form fields
        const fields = [
            'party_name', 'party_acronym', 'registration_number', 'founded_year', 'slogan',
            'president_name', 'president_photo_url', 'contact_email', 'contact_phone',
            'headquarters_address', 'facebook_url', 'twitter_url', 'logo_url', 'certificate_url'
        ];
        
        fields.forEach(field => {
            const element = document.getElementById(`edit-${field.replace(/_/g, '-')}`);
            if (element && data[field]) {
                element.value = data[field];
            }
        });
    }

    async function updatePartyProfile() {
        try {
            const form = document.getElementById('profile-form');
            const formData = new FormData(form);
            const data = Object.fromEntries(formData.entries());
            
            const response = await fetch('/api/party/profile', {
                method: 'PUT',
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('access_token'),
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify(data)
            });

            if (response.ok) {
                const updatedData = await response.json();
                populateProfileData(updatedData);
                toggleEditMode(false);
                
                // Update the logo in the header if it was changed
                if (data.logo_url) {
                    document.getElementById('party-logo').src = data.logo_url;
                }
                
                // Show success message (you could add a toast notification here)
                alert('Profile updated successfully!');
            } else {
                const error = await response.json();
                alert(error.message || 'Failed to update profile');
            }
        } catch (error) {
            console.error('Error updating party profile:', error);
            alert('An error occurred while updating the profile');
        }
    }
</script>
@endsection