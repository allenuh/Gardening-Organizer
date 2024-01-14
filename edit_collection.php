<?php
session_start();
include "db_conn.php";

// Check if the user is logged in
if (isset($_SESSION['id']) && isset($_SESSION['username'])) {

    // Check if collection ID is provided in the URL
    if (isset($_GET['collection_id'])) {
        $collectionId = $_GET['collection_id'];

        // Fetch collection details from the database
        $query = "SELECT * FROM collections WHERE collection_id = $collectionId";
        $result = $conn->query($query);

        if (!$result) {
            die("Error fetching collection details: " . $conn->error);
        }

        $collection = $result->fetch_assoc();
    } else {
        // Redirect the user if collection ID is not provided
        header("Location: home.php"); // Redirect to the collections page
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Collection</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Edit Collection</h1>
    <form action="update_collection.php" method="post">
        <label>Collection Name</label>
        <input type="text" name="cname" value="<?php echo $collection['collection_name']; ?>"><br>

        <!-- Include hidden input for collection ID -->
        <input type="hidden" name="collection_id" value="<?php echo $collection['collection_id']; ?>">

        <button type="submit">Update</button>
    </form>

    <div>
        <?php
            // Fetch flowers in the collection from the database
            $flowersQuery = "SELECT flowers.* FROM flowers
                            JOIN collection_flower ON flowers.flower_id = collection_flower.flower_id
                            WHERE collection_flower.collection_id = $collectionId";
            $flowersResult = $conn->query($flowersQuery);

            if (!$flowersResult) {
                die("Error fetching flowers in collection: " . $conn->error);
            }
            ?>

            <h2>Flowers in Collection</h2>

            <?php
            if ($flowersResult->num_rows > 0) {
                while ($flower = $flowersResult->fetch_assoc()) {
                    $image_url = $flower['flower_picture'];
                    ?>
                    <img src="<?php echo $image_url; ?>" alt="Flower Image">
                    <?php
                }
            } else {
                echo '<p>No flowers in this collection.</p>';
            }
        ?>
    </div>



    <a class=buttonify href="flowers.php?collection_id=<?php echo $collectionId; ?>">Add Items</a>
</body>
</html>
