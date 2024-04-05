<div class="modal" id="uploadModal">
    <div class="modal-content">
        <span class="close"></span>
        <form action="../res/insert.php" class="uploadsite" method="post" enctype="multipart/form-data">
            <div class="card">
                <div class="card-image-container">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 1024 1024"
                        stroke-width="0" fill="currentColor" stroke="currentColor" class="image-icon" id="svg">
                        <path
                            d="M928 160H96c-17.7 0-32 14.3-32 32v640c0 17.7 14.3 32 32 32h832c17.7 0 32-14.3 32-32V192c0-17.7-14.3-32-32-32zM338 304c35.3 0 64 28.7 64 64s-28.7 64-64 64-64-28.7-64-64 28.7-64 64-64zm513.9 437.1a8.11 8.11 0 0 1-5.2 1.9H177.2c-4.4 0-8-3.6-8-8 0-1.9.7-3.7 1.9-5.2l170.3-202c2.8-3.4 7.9-3.8 11.3-1 .3.3.7.6 1 1l99.4 118 158.1-187.5c2.8-3.4 7.9-3.8 11.3-1 .3.3.7.6 1 1l229.6 271.6c2.6 3.3 2.2 8.4-1.2 11.2z">
                        </path>
                    </svg>
                    <img id="blah" src="#" alt="your image" />
                </div>
                <p class="card-title">
                    <input accept="image/*" type='file' id="imgInp" name="icon" />
                </p>
                <p class="card-des">
                    <input name="site_name" placeholder="Site Name" class="input-style input-width" type="text">
                    <input name="site_company" placeholder="Company" class="input-style input-width" type="text">
                    <input name="site_link" placeholder="Link" class="input-style input-width" type="text">
                    <select name="categories" id="selectcategories" class="input-style ">
                        <?php
                        $categoriesquery = "SELECT * FROM categories";
                        try {
                            $categoriesresult = $dbh->query($categoriesquery);
                            while ($categoriesrow = $categoriesresult->fetch(PDO::FETCH_ASSOC)) {
                                echo '<option value="' . $categoriesrow['category_id'] . '" >' . $categoriesrow['category_name'] . '</option>';
                            }
                        } catch (PDOException $e) {
                            echo "Error: " . $e->getMessage();
                        }
                        ?>
                    </select>
                    <button name="uploaddata" class="submitbutton">Submit</button>
                </p>
            </div>
        </form>
    </div>
</div>