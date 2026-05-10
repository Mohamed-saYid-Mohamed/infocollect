document.addEventListener('DOMContentLoaded', () => {
    // Basic form validation and loading state UI
    const forms = document.querySelectorAll('form');
    const loader = document.getElementById('loaderOverlay');

    forms.forEach(form => {
        form.addEventListener('submit', (e) => {
            // Show loader when a form is submitted
            if (loader) {
                loader.classList.add('active');
            }
            
            // Allow the form to submit naturally
            // If it's the submission form, we might want to disable the button
            const submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = 'Processing...';
            }
        });
    });

    // Auto-hide alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert:not(.alert-danger)');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            setTimeout(() => {
                alert.style.display = 'none';
            }, 300);
        }, 5000);
    });
});
