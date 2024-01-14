<?php
session_start();
include "db_conn.php";

if (isset($_SESSION['id']) && isset($_SESSION['username'])){
    $userId = $_SESSION['id'];

    // Fetch user's collections from the database
    $query = "SELECT * FROM collections WHERE user_id = $userId";
    $result = $conn->query($query);

    if (!$result) {
        die("Error fetching collections: " . $conn->error);
    }

    $collections = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class=hello>
            Hello, <?php echo $_SESSION['name']; ?>
        </div>
        <div class=buttonify>
            <a href="logout.php">logout</a>
        </div>
    </header>
    <h2>Your collections:</h2>
    <div class=collection-container>
        <?php
        // Display user's collections
        if (!empty($collections)) {
            echo '<ul>';
            foreach ($collections as $collection) {
                echo '<li><a href="edit_collection.php?collection_id=' . $collection['collection_id'] . '">' . $collection['collection_name'] . '</a></li>';
            }
            echo '</ul>';
        } else {
            echo '<p>No collections yet.</p>';
        }
        ?>
    </div>


    <button id="openPopupBtn">Create Collection</button>
    <!-- Popup container -->
    <div id="popupContainer" class="popup-container">
        <form action="create_collection.php" method="post">
            <h2>CREATE COLLECTION</h2>
            <?php if (isset($_GET['error'])) { ?>
                <p class="error"><?php echo $_GET['error']; ?></p>
            <?php } ?>

            <label>Collection Name</label>
            <input type="text" name="cname"><br>

            <button type="submit">Create</button>
        </form>
        <button id="closePopupBtn">Close</button>
    </div>

    <script>
        // JavaScript to handle the popup behavior
        document.addEventListener('DOMContentLoaded', function() {
            var openPopupBtn = document.getElementById('openPopupBtn');
            var closePopupBtn = document.getElementById('closePopupBtn');
            var popupContainer = document.getElementById('popupContainer');

            openPopupBtn.addEventListener('click', function() {
                popupContainer.style.display = 'block';
            });

            closePopupBtn.addEventListener('click', function() {
                popupContainer.style.display = 'none';
            });
        });
    </script>
</body>
</html>

<?php
}
else{
    header("Location: index.php");
    exit();
}
?>