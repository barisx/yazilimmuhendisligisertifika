<?php
/**
 * Template Name: PDF Search
 */
 
get_header();

session_start();
/*
// Function to check if the search count exceeds the limit
function checkSearchCountLimit() {
    $ip = $_SERVER['REMOTE_ADDR'];
    $limit = 5; // Number of searches allowed per user

    // Create a session variable to store the search count
    if (!isset($_SESSION['search_count'])) {
        $_SESSION['search_count'] = 0;
    }

    // Check if the search count exceeds the limit
    if ($_SESSION['search_count'] >= $limit) {
        wp_die('Search count limit exceeded.');
    }
}

// Call the search count limit function
checkSearchCountLimit();
*/
?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">

<section class="section">
    <div class="container">
        <div class="columns is-centered">
            <div class="column is-half">
                <div class="field has-addons">
                    <div class="control is-expanded">
                        <input id="pdfId" class="input" type="text" placeholder="Sertifika ID">
                    </div>
                    <div class="control">
                        <button id="searchButton" class="button is-info">Sorgula</button>
                    </div>
                </div>
                <div id="pdfViewer" class="mt-4" style="display: none;">
                    <embed id="pdfEmbed" src="" type="application/pdf" width="100%" height="600px">
                    <a id="downloadButton" class="button is-primary mt-4" href="" download>Sertifikayı İndir</a>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const pdfIdInput = document.getElementById('pdfId');
        const searchButton = document.getElementById('searchButton');
        const pdfViewer = document.getElementById('pdfViewer');
        const pdfEmbed = document.getElementById('pdfEmbed');
        const downloadButton = document.getElementById('downloadButton');

        searchButton.addEventListener('click', () => {
            const pdfId = pdfIdInput.value.trim();

            // Check if the PDF ID is empty
            if (pdfId === '') {
                return;
            }

            // Update search button state
            searchButton.classList.add('is-loading');
            searchButton.disabled = true;

            // Request the PDF file
            const pdfUrl = `https://yazilimmuhendisligi.com.tr/wp-content/sertifika/${pdfId}.pdf`;
            fetch(pdfUrl)
                .then(response => {
                    if (response.ok) {
                        // Show PDF viewer and set PDF embed source
                        pdfViewer.style.display = 'block';
                        pdfEmbed.src = pdfUrl;

                        // Set download button link
                        downloadButton.href = pdfUrl;

                        // Increase search count
                        increaseSearchCount();

                        // Reset search button state
                        searchButton.classList.remove('is-loading');
                        searchButton.disabled = false;
                    } else {
                        throw new Error('PDF not found');
                    }
                })
                .catch(error => {
                    console.error(error);
                    alert('An error occurred. Please try again.');
                    searchButton.classList.remove('is-loading');
                    searchButton.disabled = false;
                });
        });

        // Function to increase the search count
        function increaseSearchCount() {
            fetch('<?php echo admin_url("admin-ajax.php"); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'action=increase_search_count',
            })
                .then(response => {
                    if (response.ok) {
                        return response.text();
                    } else {
                        throw new Error('Failed to increase search count');
                    }
                })
                .then(result => {
                    console.log(result);
                })
                .catch(error => {
                    console.error(error);
                });
        }
    });
</script>

<?php
get_footer();
?>