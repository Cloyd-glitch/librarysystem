<footer class="footer mt-auto py-3 bg-white text-center">
    <div class="container">
        <span class="text-muted">
            Copyright © <span id="year">{{ date('Y') }}</span> 
            <a href="javascript:void(0);" class="text-dark fw-medium">Library System</a>.
            All rights reserved
        </span>
    </div>
</footer>

<script>
    // Update year dynamically
    document.getElementById('year').textContent = new Date().getFullYear();
</script>