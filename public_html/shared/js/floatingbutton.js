document.addEventListener('DOMContentLoaded', function() {
    console.log("DOM Loaded");

    // Make an AJAX request to fetch confirmed status from PHP API
    var xhr = new XMLHttpRequest();
    xhr.open('GET', '/api/hallConfirmedStatus', true);
    xhr.onload = function() {
        if (xhr.status >= 200 && xhr.status < 400) {
            console.log(xhr.responseText);
            var response = JSON.parse(xhr.responseText);
            var confirmed = response.confirmed;

            // Toggle button visibility based on confirmed status
            var confirmButton = document.getElementById('confirmButton');
            var overruleButton = document.getElementById('overruleButton');
            var confirmImage = document.getElementById('confirmed_image');
            
            if (confirmed) {
                confirmImage.style.display = '';
                confirmButton.style.display = 'none'; // Hide confirm button
                overruleButton.style.display = 'none'; // Hide overrule button
            } else {
                confirmButton.style.display = 'block'; // Show confirm button
                overruleButton.style.display = 'block'; // Show overrule button
            }
        } else {
            console.error('Error fetching confirmed status from API. Status:', xhr.status);
        }
    };
    xhr.onerror = function() {
        console.error('Error fetching confirmed status from API. Network error occurred.');
    };
    xhr.send();
});
