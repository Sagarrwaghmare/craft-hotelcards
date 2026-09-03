</main>
</div> <!-- Closes the flex-1 content wrapper from sidebar.php -->

<!-- Load jQuery from local assets with fallback -->
<script src="<?= base_url('assets/cdn/jquery.js') ?>"></script>
<script>
    if (typeof jQuery === 'undefined') {
        document.write('<script src="https://code.jquery.com/jquery-3.7.1.min.js"><\/script>');
    }
</script>

<!-- Sidebar Toggle Action -->
<script>
    $(document).ready(function() {
        $('#sidebarToggle').on('click', function(e) {
            e.preventDefault();
            // Toggles -ml-64 (slides sidebar 16rem to the left)
            $('#mainSidebar').toggleClass('-ml-64');
        });
    });
</script>

</body>
</html>