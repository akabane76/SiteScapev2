<?php
include ('res/dbcon.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./res/style2.css">
    <title>Sitescape</title>
</head>

<body>
    <div class="search-bar">
        <div class="search-bar-center">
            <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for names.."
                title="Type in a name">
            <select name="categories" id="selectcategories" class="input-style" onchange="filterSites()">
                <?php
                $categoriesquery = "SELECT * FROM categories WHERE category_name != 'Hidden Site';";
                try {
                    echo '<option value="0">All category</option>'; // Set value as 0 for All category
                    $categoriesresult = $dbh->query($categoriesquery);
                    while ($categoriesrow = $categoriesresult->fetch(PDO::FETCH_ASSOC)) {
                        echo '<option value="' . $categoriesrow['category_id'] . '">' . $categoriesrow['category_name'] . '</option>';
                    }
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
                ?>
            </select>
        </div>
    </div>

    <!-- Page content -->
    <div class="content" id="myUL">
        <?php
        // Fetch all sites initially
        $sqlSites = "SELECT sites.*, categories.category_id
                    FROM sites
                    JOIN categories ON sites.category_id = categories.category_id
                    WHERE categories.category_name != 'Hidden Site';";
        $querySites = $dbh->query($sqlSites);
        $sites = $querySites->fetchAll(PDO::FETCH_OBJ);

        // Display each site
        foreach ($sites as $site) {
            ?>

            <div class="tab" data-cat="<?php echo htmlentities($site->category_id); ?>">
                <div class="site" href="<?php echo htmlentities($site->site_link); ?>">
                    <img src="./images/<?php echo htmlentities($site->site_image); ?>" alt="Site Icon" loading="lazy">
                    <p><?php echo htmlentities($site->site_name); ?></p>
                </div>
            </div>
            <!-- End of repeating block -->
            <?php
        }
        ?>
    </div>
    <script>
        function myFunction() {
            var input, filter, divs, div, p, i, txtValue;
            input = document.getElementById("myInput");
            filter = input.value.toUpperCase();
            divs = document.getElementsByClassName("tab");
            for (i = 0; i < divs.length; i++) {
                p = divs[i].getElementsByTagName("p")[0];
                txtValue = p.textContent || p.innerText;
                div = divs[i];
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    div.style.display = "";
                } else {
                    div.style.display = "none";
                }
            }
        }

        function filterSites() {
            var select = document.getElementById("selectcategories");
            var selectedCategoryId = select.value;
            var tabs = document.getElementsByClassName("tab");

            for (var i = 0; i < tabs.length; i++) {
                var category = tabs[i].getAttribute("data-cat");
                if (selectedCategoryId === "0" || category === selectedCategoryId) {
                    tabs[i].style.display = "";
                } else {
                    tabs[i].style.display = "none";
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
                var href = this.getAttribute('href');
                // If the href is not null or empty, open it in a new tab
                if (href && href.trim() !== '') {
                    window.open(href, '_blank');
                }
            });
        });
    </script>
</body>

</html>
