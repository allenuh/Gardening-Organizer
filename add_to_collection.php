<?php
session_start();

// Check if the user is logged in
if (isset($_SESSION['id']) && isset($_SESSION['username'])) {
    // Include your database connection code here
    include "db_conn.php";

    // Check if flower_id and collection_id are provided in the URL
    if (isset($_GET['flower_id']) && isset($_GET['collection_id'])) {
        $flowerId = $_GET['flower_id'];
        $collectionId = $_GET['collection_id'];
        $userId = $_SESSION['id'];

        // Insert the flower into the collection
        $query = "INSERT INTO collection_flower (collection_id, flower_id) VALUES ($collectionId, $flowerId)";
        $result = $conn->query($query);

        if (!$result) {
            die("Error adding flower to collection: " . $conn->error);
        }

        // Redirect back to the flowers page after adding
        header("Location: flowers.php"); // Redirect to the flowers page
        exit();
    } else {
        // Redirect the user if flower_id or collection_id is not provided
        header("Location: flowers.php"); // Redirect to the flowers page
        exit();
    }
} else {
    // Redirect the user if not logged in
    header("Location: index.php");
    exit();
}
?>
