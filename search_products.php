<?php
include('query.php');

// Retrieve query and category_id from URL parameters
$query = isset($_GET['query']) ? $_GET['query'] : '';
$categoryId = isset($_GET['category_id']) ? (int) $_GET['category_id'] : 0;

if ($categoryId > 0) {
    // Filter products by category and optional search query
    $stmt = $pdo->prepare('
        SELECT products.*, suppliers.product_qty AS supQty 
        FROM products 
        INNER JOIN suppliers ON products.supplier_id = suppliers.id 
        WHERE products.category_id = :category_id 
        AND products.name LIKE :query
    ');
    $stmt->execute(['category_id' => $categoryId, 'query' => '%' . $query . '%']);
} else {
    // Filter by search query only
    $stmt = $pdo->prepare('
        SELECT products.*, suppliers.product_qty AS supQty 
        FROM products 
        INNER JOIN suppliers ON products.supplier_id = suppliers.id 
        WHERE products.name LIKE :query
    ');
    $stmt->execute(['query' => '%' . $query . '%']);
}

// Fetch products with supplier quantities
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<section class="section-space">
    <div class="container">
       
        <div class="row mb-n4 mb-sm-n10 g-3 g-sm-6">
            <?php foreach ($products as $product): 
                $productRating = (int) $product['rating']; // Assuming rating is an integer from 1 to 5
                $isOutOfStock = $product['supQty'] <= 0; // Check stock availability from suppliers
            ?>
                <div class="col-6 col-lg-4 mb-4 mb-sm-9">
                    <div class="product-item">
                        <div class="product-thumb">
                            <?php if (!$isOutOfStock): ?>
                                <a class="d-block" href="product-details.php?id=<?php echo htmlspecialchars($product['id']); ?>">
                            <?php else: ?>
                                <div class="d-block" style="cursor: not-allowed;">
                            <?php endif; ?>
                                    <img src="assets/images/shop/<?php echo htmlspecialchars($product['image']); ?>" 
                                         width="370" height="450" alt="Image-HasTech" 
                                         style="<?php echo $isOutOfStock ? 'filter: grayscale(100%); opacity: 0.5;' : ''; ?>">
                            <?php if (!$isOutOfStock): ?>
                                </a>
                            <?php else: ?>
                                </div>
                            <?php endif; ?>

                            <div class="product-action">
                                <?php if ($isOutOfStock): ?>
                                    <button type="button" class="product-action-btn action-btn-cart"
                                            style="background-color: gray; cursor: not-allowed;" disabled>
                                        <span>Out of Stock</span>
                                    </button>
                                <?php else: ?>
                                    <button type="button" class="product-action-btn action-btn-cart"
                                            onclick="addToCart(<?php echo $product['id']; ?>)">
                                        <span>Add to cart</span>
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="product-info">
                            <h4 class="title">
                                <?php if (!$isOutOfStock): ?>
                                    <a href="product-details.php?id=<?php echo htmlspecialchars($product['id']); ?>">
                                        <?php echo htmlspecialchars($product['name']); ?>
                                    </a>
                                <?php else: ?>
                                    <span style="color: gray;"><?php echo htmlspecialchars($product['name']); ?></span>
                                <?php endif; ?>
                            </h4>
                            <div class="product-rating">
                                <div class="rating">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <span class="star">
                                            <i class="fa <?php echo $i <= $productRating ? 'fa-star filled' : 'fa-star-o empty'; ?>"></i>
                                        </span>
                                    <?php endfor; ?>
                                </div>
                            </div>
                            <div class="prices">
                                <span class="price" style="<?php echo $isOutOfStock ? 'color: gray;' : ''; ?>">
                                    $<?php echo htmlspecialchars($product['price']); ?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

