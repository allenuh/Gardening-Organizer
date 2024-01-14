<?php
if (isset($_GET['collection_id'])) {
    $collectionId = $_GET['collection_id'];
} else {
    header("Location: home.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style_flowers.css">
    <title>Flower Images</title>
</head>


<body>
    <div class="container">
        <div class="gallery-container"> 
            <?php
            // connect to the database
            include "db_conn.php";
            // check the connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // fetch flower data from the database
            $sql = "SELECT flower_id, flower_picture, flower_name, flower_description FROM flowers";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // index
                $index = 0;
                // fetching all the data by row
                while ($row = $result->fetch_assoc()) {
                    $flower_id = $row['flower_id'];
                    $image_url = $row['flower_picture'];
                    $flower_name = $row['flower_name'];
                    $flower_description = $row['flower_description'];
                    $index++;
            ?>
                    <div class="gallery-item" data-index="<?php echo $index; ?>" data-description="<?php echo $flower_description; ?>" data-flower-id="<?php echo $flower_id; ?>">
                        <?php echo $flower_name; ?>
                        <img src="<?php echo $image_url; ?>" alt="">
                    </div>

            <?php
                }
            } else {
                echo "0 results";
            }
            // close the database connection
            $conn->close();
            ?>

        </div>
    </div>

    <!--javascript-->
    <script>
        const galleryItem = document.getElementsByClassName("gallery-item");
        // create element for lightbox
        const lightBoxContainer = document.createElement("div");
        // for container/area
        const lightBoxContent = document.createElement("div");
        // for images
        const lightBoxImage = document.createElement("img");
        // previous button
        const lightBoxPrev = document.createElement("div");
        const prevButtonImg = document.createElement("img");
        // next button
        const lightBoxNext = document.createElement("div");
        const nextButtonImg = document.createElement("img");
        // flower description
        const lightBoxDescription = document.createElement("div");
        // container for content and description
        const lightBoxContentContainer = document.createElement("div");
        
        // set prev and next pngs as object
        prevButtonImg.src = "images/prev.png";
        nextButtonImg.src = "images/next.png";

        prevButtonImg.alt = "Previous";
        nextButtonImg.alt = "Next";
        //////

        // classList
        lightBoxContainer.classList.add('lightbox');
        lightBoxContent.classList.add('lightbox-content');
        lightBoxPrev.classList.add("lightbox-prev");
        lightBoxNext.classList.add("lightbox-next");
        lightBoxDescription.classList.add("lightbox-description");
        lightBoxContentContainer.classList.add("lightbox-content-container");
        //////

        // appendChild
        lightBoxContainer.appendChild(lightBoxContentContainer);
        lightBoxContentContainer.appendChild(lightBoxContent);
        lightBoxContent.appendChild(lightBoxImage);
        lightBoxContent.appendChild(lightBoxPrev);
        lightBoxContent.appendChild(lightBoxNext);   
        lightBoxPrev.appendChild(prevButtonImg);
        lightBoxNext.appendChild(nextButtonImg);
        lightBoxContentContainer.appendChild(lightBoxDescription);
        document.body.appendChild(lightBoxContainer);
        //////
        
        let index = 1;

        // create function
        function showLightBox(n){
            if (n > galleryItem.length){
                index = 1;
            }
            else if (n < 1){
                index = galleryItem.length;
            }
            let imageLocation = galleryItem[index-1].children[0].getAttribute("src");
            let description = galleryItem[index - 1].getAttribute("data-description");
            let flowerId = galleryItem[index - 1].getAttribute("data-flower-id"); 

            lightBoxImage.setAttribute("src", imageLocation);
            lightBoxDescription.innerHTML = description + '<a href="add_to_collection.php?flower_id=' + galleryItem[index - 1].getAttribute("data-flower-id") + '&collection_id=' + <?php echo $collectionId; ?> + '">Add to Collection</a>';
        }

        function currentImage(){
            lightBoxContainer.style.display="block";

            let imageIndex = parseInt(this.getAttribute("data-index"));
            showLightBox(index = imageIndex);
        }

        for (let i = 0; i < galleryItem.length; i++){
            galleryItem[i].addEventListener("click", currentImage);
        }

        function sliderImage(n){
            showLightBox(index +=n);
        }

        function prevImage(){
            sliderImage(-1);
        }
        
        function nextImage(){
            sliderImage(1);
        }

        lightBoxPrev.addEventListener("click", prevImage);
        lightBoxNext.addEventListener("click", nextImage);

        // close lightbox
        function closeLightBox(){
            if (this === event.target){
                lightBoxContainer.style.display = "none";
            }
        }

        lightBoxContainer.addEventListener("click", closeLightBox);
        //lightBoxContentContainer.addEventListener("click", closeLightBox);
        
    </script>
</body>
</html>
