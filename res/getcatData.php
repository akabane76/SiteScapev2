<?php
// Establish a database connection
$conn = new mysqli("localhost", "root", "", "sitescape");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if user_id is provided in the request
if (isset($_GET['cat_id'])) {
    $catId = isset($_GET['cat_id']) ? trim($_GET['cat_id']) : '';
   
   
       // SQL query to retrieve user data based on user_id
       $sql = "SELECT * FROM `categories`
       WHERE category_id = '$catId'";
   
       // Execute the query
       $result = $conn->query($sql);
   
       // Check if the query was successful
       if ($result) {
           // Fetch the data
           $cat2Data = $result->fetch_assoc();
   
           // Return the user data as JSON
           echo json_encode($cat2Data);
       } else {
           // Query failed
           echo json_encode(array('error' => 'Failed to retrieve user data.'));
       }
   } else {
       // user_id parameter not provided
       echo json_encode(array('error' => 'cat_id parameter is missing.'));
   }