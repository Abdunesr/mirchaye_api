@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-gray-50 to-white">
    <main class="container mx-auto px-6 py-24 flex justify-center">
        <div class="w-full max-w-md">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Welcome back</h1>
                <p class="text-gray-600">Log in to your ምርጫዬ account</p>
            </div>

            <div id="error-message" class="hidden rounded-md bg-red-50 p-4 mb-6 text-red-800 text-sm font-medium"></div>
            <div id="success-message" class="hidden rounded-md bg-green-50 p-4 mb-6 text-green-800 text-sm font-medium"></div>

            <form onsubmit="loginUser(event)" class="space-y-6" id="login-form">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        autocomplete="email"
                        required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm p-2 border"
                    >
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        autocomplete="current-password"
                        required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm p-2 border"
                    >
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center text-sm text-gray-900">
                        <input type="checkbox" class="h-4 w-4 rounded border-gray-300 text-amber-600 focus:ring-amber-500">
                        <span class="ml-2">Remember me</span>
                    </label>
                    <a href="{{ route('password.request') }}" class="text-sm text-amber-600 hover:text-amber-500">Forgot password?</a>
                </div>

                <div>
                    <button
                        type="submit"
                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-amber-600 hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500"
                    >
                        Log in
                    </button>
                </div>
            </form>

            <div class="mt-6 text-center">
                <p class="text-gray-600">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="text-amber-600 hover:underline font-medium">Register</a>
                </p>
            </div>
        </div>
    </main>
</div>

<script>
    async function loginUser(event) {
        event.preventDefault();

        // Clear previous messages
        document.getElementById('error-message').classList.add('hidden');
        document.getElementById('success-message').classList.add('hidden');

        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;

        try {
            const response = await fetch("/api/login", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                },
                body: JSON.stringify({ email, password }),
            });

            const data = await response.json();

            if (response.ok) {
                localStorage.setItem("access_token", data.access_token);
                document.getElementById('success-message').innerText = "Login successful! Redirecting...";
                document.getElementById('success-message').classList.remove('hidden');

                // Redirect to your dashboard
                setTimeout(() => {
                    window.location.href = "/dashboard"; // adjust as needed
                }, 1000);
            } else {
                document.getElementById('error-message').innerText = data.message || "Login failed";
                document.getElementById('error-message').classList.remove('hidden');
            }
        } catch (error) {
            document.getElementById('error-message').innerText = "Server error. Please try again.";
            document.getElementById('error-message').classList.remove('hidden');
        }
    }
</script>
@endsection
