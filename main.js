// Main Interactivity Script

document.addEventListener('DOMContentLoaded', function() {
    
    // Navbar scroll effect
    const navbar = document.querySelector('.navbar');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });

    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Intersection Observer for animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    // Observe all cards
    document.querySelectorAll('.place-card, .stat-card').forEach((el) => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(20px)';
        el.style.transition = 'all 0.6s ease';
        observer.observe(el);
    });

    // Counter animation for stats
    const counters = document.querySelectorAll('.counter');
    counters.forEach(counter => {
        const target = +counter.getAttribute('data-target');
        const increment = target / 100;
        
        const updateCounter = () => {
            const count = +counter.innerText;
            if (count < target) {
                counter.innerText = Math.ceil(count + increment);
                setTimeout(updateCounter, 20);
            } else {
                counter.innerText = target + '+';
            }
        };
        
        // Start when visible
        const counterObserver = new IntersectionObserver((entries) => {
            if (entries[0].isIntersecting) {
                updateCounter();
                counterObserver.disconnect();
            }
        });
        counterObserver.observe(counter);
    });

    // Toast Notification System
    window.showToast = function(message, type = 'success') {
        const toast = document.createElement('div');
        toast.className = `toast ${type}`;
        toast.innerHTML = `
            <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i>
            <span>${message}</span>
        `;
        document.body.appendChild(toast);
        
        setTimeout(() => toast.classList.add('show'), 100);
        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    };

    // Form validation with animation
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const btn = form.querySelector('button[type="submit"]');
            const spinner = btn.querySelector('.spinner');
            
            if (spinner) {
                spinner.style.display = 'inline-block';
                btn.disabled = true;
            }
            
            // Add shake animation if validation fails
            const inputs = form.querySelectorAll('input[required]');
            let valid = true;
            
            inputs.forEach(input => {
                if (!input.value.trim()) {
                    valid = false;
                    input.style.animation = 'shake 0.5s';
                    input.style.borderColor = '#ef4444';
                    setTimeout(() => {
                        input.style.animation = '';
                    }, 500);
                } else {
                    input.style.borderColor = '#e2e8f0';
                }
            });
            
            if (!valid) {
                e.preventDefault();
                if (spinner) {
                    spinner.style.display = 'none';
                    btn.disabled = false;
                }
                showToast('Please fill all required fields', 'error');
            }
        });
    });

    // Parallax effect for hero
    window.addEventListener('scroll', () => {
        const scrolled = window.pageYOffset;
        const hero = document.querySelector('.hero');
        if (hero) {
            hero.style.transform = `translateY(${scrolled * 0.5}px)`;
        }
    });

    // Image lazy loading with blur effect
    const images = document.querySelectorAll('img[data-src]');
    const imgObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.onload = () => {
                    img.classList.add('loaded');
                };
                imgObserver.unobserve(img);
            }
        });
    });
    
    images.forEach(img => imgObserver.observe(img));

    // Modal functionality
    window.openModal = function(content) {
        const modal = document.getElementById('dynamicModal');
        const modalBody = document.getElementById('modalBody');
        modalBody.innerHTML = content;
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
    };

    window.closeModal = function() {
        const modal = document.getElementById('dynamicModal');
        modal.classList.remove('active');
        document.body.style.overflow = 'auto';
    };

    // Close modal on outside click
    document.addEventListener('click', (e) => {
        if (e.target.classList.contains('modal')) {
            closeModal();
        }
    });

    // Search functionality for places
    const searchInput = document.getElementById('placeSearch');
    if (searchInput) {
        searchInput.addEventListener('input', (e) => {
            const searchTerm = e.target.value.toLowerCase();
            const cards = document.querySelectorAll('.place-card');
            
            cards.forEach(card => {
                const title = card.querySelector('h3').textContent.toLowerCase();
                const desc = card.querySelector('p').textContent.toLowerCase();
                
                if (title.includes(searchTerm) || desc.includes(searchTerm)) {
                    card.style.display = 'block';
                    card.style.animation = 'fadeInUp 0.5s';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    }
});

// Add shake animation to CSS dynamically
const style = document.createElement('style');
style.textContent = `
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-10px); }
        75% { transform: translateX(10px); }
    }
`;
document.head.appendChild(style);