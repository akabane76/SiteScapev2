<?php
include ('../res/dbcon.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../res/style.css">
    <title>SiteScape</title>
</head>

<body>
    <!-- sidebar content -->
    <div class="sidebar">
        <ul class="nav-links">
            <li class="active">
                <i class="bx bx-grid-alt"></i>
                <span class="links_name">All Sites</span>
            </li>
            <?php
            $sql = "SELECT DISTINCT category_name, category_id FROM categories ORDER BY CASE WHEN category_name = 'Hidden Site' THEN 1 ELSE 0 END, category_name;";
            $query = $dbh->prepare($sql);
            $query->execute();
            $results = $query->fetchAll(PDO::FETCH_OBJ);
            if ($query->rowCount() > 0) {
                foreach ($results as $result) { ?>
                    <li>
                        <i class="bx bx-box"></i>
                        <span class="links_name categoryList" catdata="<?php echo htmlentities($result->category_id); ?>">
                            <?php echo htmlentities($result->category_name); ?>
                        </span>
                    </li>
                <?php }
            } ?>
        </ul>
    </div>

    <!-- Page content -->
    <div class="content">
        <!-- all Sites -->
        <div class="tab active">
            <?php
            // Fetch all categories
            $sqlCategories = "SELECT *
            FROM categories
            ORDER BY CASE WHEN category_name = 'Hidden Site' THEN 1 ELSE 0 END, category_name;";
            $queryCategories = $dbh->prepare($sqlCategories);
            $queryCategories->execute();
            $categories = $queryCategories->fetchAll(PDO::FETCH_OBJ);

            // Loop through each category
            foreach ($categories as $category) { ?>
                <h2>
                    <?php echo htmlentities($category->category_name); ?>
                </h2>
                <div class="sites-container">
                    <?php
                    // Fetch sites belonging to the current category
                    $categoryId = $category->category_id;
                    $sqlSites = "SELECT * FROM sites WHERE category_id = :category_id";
                    $querySites = $dbh->prepare($sqlSites);
                    $querySites->bindParam(':category_id', $categoryId, PDO::PARAM_INT);
                    $querySites->execute();
                    $sites = $querySites->fetchAll(PDO::FETCH_OBJ);

                    // Display each site
                    $siteCount = 0;
                    foreach ($sites as $site) {
                        // Check if it's the first site in a row
                        if ($siteCount % 5 == 0) {
                            echo '<div class="row">';
                        } ?>
                        <div class="site" href="<?php echo htmlentities($site->site_link); ?>"
                            data="<?php echo htmlentities($site->site_id); ?>">
                            <img src="../images/<?php echo htmlentities($site->site_image); ?>" alt="Site Icon" loading="lazy">
                            <p>
                                <?php echo htmlentities($site->site_name); ?>
                            </p>

                        </div>
                        <?php
                        // Check if it's the last site in a row or the last site overall
                        if (($siteCount + 1) % 5 == 0 || $siteCount == count($sites) - 1) {
                            echo '</div>'; // Close the row div
                        }
                        $siteCount++;
                    } ?>
                </div>
            <?php } ?>
        </div>

        <!-- devided by CategoryName -->
        <?php
        $sqlCategories = "SELECT DISTINCT category_name, category_id FROM categories ORDER BY CASE WHEN category_name = 'Hidden Site' THEN 1 ELSE 0 END, category_name;";
        $queryCategories = $dbh->prepare($sqlCategories);
        $queryCategories->execute();
        $categories = $queryCategories->fetchAll(PDO::FETCH_OBJ);
        if ($queryCategories->rowCount() > 0) {
            foreach ($categories as $category) {
                ?>
                <div class="tab <?php echo $category->category_name; ?>">
                    <h2>
                        <?php echo htmlentities($category->category_name); ?>
                    </h2>
                    <div class="sites-container"> <!-- Added container for sites -->
                        <?php
                        $categoryId = $category->category_id;
                        $sqlSites = "SELECT * FROM sites WHERE category_id = :category_id";
                        $querySites = $dbh->prepare($sqlSites);
                        $querySites->bindParam(':category_id', $categoryId, PDO::PARAM_INT);
                        $querySites->execute();
                        $sites = $querySites->fetchAll(PDO::FETCH_OBJ);
                        if ($querySites->rowCount() > 0) {
                            $siteCount = 0; // Counter to determine the number of sites per row
                            foreach ($sites as $site) {
                                if ($siteCount % 5 == 0) { // Start a new row for every 5 sites
                                    echo '<div class="row">';
                                }
                                ?>
                                <div class="site" href="<?php echo htmlentities($site->site_link); ?>"
                                    data="<?php echo htmlentities($site->site_id); ?>">
                                    <img src="../images/<?php echo htmlentities($site->site_image); ?>" alt="Site Icon" loading="lazy">
                                    <p>
                                        <?php echo htmlentities($site->site_name); ?>
                                    </p>
                                </div>
                                <?php
                                $siteCount++;
                                if ($siteCount % 5 == 0) { // Close the row after every 5 sites
                                    echo '</div>';
                                }
                            }
                            // Close the row if it's not filled with 5 sites
                            if ($siteCount % 5 != 0) {
                                echo '</div>';
                            }
                        } ?>
                    </div>
                </div>
            <?php }
        } ?>
    </div>

    <div class="files">
        <button class="tooltip user-data-button" id="categorybtn">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="37px"
                height="37px">
                <image x="0px" y="0px" width="37px" height="37px"
                    xlink:href="data:img/png;base64,iVBORw0KGgoAAAANSUhEUgAAACoAAAAqCAQAAABvygHQAAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAAAAmJLR0QA/4ePzL8AAAAHdElNRQfoBAUSHxrbB+VHAAADP0lEQVRIx63XXYiUZRQH8N/OTkKtuppBViCuiVtghasmmKthEFlRV0aUUSQp9IERFnQdlJDQTWgJInjTRfSh9oVFlGGIXQR9mK6wm1Zmme6a7sfMNnO6mFl3392dmXd2/T9X55zn+b/nOWf+z/NMg1po1KLV9ZrQ6w8duhRqrqqIZuvt0S1GjW4fetL0+glbbNc3hm7k6LPN3PSETbbIl5f+abcN2s0100wtVtpgt9PlaM6rrkpD2ea4EIo+co/GCnVe42NFIXRYVIvyYQNC+FZbzc8vcUgI/R6qNm2jgpC3WSZVoTJeMigUbKicZUHocWf68mO180Jh/GwXGRB6LK6LslSG80K/20YHmnQI+TqzHMJdBoWjrky6XxPC5glRwstCeGWka66ccDBle8ZDxmFhwJxh1zahmOJHVA23C+HNIXO6XmHfpCjhE6HXtJKxXgh3jwjPcEQIvR7EO2XtjB1fJxS3RghPlIw9wqlEeOGlZa/jTMVDZdCMEauyTgvvk9VoJT5PnJE/WWsJur2N+zwgO852i77UM8L+zxcetUqG+UJ4atIVhY1CmJfRCo5cFtJfQGvWbHByVHiOBbjgsDDDonGPwPCjvxOeE2A2m4RIFJw5+suteBE/V2zUmVHCnCmETRkNVTcUdUXLdtYFMC3Rx5MWaMW/vsNybRW2/4P+hKd0GV7gfiEsn3yXsEII92YcAzdfFtISy7GsTuc1W2FnIrzWPOTt0mNZxVP2e/sTdjt6/Ap7hd8Tx15Spv+klGmjU8IHZLAPN1g9IvxbWQy9vsF+xQqZHiy3uYTVriuzoVlf6QuTxF6hfzj3HUJx7MVVF9oUhe3DjhvlhQM1hFANDQ4KueTramtJYBMmfUEIW5LOqTqFnDsmRNkuLxzXNDqwVE4465a6KW91ThgY/+J8TFE4W6dk250Tih6pNGGTojDguZQta/C8nFD0bLVpj5efu19ZmGLbB8pP33W1pi7TJYSCd7VXyLjBKu8pCKHT0jSbmu4Ng2V1d3nLOovNMsUU11hsnR1OXNL+1qHHQxossEuu6h+JnJ3mpyccwizP+MzFMXQXfeppV1frXy1c4SatrjUVF/3lqGMGqy/5H4BFhtYreBmkAAAAAElFTkSuQmCC" />
            </svg>
            <span class="tooltiptext">Category</span>
        </button><br>
        <button class="tooltip user-data-button" id="uploadbtn">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="36px"
                height="30px">
                <image x="0px" y="0px" width="36px" height="30px"
                    xlink:href="data:img/png;base64,iVBORw0KGgoAAAANSUhEUgAAAC4AAAAoCAQAAAAr6QChAAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAAAAmJLR0QA/4ePzL8AAAAHdElNRQfoBAUSIjKEWgUDAAAAn0lEQVRIx+3XQQrCQAyF4a8i9UjqCW29lniU1lsYVy24UFEzgjovEMjm581bJAwre6NIrlGvZZ8OnqpjFNaytRUGQoCjw9wzFGIxD2cx9yQ1Ak16LMQEL6TF+4jbWqJYLEWdV3iFV3iFl9C/7PNnTmLpfb68cnVPL1yrDzkvcEdr5g+c/1Lmb7/lmzM/YZPO3WKkL/bh2tHqDOngwU57ASW1yxoLlPnLAAAAAElFTkSuQmCC" />
            </svg>
            <span class="tooltiptext">Upload</span>
        </button>
    </div>

    <?php include './updatecatModal.php'; ?>
    <?php include './catModal.php'; ?>
    <?php include './updateModal.php'; ?>
    <?php include './insertModal.php'; ?>

    <!-- JavaScript for tab navigation -->
    <script>
        var svg = document.getElementById('svg');

        imgInp.onchange = evt => {
            const [file] = imgInp.files
            if (file) {
                blah.src = URL.createObjectURL(file)
                blah.onload = () => {
                    blah.style.display = 'block'
                    blah.style.width = '100%'
                    svg.style.display = 'none'
                }
            }
        }

        // Add click event listener to each .site element
        var siteElements = document.querySelectorAll('.site');
        siteElements.forEach(function (site) {
            site.addEventListener('click', function (event) {
                // Prevent the default action of the click event
                event.preventDefault();
                // Get the href attribute of the clicked site
                var updateModal = document.getElementById("updateModal");
                var data = this.getAttribute('data');
                // If the href is not null or empty, open it in a new tab
                if (data && data.trim() !== '') {
                    console.log("User ID clicked:", data);

                    // Send AJAX request
                    var xhr = new XMLHttpRequest();
                    xhr.open("GET", "../res/getData.php?site_id=" + data, true);
                    xhr.onreadystatechange = function () {
                        if (xhr.readyState == 4 && xhr.status == 200) {
                            var userData = JSON.parse(xhr.responseText);
                            console.log("Received data:", userData);

                            // Populate input fields with data
                            document.querySelector("#selectcategories").value = userData.category_id;
                            document.querySelector("input[name='site_name']").value = userData.site_name;
                            document.querySelector("input[name='site_link']").value = userData.site_link;
                            document.querySelector("input[name='site_id']").value = userData.site_id;

                            // Set src attribute of the image
                            var blah2 = document.getElementById('blah2');
                            blah2.src = '../images/' + userData.site_image;
                            blah2.style.display = 'block';
                            blah.style.width = '100%'
                            svg.style.display = 'none'

                        }
                    };
                    xhr.send();

                    // Show modal
                    updateModal.style.display = "block";
                }
            });
        });


        // Add click event listener to each .site element
        var catElements = document.querySelectorAll('.categoryList');
        catElements.forEach(function (categoryList) {
            categoryList.addEventListener('click', function (event) {
                // Prevent the default action of the click event
                event.preventDefault();
                // Get the href attribute of the clicked site

                var updatecatModal = document.getElementById("updatecatModal");
                var catdata = this.getAttribute('catdata');
                // If the href is not null or empty, open it in a new tab
                if (catdata && catdata.trim() !== '') {
                    console.log("cat ID clicked:", catdata);

                    // Send AJAX request
                    var xhr = new XMLHttpRequest();
                    xhr.open("GET", "../res/getcatData.php?cat_id=" + catdata, true);
                    xhr.onreadystatechange = function () {
                        if (xhr.readyState == 4 && xhr.status == 200) {
                            var cat2Data = JSON.parse(xhr.responseText);
                            console.log("Received data:", cat2Data);

                            // Populate input fields with data
                            document.querySelector("input[name='upcat_id']").value = cat2Data.category_id;
                            document.querySelector("input[name='upcat_name']").value = cat2Data.category_name;

                        }
                    };
                    xhr.send();

                    // Show modal
                    updatecatModal.style.display = "block";
                }
               
            });
        });


        var catModal = document.getElementById("catModal");
        var categorybtn = document.getElementById("categorybtn");

        categorybtn.onclick = function () {
            catModal.style.display = "block";
            document.body.classList.add("modal-open");
        }

        var uploadModal = document.getElementById("uploadModal");
        var uploadbtn = document.getElementById("uploadbtn");
        var uploadSpan = document.getElementsByClassName("close");

        uploadbtn.onclick = function () {
            uploadModal.style.display = "block";
            document.body.classList.add("modal-open");
        }

        uploadSpan.onclick = function () {
            uploadModal.style.display = "none";
            document.body.classList.remove("modal-open");
        }

        // Close modal when clicking outside
        window.onclick = function (event) {
            if (event.target == uploadModal) {
                uploadModal.style.display = "none";
                svg.style.display = 'block';
                document.body.classList.remove("modal-open");
            }
            if (event.target == updateModal) {
                updateModal.style.display = "none";
                svg.style.display = 'block'
                document.body.classList.remove("modal-open");
            }
            if (event.target == catModal) {
                catModal.style.display = "none";
                document.body.classList.remove("modal-open");
            }
            if (event.target == updatecatModal) {
                updatecatModal.style.display = "none";
                document.body.classList.remove("modal-open");
            }
        }


        // Get all tab buttons
        var tabButtons = document.querySelectorAll('.nav-links li');

        var updatecatModal = document.getElementById("updatecatModal");

        // Get all tab contents
        var tabContents = document.querySelectorAll('.tab');

        // Add click event listener to each tab button
        tabButtons.forEach(function (button, index) {
            button.addEventListener('click', function () {
                // Remove 'active' class from all tab buttons and contents
                tabButtons.forEach(function (btn) {
                    btn.classList.remove('active');
                });
                tabContents.forEach(function (content) {
                    content.classList.remove('active');
                });

                // Add 'active' class to the clicked tab button
                this.classList.add('active');

                // Display the corresponding tab content based on its index
                tabContents[index].classList.add('active');
            });
        });

    </script>
</body>

</html>