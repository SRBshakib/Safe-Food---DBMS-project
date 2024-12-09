document.addEventListener("DOMContentLoaded", function () {
    const categorySelect = document.getElementById("category");
    const batchSelectionDiv = document.getElementById("batch-selection");
    const batchSelect = document.getElementById("batch-id");
    const productDetailsDiv = document.getElementById("product-details");
    const submitBtn = document.getElementById("submit-btn");

    // Sample data for demonstration
    const productData = {
        crop_fruits: [
            { batchId: "C123", productName: "Apple", origin: "USA", harvestDate: "2023-09-10", expiryDate: "2024-09-10", farmName: "Green Farms", processingDate: "2023-09-15" },
            { batchId: "C124", productName: "Banana", origin: "India", harvestDate: "2023-08-15", expiryDate: "2024-08-15", farmName: "Tropical Farms", processingDate: "2023-08-20" }
        ],
        fish: [
            { batchId: "F001", productName: "Salmon", origin: "Norway", harvestDate: "2023-09-05", expiryDate: "2024-03-05", farmName: "Fisher's World", processingDate: "2023-09-10" }
        ]
    };

    // Update batch list based on selected category
    categorySelect.addEventListener("change", function () {
        const selectedCategory = categorySelect.value;
        const batches = productData[selectedCategory];

        // Reset batch selection
        batchSelect.innerHTML = '';
        batches.forEach(batch => {
            const option = document.createElement('option');
            option.value = batch.batchId;
            option.textContent = `${batch.batchId} - ${batch.productName}`;
            batchSelect.appendChild(option);
        });

        batchSelectionDiv.style.display = 'block';
        productDetailsDiv.style.display = 'none';
        submitBtn.style.display = 'none';
    });

    // Show product details after batch selection
    batchSelect.addEventListener("change", function () {
        const selectedBatchId = batchSelect.value;
        const selectedCategory = categorySelect.value;
        const batch = productData[selectedCategory].find(b => b.batchId === selectedBatchId);

        if (batch) {
            document.getElementById("origin").textContent = batch.origin;
            document.getElementById("harvest-date").textContent = batch.harvestDate;
            document.getElementById("expiry-date").textContent = batch.expiryDate;
            document.getElementById("farm-name").textContent = batch.farmName;
            document.getElementById("processing-date").textContent = batch.processingDate;

            productDetailsDiv.style.display = 'block';
            submitBtn.style.display = 'block';
        }
    });

    // Submit button action (for demo)
    submitBtn.addEventListener("click", function () {
        alert("Stock updated successfully!");
    });
});
