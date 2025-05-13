@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-gray-50 to-white">
    <main class="container mx-auto px-6 py-24 flex justify-center">
        <div class="w-full max-w-2xl"> <!-- Increased width for better form layout -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Join ምርጫዬ</h1>
                <p class="text-gray-600">Create your political party account</p>
            </div>

            <!-- Enhanced Message Displays -->
            <div id="error-message" class="hidden rounded-md bg-red-50 p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800" id="error-text"></h3>
                    </div>
                </div>
            </div>

            <div id="success-message" class="hidden rounded-md bg-green-50 p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-green-800" id="success-text"></h3>
                    </div>
                </div>
            </div>

            <form onsubmit="registerUser(event)" class="space-y-6" id="register-form" enctype="multipart/form-data" method="POST">
                @csrf
                
                <!-- User Information Section -->
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">Representative Information</h2>
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <!-- Name Field -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                            <input
                                id="name"
                                name="name"
                                type="text"
                                required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm p-2 border"
                            >
                            <p class="mt-1 text-xs text-red-600 hidden" id="name-error"></p>
                        </div>
                        
                        <!-- Email Field -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                            <input
                                id="email"
                                name="email"
                                type="email"
                                autocomplete="email"
                                required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm p-2 border"
                            >
                            <p class="mt-1 text-xs text-red-600 hidden" id="email-error"></p>
                        </div>
                        
                        <!-- Password Field -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                            <input
                                id="password"
                                name="password"
                                type="password"
                                autocomplete="new-password"
                                required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm p-2 border"
                            >
                            <p class="mt-1 text-xs text-red-600 hidden" id="password-error"></p>
                        </div>
                        
                        <!-- Confirm Password Field -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                            <input
                                id="password_confirmation"
                                name="password_confirmation"
                                type="password"
                                autocomplete="new-password"
                                required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm p-2 border"
                            >
                        </div>
                    </div>
                </div>

                <!-- Party Information Section -->
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">Party Information</h2>
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <!-- Party Name -->
                        <div>
                            <label for="party_name" class="block text-sm font-medium text-gray-700">Party Name</label>
                            <input
                                id="party_name"
                                name="party_name"
                                type="text"
                                required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm p-2 border"
                            >
                            <p class="mt-1 text-xs text-red-600 hidden" id="party_name-error"></p>
                        </div>
                        
                        <!-- Party Acronym -->
                        <div>
                            <label for="party_acronym" class="block text-sm font-medium text-gray-700">Party Acronym</label>
                            <input
                                id="party_acronym"
                                name="party_acronym"
                                type="text"
                                required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm p-2 border"
                            >
                            <p class="mt-1 text-xs text-red-600 hidden" id="party_acronym-error"></p>
                        </div>
                        
                        <!-- President Name -->
                        <div>
                            <label for="president_name" class="block text-sm font-medium text-gray-700">President Name</label>
                            <input
                                id="president_name"
                                name="president_name"
                                type="text"
                                required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm p-2 border"
                            >
                            <p class="mt-1 text-xs text-red-600 hidden" id="president_name-error"></p>
                        </div>
                        
                        <!-- Registration Number -->
                        <div>
                            <label for="registration_number" class="block text-sm font-medium text-gray-700">Registration Number</label>
                            <input
                                id="registration_number"
                                name="registration_number"
                                type="text"
                                required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm p-2 border"
                            >
                            <p class="mt-1 text-xs text-red-600 hidden" id="registration_number-error"></p>
                        </div>
                        
                        <!-- Description -->
                        <div class="sm:col-span-2">
                            <label for="description" class="block text-sm font-medium text-gray-700">Party Description</label>
                            <textarea
                                id="description"
                                name="description"
                                rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm p-2 border"
                            ></textarea>
                        </div>
                    </div>
                </div>

                <!-- Documents Section -->
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">Party Documents</h2>
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <!-- Certificate Upload -->
                        <div>
                            <label for="certificate" class="block text-sm font-medium text-gray-700">Registration Certificate (JPEG/PNG, max 2MB)</label>
                            <input
                                id="certificate"
                                name="certificate"
                                type="file"
                                required
                                accept="image/jpeg,image/png"
                                class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100"
                            >
                            <p class="mt-1 text-xs text-red-600 hidden" id="certificate-error"></p>
                            <p class="mt-1 text-xs text-gray-500">Upload a clear scan of your party registration certificate</p>
                        </div>
                        
                        <!-- Logo Upload -->
                        <div>
                            <label for="logo" class="block text-sm font-medium text-gray-700">Party Logo (JPEG/PNG, max 2MB)</label>
                            <input
                                id="logo"
                                name="logo"
                                type="file"
                                required
                                accept="image/jpeg,image/png"
                                class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100"
                            >
                            <p class="mt-1 text-xs text-red-600 hidden" id="logo-error"></p>
                            <p class="mt-1 text-xs text-gray-500">Upload your party's official logo</p>
                        </div>
                    </div>
                </div>

                <!-- Terms Agreement -->
                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <input
                            id="terms"
                            name="terms"
                            type="checkbox"
                            required
                            class="focus:ring-amber-500 h-4 w-4 text-amber-600 border-gray-300 rounded"
                        >
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="terms" class="font-medium text-gray-700">I agree to the <a href="#" class="text-amber-600 hover:text-amber-500">Terms of Service</a> and <a href="#" class="text-amber-600 hover:text-amber-500">Privacy Policy</a></label>
                    </div>
                </div>
                <p class="mt-1 text-xs text-red-600 hidden" id="terms-error"></p>

                <!-- Submit Button -->
                <div>
                    <button
                        type="submit"
                        id="submit-button"
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-amber-600 hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition-colors duration-300"
                    >
                        <span id="button-text">Register Party</span>
                        <svg id="spinner" class="hidden animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </button>
                </div>
            </form>

            <div class="mt-6 text-center">
                <p class="text-gray-600">
                    Already have an account?
                    <a href="{{ route('login') }}" class="text-amber-600 hover:underline font-medium">Log in</a>
                </p>
            </div>
        </div>
    </main>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize form validation
    const form = document.getElementById('register-form');
    if (form) {
        form.addEventListener('submit', function(e) {
            if (typeof registerUser === 'function') {
                registerUser(e);
            }
        });
    }
});

