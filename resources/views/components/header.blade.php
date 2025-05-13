<header class="fixed top-0 w-full bg-white/80 backdrop-blur-md z-50 shadow-sm">
    <div class="container mx-auto px-6 py-4 flex justify-between items-center">
        <a href="/" class="flex items-center gap-2">
            <img src="https://nebe.org.et/sites/default/files/NEBE%20LOGO-01.png" 
                 alt="Mirchaye Logo" 
                 width="40" 
                 height="40" 
                 class="object-contain">
            <span class="text-2xl font-bold bg-gradient-to-r from-amber-600 to-red-700 bg-clip-text text-transparent">
                Mirchaye
            </span>
        </a>

        <div class="flex items-center gap-4">
            <a href="/login" 
               class="px-4 py-2 rounded-lg font-medium text-gray-700 hover:bg-gray-100 transition-colors">
                Login
            </a>
            <a href="/register" 
               id="register-link"
               class="px-4 py-2 rounded-lg font-medium bg-gradient-to-r from-amber-500 to-red-600 text-white shadow-lg hover:shadow-xl transition-all">
                Register
            </a>
        </div>
    </div>
</header>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Header animation
        const header = document.querySelector('header');
        header.style.opacity = '0';
        header.style.transform = 'translateY(-20px)';
        
        setTimeout(() => {
            header.style.transition = 'all 0.5s ease';
            header.style.opacity = '1';
            header.style.transform = 'translateY(0)';
        }, 100);

        // Ensure register link works properly
        const registerLink = document.getElementById('register-link');
        if (registerLink) {
            registerLink.addEventListener('click', function(e) {
                // Only prevent default if we're already on the register page
                if (window.location.pathname === '/register') {
                    e.preventDefault();
                    document.getElementById('register-form')?.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        }
    });
</script>