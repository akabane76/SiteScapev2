<div class="modal" id="updatecatModal">
    <div class="modal-content">
        <span class="close"></span>
        <form action="../res/insert.php" class="catsite" method="post" enctype="multipart/form-data">
            <div class="cat-card">
                <p class="card-des">
                    <input name="upcat_id" placeholder="Cat Name" class="input-style input-width" type="text" hidden>
                    <input name="upcat_name" placeholder="Cat Name" class="input-style input-width" type="text">
                    <button name="updatecatdata" class="submitbutton">update</button>
                </p>
            </div>
        </form>
    </div>
</div>