async function registerUser(event) {
    event.preventDefault();
    
    // Reset all error messages and UI states
    resetFormErrors();
    document.getElementById('error-message').classList.add('hidden');
    document.getElementById('success-message').classList.add('hidden');
    
    // Set loading state
    const submitButton = document.getElementById('submit-button');
    const buttonText = document.getElementById('button-text');
    const spinner = document.getElementById('spinner');
    
    submitButton.disabled = true;
    buttonText.textContent = 'Processing...';
    spinner.classList.remove('hidden');

    try {
        const form = document.getElementById('register-form');
        const formData = new FormData(form);
        
        // Debug: Log form data
        for (let [key, value] of formData.entries()) {
            console.log(`${key}: ${value instanceof File ? value.name : value}`);
        }
        
        const response = await fetch("/api/register", {
            method: "POST",
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            },
            body: formData,
        });

        const data = await response.json();
        console.log('API Response:', data);

        if (response.ok) {
            // Show success message
            document.getElementById('success-text').textContent = 
                data.message || "Registration successful! Your account is pending approval.";
            document.getElementById('success-message').classList.remove('hidden');
            
            // Reset form
            form.reset();
            
            // Redirect after delay
            setTimeout(() => {
                window.location.href = "/login";
            }, 3000);
        } else {
            // Handle validation errors
            if (data.errors) {
                displayFormErrors(data.errors);
            }
            
            // Show general error message
            document.getElementById('error-text').textContent = 
                data.message || "Please correct the errors and try again.";
            document.getElementById('error-message').classList.remove('hidden');
            
            // Scroll to first error
            document.querySelector('[id$="-error"]:not(.hidden)')?.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });
        }
    } catch (error) {
        console.error('Registration error:', error);
        document.getElementById('error-text').textContent = 
            "Network error. Please check your connection and try again.";
        document.getElementById('error-message').classList.remove('hidden');
    } finally {
        // Reset button state
        submitButton.disabled = false;
        buttonText.textContent = 'Register Party';
        spinner.classList.add('hidden');
    }
}

function resetFormErrors() {
    // Hide all error messages
    document.querySelectorAll('[id$="-error"]').forEach(el => {
        el.classList.add('hidden');
    });
    
    // Remove error classes from inputs
    document.querySelectorAll('.border-red-500').forEach(el => {
        el.classList.remove('border-red-500');
        el.classList.add('border-gray-300');
    });
}

function displayFormErrors(errors) {
    resetFormErrors();
    
    // Loop through errors and display them
    for (const [field, messages] of Object.entries(errors)) {
        const errorElement = document.getElementById(`${field}-error`);
        const inputElement = document.getElementById(field);
        
        if (errorElement && inputElement) {
            errorElement.textContent = Array.isArray(messages) ? messages.join(' ') : messages;
            errorElement.classList.remove('hidden');
            
            inputElement.classList.remove('border-gray-300');
            inputElement.classList.add('border-red-500');
        }
    }
}
</script>
@endsection