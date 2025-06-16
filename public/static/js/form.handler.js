document.addEventListener("DOMContentLoaded", function () {
    const currencySelect = document.getElementById("currencySelect");
    const ctcTypeWrapper = document.getElementById("ctcTypeWrapper");
    const ctcType = document.getElementById("ctcType");
    const ctcRangeWrapper = document.getElementById("ctcRangeWrapper");

    // Show CTC Type when Currency is selected
    currencySelect.addEventListener("change", function () {
        if (this.value !== "") {
            ctcTypeWrapper.style.display = "block";
        } else {
            ctcTypeWrapper.style.display = "none";
            ctcType.value = "";
            ctcRangeWrapper.style.display = "none";
        }
    });

    // Show CTC Range when "Yearly" is selected
    ctcType.addEventListener("change", function () {
        if (this.value === "yearly") {
            ctcRangeWrapper.style.display = "block";
        } else {
            ctcRangeWrapper.style.display = "none";
        }
    });
});