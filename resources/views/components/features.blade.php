<section id="features" class="py-20 bg-white">
    <div class="container mx-auto px-6">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">
                Powerful Features
            </h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Designed to modernize and secure the electoral process with
                cutting-edge technology
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach([
                [
                    'name' => 'Secure Voting',
                    'description' => 'Blockchain-powered security ensuring tamper-proof elections with verifiable results.',
                    'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'
                ],
                [
                    'name' => 'Transparent Process',
                    'description' => 'Real-time tracking and auditing of votes with complete transparency.',
                    'icon' => 'M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z'
                ],
                [
                    'name' => 'Live Analytics',
                    'description' => 'Comprehensive dashboards showing election metrics and participation rates.',
                    'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z'
                ],
                [
                    'name' => 'Voter Engagement',
                    'description' => 'Tools to increase voter turnout and community participation.',
                    'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z'
                ]
            ] as $index => $feature)
            <div class="feature-card bg-gradient-to-b from-gray-50 to-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all border border-gray-100 transform hover:-translate-y-2"
                 style="opacity: 0; transform: translateY(20px); transition: all 0.5s ease {{ $index * 0.1 }}s;">
                <div class="w-14 h-14 bg-amber-100 rounded-lg flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $feature['icon'] }}"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">
                    {{ $feature['name'] }}
                </h3>
                <p class="text-gray-600">{{ $feature['description'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<script>
    // Animate feature cards on scroll
    document.addEventListener('DOMContentLoaded', function() {
        const featureCards = document.querySelectorAll('.feature-card');
        
        const animateOnScroll = () => {
            featureCards.forEach(card => {
                const cardPosition = card.getBoundingClientRect().top;
                const screenPosition = window.innerHeight / 1.3;
                
                if (cardPosition < screenPosition) {
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }
            });
        };
        
        // Initial check
        animateOnScroll();
        
        // Check on scroll
        window.addEventListener('scroll', animateOnScroll);
    });
</script>