// validation.js

// Function to validate the login form
function validateLoginForm() {
    var username = document.getElementById("username").value.trim();
    var password = document.getElementById("password").value.trim();

    // Ensure username and password are filled
    if (username === "" || password === "") {
        alert("Username and password are required.");
        return false;
    }
    return true;
}

// Function to validate the product addition and edit form
function validateProductForm() {
    var name = document.getElementById("name").value.trim();
    var price = document.getElementById("price").value;
    var stock = document.getElementById("stock").value;

    // Ensure name, price, and stock are filled correctly
    if (name === "" || price === "" || stock === "") {
        alert("All product fields are required.");
        return false;
    }
    if (price <= 0) {
        alert("Price must be a positive number.");
        return false;
    }
    if (stock < 0) {
        alert("Stock cannot be negative.");
        return false;
    }
    return true;
}

// Function to validate the checkout form
function validateCheckoutForm() {
    var quantity = document.getElementById("quantity").value;

    // Ensure quantity is positive
    if (quantity === "" || quantity <= 0) {
        alert("Please enter a valid quantity.");
        return false;
    }
    return true;
}
