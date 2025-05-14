@extends('layouts.extens')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-bold text-gray-900">Party Dashboard</h2>
                <span id="welcome-message" class="text-gray-600"></span>
            </div>
            
            <div class="mt-8 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <!-- Statistics Cards -->
                <div class="bg-amber-50 p-6 rounded-lg shadow">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-amber-100 text-amber-600">
                            <i class="fas fa-users fa-lg"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900">Members</h3>
                            <p class="mt-1 text-3xl font-semibold text-gray-900">1,254</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-blue-50 p-6 rounded-lg shadow">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                            <i class="fas fa-calendar-check fa-lg"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900">Upcoming Events</h3>
                            <p class="mt-1 text-3xl font-semibold text-gray-900">3</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-green-50 p-6 rounded-lg shadow">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100 text-green-600">
                            <i class="fas fa-bullhorn fa-lg"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900">Campaigns</h3>
                            <p class="mt-1 text-3xl font-semibold text-gray-900">7</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Recent Activity Section -->
            <div class="mt-12">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Recent Activity</h3>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <ul class="divide-y divide-gray-200" id="recent-activity">
                        <!-- Activity items will be loaded here -->
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Load welcome message with party name
        const token = localStorage.getItem('access_token');
        if (token) {
            fetchPartyProfile();
        }

        // Sample activity data - in a real app, you'd fetch this from your API
        const activities = [
            { id: 1, type: 'event', title: 'New campaign launched', date: '2 hours ago' },
            { id: 2, type: 'member', title: '50 new members joined', date: '1 day ago' },
            { id: 3, type: 'news', title: 'Party mentioned in national news', date: '2 days ago' }
        ];

        const activityList = document.getElementById('recent-activity');
        activities.forEach(activity => {
            const item = document.createElement('li');
            item.className = 'py-3';
            
            let iconClass = 'fas fa-calendar';
            let iconColor = 'text-blue-500';
            
            if (activity.type === 'member') {
                iconClass = 'fas fa-user-plus';
                iconColor = 'text-green-500';
            } else if (activity.type === 'news') {
                iconClass = 'fas fa-newspaper';
                iconColor = 'text-amber-500';
            }
            
            item.innerHTML = `
                <div class="flex items-center space-x-3">
                    <div class="flex-shrink-0">
                        <i class="${iconClass} ${iconColor}"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">${activity.title}</p>
                        <p class="text-sm text-gray-500 truncate">${activity.date}</p>
                    </div>
                </div>
            `;
            activityList.appendChild(item);
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
                if (data.party_name) {
                    document.getElementById('welcome-message').textContent = `Welcome, ${data.party_name}`;
                }
            }
        } catch (error) {
            console.error('Error fetching party profile:', error);
        }
    }
</script>
@endsection