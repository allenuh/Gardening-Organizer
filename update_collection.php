<?php
session_start();
include "db_conn.php";

// Check if the user is logged in
if (isset($_SESSION['id']) && isset($_SESSION['username'])) {

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get form data
        $collectionId = $_POST['collection_id'];
        $newCollectionName = $_POST['cname'];

        // Update collection in the database
        $query = "UPDATE collections SET collection_name = '$newCollectionName' WHERE collection_id = $collectionId";
        $result = $conn->query($query);

        if (!$result) {
            die("Error updating collection: " . $conn->error);
        }

        // Redirect back to the collections page after updating
        header("Location: edit_collection.php"); // Redirect to the collections page
        exit();
    } else {
        // Redirect the user if the form is not submitted via POST
        header("Location: edit_collection.php"); // Redirect to the collections page
        exit();
    }
} else {
    // Redirect the user if not logged in
    header("Location: index.php");
    exit();
}
?>
