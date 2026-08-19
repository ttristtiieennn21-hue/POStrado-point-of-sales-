const productsContainer = document.querySelector(".products");

function toggleSidebar() {
    document.querySelector(".sidebar").classList.toggle("hide");
}

function openAddModal(title = "Add New Product") {
    document.getElementById("modalTitle").innerText = title;
    document.getElementById("productModal").style.display = "flex";
}

function closeModal() {
    document.getElementById("productModal").style.display = "none";
}

