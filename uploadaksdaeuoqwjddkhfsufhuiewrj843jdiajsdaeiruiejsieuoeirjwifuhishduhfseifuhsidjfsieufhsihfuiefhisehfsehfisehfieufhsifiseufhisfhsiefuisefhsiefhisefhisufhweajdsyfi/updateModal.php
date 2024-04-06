<div class="modal" id="updateModal">
        <div class="modal-content">
            <span class="close"></span>
            <form action="../res/insert.php" class="uploadsite" method="post" enctype="multipart/form-data">
                <div class="card">
                    <div class="card-image-container">
                        <img id="blah2" src="#" alt="your image" />
                    </div>
                    <p class="card-title">
                        <input accept="image/*" type='file' id="imgInp2" name="icon2" />
                    </p>
                    <p class="card-des">
                        <input name="site_id" placeholder="Site id" class="input-style input-width" type="text" hidden>
                        <input name="site_name" placeholder="Site Name" class="input-style input-width" type="text">
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
                        <button name="updatedata" class="submitbutton">Update</button>
                    </p>
                </div>
            </form>
        </div>
    </div>
    <script>
        imgInp2.onchange = evt => {
            const [file] = imgInp2.files
            if (file) {
                blah2.src = URL.createObjectURL(file)
                blah2.onload = () => {
                    blah2.style.display = 'block'
                    blah2.style.width = '100%'
                    svg.style.display = 'none'
                }
            }
        }
    </script>