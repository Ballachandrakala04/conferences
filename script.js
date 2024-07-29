<script>
$(document).ready(function() {alert("test");
    // Handle click on vertical navigation links
    $('.nav-link').on('click', function(e) {
        e.preventDefault();
        var page = $(this).data('page');
        loadPage(page);
    });

    // Handle click on horizontal navigation links
    $('.nav-item').on('click', function(e) {
        e.preventDefault();
        var page = $(this).data('page');
        loadPage(page);
    });

    $('.assisted').on('click', function(e) {alert("test");
        e.preventDefault();
        $('#dashboard').css('display','none');
        $('#residentlist').css('display','block');
    });
 


    

    // Function to load page via AJAX
    function loadPage(page) {
        $.ajax({
            url: 'load_page.php', // URL of the server-side script to load content
            type: 'POST', // Use POST method to send data
            data: { page: page }, // Send page identifier to server
            success: function(response) {
                $('#content').html(response); // Replace content of #content with loaded page
            },
            error: function(xhr, status, error) {
                console.error('Error loading page: ' + status + ', ' + error);
                // Handle errors if necessary
            }
        });
    }

    // Load default page (e.g., Dashboard) on page load
    loadPage('dashboard');
});

    </script>