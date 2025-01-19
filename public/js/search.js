$(document).ready(function () {
    function fetchData(searchInput = '', url) {
        $.ajax({
            url: url,
            method: 'GET',
            data: { search: searchInput },
            success: function(response) {
                $('tbody').html(response.html);
            }
        });
    }

    // Bind the `keyup` event to filter the table based on user input
    searchInput.keyup(function() {
        var searchValue = $(this).val(); // Get the value of the input
        fetchData(searchValue, url);
    });

});
