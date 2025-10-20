Ensure once database is created all keywords match to where they need to be
For now 10/20/25, this backend functionality uses `users`, `products`, `orders`, and `order_items`
Endpoints:
   - POST /api/register.php        -> { email, password }
   - POST /api/login.php           -> { email, password }
   - GET  /api/products.php?q=...  -> returns product list
   - POST /api/order.php           -> { user_id, items: [{product_id, price, quantity}, ...] }


