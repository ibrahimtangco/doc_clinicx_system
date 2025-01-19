$(document).ready(function () {

    // Function to fetch cities based on the selected province
    function fetchCities(province_code, selectedCity = null) {
        $.ajax({
            url: "api/fetch-city",
            type: "POST",
            dataType: "json",
            data: { province_code: province_code },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                $("#city")
                    .html('<option value="">--Select City--</option>');
                $("#barangay")
                    .empty();
                // Populate cities dropdown and set selected value if available
                $.each(response.cities, function (index, value) {
                    $("#city").append(
                        `<option value='${value.city_code}' ${value.city_code == selectedCity ? "selected" : ""}>${value.city_name}</option>`
                    );
                });

                // Fetch barangays if a city was previously selected
                if (selectedCity) {
                    fetchBarangays(selectedCity, oldBarangay);
                }
            },
            error: function (xhr, status, error) {
                console.error("Error occurred: " + error);
                console.log(xhr.responseText);
            },
        });
    }

    // Function to fetch barangays based on the selected city
    function fetchBarangays(city_code, selectedBarangay = null) {
        $.ajax({
            url: "api/fetch-barangay",
            type: "POST",
            dataType: "json",
            data: { city_code: city_code },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                $("#barangay")
                    .html('<option value="">--Select Barangay--</option>');
                // Populate barangays dropdown and set selected value if available
                $.each(response.barangay, function (index, value) {
                    $("#barangay").append(
                        `<option value='${value.brgy_code}' ${value.brgy_code == selectedBarangay ? "selected" : ""}>${value.brgy_name}</option>`
                    );
                });
            },
            error: function (xhr, status, error) {
                console.error("Error occurred: " + error);
                console.log(xhr.responseText);
            },
        });
    }

    // Trigger initial load if there is an old province selected
    if (oldProvince) {
        fetchCities(oldProvince, oldCity);
    }

    // Event listener for province change
    $("#province").change(function () {
        var province_code = $(this).val();
        fetchCities(province_code);
    });

    // Event listener for city change
    $("#city").change(function () {
        var city_code = $(this).val();
        fetchBarangays(city_code);
    });
});
