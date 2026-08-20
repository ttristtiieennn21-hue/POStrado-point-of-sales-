<?php
   include '../config.php';
   $query = mysqli_query($conn, "SELECT * FROM item_table");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Himpisao Feeds and Agri supplies</title>

    <link rel="stylesheet" href="product.css">
    <script src="Backend.js"></script>
</head>
<body>

<div class="container">

    <!-- Sidebar -->
    <aside class="sidebar">

    <!-- Logo -->
    <div class="logo">
        <h2>Himpisao</h2>
<p class="company-name">Feeds and Agri Supplies</p>
    </div>

    <!-- Navigation -->
    <ul class="menu">
        <li class="active">
            📦
            <span>Products</span>
        </li>
        <li>
            🛒
            <span>Checkout</span>
        </li>
        <li>
            📋
            <span>Orders</span>
        </li>
        <li>
            👥
            <span>Customers</span>
        </li>
        <li>
            📦
            <span>Inventory</span>
        </li>
        <li>
            📊
            <span>Reports</span>
        </li>
        <li>
            ⚙️
            <span>Settings</span>
        </li>
    </ul>
    
    <!-- Logout -->
    <button class="logout" onclick="location.href='P,O,S.html'">
    Logout
</button>
</aside>

    <!-- Main Content -->
    <main class="main">

        <!-- ================= HEADER ================= -->
<div class="header">

    <!-- Left Side -->
    <div class="header-left">
    <div class="header-title">
        <h2>📦 Products</h2>
        <p>Manage your item_table and inventory</p>
    </div>
</div>

    <!-- Right Side -->
    <div class="header-right">
        <div class="header-date">
    <h3 id="currentDate"></h3>
    <p id="currentTime"></p>
</div>
        <div class="header-user">
            <div class="user-icon">
                👤
            </div>
            <div class="user-info">
                <h4>Cashier</h4>
                <p>Person 1</p>
            </div>
        </div>
    </div>
</div>

<button class="menu-btn" onclick="toggleSidebar()">
        ☰
    </button>

    <!-- ================= DASHBOARD ================= -->
<div class="dashboard">
    <div class="summary-card">
        <h2>0</h2>
        <p>Total Products</p>
    </div>
    <div class="summary-card">
        <h2>0</h2>
        <p>Categories</p>
    </div>
    <div class="summary-card">
        <h2>₱0</h2>
        <p>Total Inventory Value</p>
    </div>
</div>

<!-- ================= TOOLBAR ================= -->

<div class="toolbar">   
    <input type="text" placeholder="Search item_table...">
    <div class="toolbar-buttons">
        <button class="btn-primary" onclick="openAddModal()">
    + New Product
</button>
        <button class="btn-secondary" onclick="document.getElementById('importFile').click()">
            Import
        </button>
        <button class="btn-secondary" onclick="exportProducts()">
            Export
        </button>
    </div>
    <input type="file" id="importFile" accept=".json" style="display:none;">
</div>

    <!-- ================= PRODUCTS ================= -->

<?php while ($item_table = mysqli_fetch_assoc($query)) : ?>


<div class="card">
    <div class="products">
        <!-- Product Image -->
        <div class="product-image">
            <?php if (!empty($item_table['ProductImage'])): ?>

                <img 
                    src="uploads/<?= htmlspecialchars($item_table['ProductImage']) ?>" 
                    alt="<?= htmlspecialchars($item_table['ProductName']) ?>"
                >

            <?php else: ?>

                <span>Product Image</span>

            <?php endif; ?>
        </div>


        <!-- Product Information -->
        <div class="product-info">

            <!-- Product Name -->
            <h3>
                <?= htmlspecialchars($item_table['ProductName']) ?>
            </h3>


            <!-- Prices -->
            <div class="price-list">

                <p>
                    <strong>Base price:</strong>
                    ₱<?= number_format($item_table['Price1'], 2) ?>
                </p>

                <?php if (!empty($item_table['Price2'])) : ?>
                    <p>
                        <strong>2 item discount:</strong>
                        ₱<?= number_format($item_table['Price2'], 2) ?>
                    </p>
                <?php endif; ?>


                <?php if (!empty($item_table['Price3'])) : ?>
                    <p>
                        <strong>3 item discount:</strong>
                        ₱<?= number_format($item_table['Price3'], 2) ?>
                    </p>
                <?php endif; ?>

            </div>

            <!-- Product Details -->
            <div class="product-details">

                <p>
                    <strong>Category:</strong>
                    <?= htmlspecialchars($item_table['Category']) ?>
                </p>


                <p>
                    <strong>Description:</strong>
                    <?= htmlspecialchars($item_table['Description']) ?>
                </p>


            </div>

        </div>


        <!-- Edit / Delete Buttons -->
        <div class="product-actions">

            <a 
                href="update.php?ProductId=<?= $item_table['ProductId'] ?>"
                class="edit-btn" onclick="openEditModal()"
            >
                Edit
            </a>


            <a 
                href="action.php?ProductId=<?= $item_table['ProductId']?>"
                class="delete-btn"
                onclick="return confirm('Are you sure you want to delete this product?');"
            >
                Delete
            </a>

        </div>

    </div>


    </div>


</div>


<?php endwhile; ?>
<!-- ================= PAGINATION ================= -->
<div class="pagination">
    <button onclick="previousPage()">&lt;</button>
    <button class="page-btn current" onclick="goToPage(1)">1</button>
    <button class="page-btn" onclick="goToPage(2)">2</button>
    <button class="page-btn" onclick="goToPage(3)">3</button>
    <button disabled>...</button>
    <button class="page-btn" onclick="goToPage(10)">10</button>
    <button onclick="nextPage()">&gt;</button>
</div>

</main>



<!-- ================= PRODUCT MODAL ================= -->

<div class="modal" id="productModal">
    <form method="POST" action="action.php">

     <div class="modal-box">
        <h2 id="modalTitle">Add New Product</h2>
       
        <div id="product_img">
            <label>Product Image</label>
            <input type="file" name="ProductImage" accept="image/*">
        </div>

        <div class="form-group">
            <label>Product Name</label>
            <input type="text" name="ProductName">
        </div>

        <div class="form-group">
            <h2>Prices Quantity</h2>

            <div class="price-section">

                <div class="price-item">
                    <label>Base price</label>
                    <input type="number" name="Price1" min="0" step="0.01">
                </div>

                <div class="price-item">
                    <label>2 item discount</label>
                    <input type="number" name="Price2" min="0" step="0.01">
                </div>

                <div class="price-item">
                    <label>3 item discount</label>
                    <input type="number" name="Price3" min="0" step="0.01">
                </div>

            </div>
        </div>

        <div class="form-group">
            <label>Category</label>
            <input type="text" name="Category">
        </div>

        <div class="form-group">
            <label>Description</label>
            <input type="text" name="Description">
        </div>

        <div class="modal-buttons">
     </form>

            <button class="save-btn" type="submit" name="create" onclick= window.location.href='product_page.php'>
                Save
            </button>

            <button class="cancel-btn" onclick="closeModal()">
                Cancel
            </button>

             </div>

        </div>

    </div>

</div>

<div id="toast" class="toast"></div>

</body>
</html>
