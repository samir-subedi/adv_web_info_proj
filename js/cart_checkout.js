// Add to Cart function (AJAX)
function addToCart(productId) {
    // Get the quantity value
    let quantity = document.getElementById('quantity_' + productId).value;

    // Create an AJAX request to add the product to the cart
    let xhr = new XMLHttpRequest();
    xhr.open('POST', 'php/process_sale.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    // Handle the response from the server
    xhr.onload = function () {
        if (xhr.status === 200) {
            // Update the cart summary with the response from the server
            document.getElementById('cartSummary').innerHTML = xhr.responseText;
        } else {
            console.error('Error: Unable to add product to cart');
        }
    };

    // Send the product ID and quantity to the server for processing
    xhr.send('product_id=' + productId + '&quantity=' + quantity);
}
