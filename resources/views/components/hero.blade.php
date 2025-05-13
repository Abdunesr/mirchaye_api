<section class="relative min-h-screen flex items-center justify-center bg-gradient-to-b from-gray-50 to-white overflow-hidden">
    <div id="particles-js" class="absolute inset-0 z-0"></div>

    <div class="container mx-auto px-6 relative z-10">
        <div class="max-w-3xl mx-auto text-center">
            <h1 class="text-5xl md:text-7xl font-bold mb-6 bg-gradient-to-r from-amber-600 to-red-700 bg-clip-text text-transparent">
                Revolutionizing Democratic Participation
            </h1>
            <p class="text-xl text-gray-600 mb-10">
                Mirchaye brings transparency, security, and accessibility to
                electoral processes. Join the future of democracy today.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="/register" 
                   class="px-8 py-3 rounded-full bg-gradient-to-r from-amber-500 to-red-600 text-white font-bold shadow-lg hover:shadow-xl transition-all transform hover:scale-105 active:scale-95">
                    Get Started
                </a>
                
            </div>
        </div>
    </div>

    <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 opacity-0 animate-fade-in" style="animation-delay: 500ms;">
        <div class="animate-bounce w-10 h-10 rounded-full bg-gradient-to-r from-amber-500 to-red-600 flex items-center justify-center">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
            </svg>
        </div>
    </div>
</section>

<style>
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    .animate-fade-in {
        animation: fadeIn 1s ease forwards;
    }
</style>

<script>
    // Initialize particles.js
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof particlesJS !== 'undefined') {
            particlesJS('particles-js', {
                particles: {
                    number: { value: 80, density: { enable: true, value_area: 800 } },
                    color: { value: "#f59e0b" },
                    shape: { type: "circle" },
                    opacity: { value: 0.5, random: true },
                    size: { value: 3, random: true },
                    line_linked: { enable: true, distance: 150, color: "#f59e0b", opacity: 0.4, width: 1 },
                    move: { enable: true, speed: 2, direction: "none", random: true, straight: false, out_mode: "out" }
                },
                interactivity: {
                    detect_on: "canvas",
                    events: {
                        onhover: { enable: true, mode: "repulse" },
                        onclick: { enable: true, mode: "push" }
                    }
                }
            });
        }
    });
</script>