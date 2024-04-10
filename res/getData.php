<?php
// Establish a database connection
$conn = new mysqli("localhost", "root", "", "sitescape");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if user_id is provided in the request
if (isset($_GET['site_id'])) {
    $userId = $_GET['site_id'];

    // SQL query to retrieve user data based on user_id
    $sql = "SELECT categories.*, sites.* FROM sites
    INNER JOIN categories
    ON categories.category_id = sites.category_id
    WHERE sites.site_id = '$userId'";

    // Execute the query
    $result = $conn->query($sql);

    // Check if the query was successful
    if ($result) {
        // Fetch the data
        $userData = $result->fetch_assoc();

        // Return the user data as JSON
        echo json_encode($userData);
    } else {
        // Query failed
        echo json_encode(array('error' => 'Failed to retrieve user data.'));
    }
} else {
    // user_id parameter not provided
    echo json_encode(array('error' => 'user_id parameter is missing.'));
}


$conn->close();
?>