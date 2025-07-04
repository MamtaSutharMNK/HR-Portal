    document.addEventListener("DOMContentLoaded", function() {
        const jobroleSelect = document.getElementById("jobrole");
        const bandInput = document.getElementById("band");

        jobroleSelect.addEventListener("change", function() {
            const selectedOption = jobroleSelect.options[jobroleSelect.selectedIndex];
            bandInput.value = selectedOption.getAttribute("data-band") || "";
        });
    });

    // condtion for ctc ranges
    document.addEventListener("DOMContentLoaded", function() {
        const startRange = document.querySelector('input[name="ctc_start_range"]');
        const endRange = document.querySelector('input[name="ctc_end_range"]');

        function validateRange() {
            if (parseFloat(endRange.value) <= parseFloat(startRange.value)) {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "End Range must be greater than Start Range!",
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "OK"
                });

                endRange.value = "";
            }
        }
        endRange.addEventListener("change", validateRange);
    });

