<?php
include 'dbcon.php';

if (isset($_POST['uploaddata'])) {
    date_default_timezone_set('Asia/Manila');
    $fileName = $_FILES["icon"]["name"];
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $newFileName = date("Y.m.d") . " - " . date("h.i.sa") . "." . $fileExtension;

    $targetDirectory = "../images/" . $newFileName;
    move_uploaded_file($_FILES['icon']['tmp_name'], $targetDirectory);

    // Retrieve form data
    $siteName = $_POST['site_name'];
    $siteCompany = $_POST['site_company'];
    $siteLink = $_POST['site_link'];
    $categoryId = $_POST['categories']; // Assuming 'categories' is the name of the select element

    // Construct and execute SQL query
    $insertQuery = "INSERT INTO `sites`(`category_id`, `site_name`, `site_company`, `site_link`, `site_image`) 
                    VALUES (:category_id, :site_name, :site_company, :site_link, :site_image)";
    $stmt = $dbh->prepare($insertQuery);
    $stmt->bindParam(':category_id', $categoryId);
    $stmt->bindParam(':site_name', $siteName);
    $stmt->bindParam(':site_company', $siteCompany);
    $stmt->bindParam(':site_link', $siteLink);
    $stmt->bindParam(':site_image', $newFileName);

    try {
        $stmt->execute();
        echo "Data inserted successfully!";
        header('location: ../uploadaksdaeuoqwjddkhfsufhuiewrj843jdiajsdaeiruiejsieuoeirjwifuhishduhfseifuhsidjfsieufhsihfuiefhisehfsehfisehfieufhsifiseufhisfhsiefuisefhsiefhisefhisufhweajdsyfi');
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

if (isset($_POST['updatedata'])) {
    date_default_timezone_set('Asia/Manila');
    $fileName = $_FILES["icon2"]["name"];
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $newFileName = date("Y.m.d") . " - " . date("h.i.sa") . "." . $fileExtension;

    $targetDirectory = "../images/" . $newFileName;
    move_uploaded_file($_FILES['icon2']['tmp_name'], $targetDirectory);

    // Retrieve form data
    $siteid = $_POST['site_id'];
    $siteName = $_POST['site_name'];
    $siteCompany = $_POST['site_company'];
    $siteLink = $_POST['site_link'];
    $categoryId = $_POST['categories']; // Assuming 'categories' is the name of the select element

    // Check if there is no file associated
    if (empty($_FILES["icon2"]["name"])) {
        // Construct and execute SQL query without updating image
        $updateQuery = "UPDATE `sites` SET `category_id` = :category_id, `site_name` = :site_name, `site_company` = :site_company, `site_link` = :site_link WHERE `site_id` = :site_id";
        $stmt = $dbh->prepare($updateQuery);
        $stmt->bindParam(':category_id', $categoryId);
        $stmt->bindParam(':site_name', $siteName);
        $stmt->bindParam(':site_company', $siteCompany);
        $stmt->bindParam(':site_link', $siteLink);
        $stmt->bindParam(':site_id', $siteid);
    } else {
        // Construct and execute SQL query with updating image
        $updateQuery = "UPDATE `sites` SET `category_id` = :category_id, `site_name` = :site_name, `site_company` = :site_company, `site_link` = :site_link, `site_image` = :site_image WHERE `site_id` = :site_id";
        $stmt = $dbh->prepare($updateQuery);
        $stmt->bindParam(':category_id', $categoryId);
        $stmt->bindParam(':site_name', $siteName);
        $stmt->bindParam(':site_company', $siteCompany);
        $stmt->bindParam(':site_link', $siteLink);
        $stmt->bindParam(':site_image', $newFileName);
        $stmt->bindParam(':site_id', $siteid);
    }

    try {
        $stmt->execute();
        echo "Data updated successfully!";
        // Redirect after successful execution
        header('Location: ../uploadaksdaeuoqwjddkhfsufhuiewrj843jdiajsdaeiruiejsieuoeirjwifuhishduhfseifuhsidjfsieufhsihfuiefhisehfsehfisehfieufhsifiseufhisfhsiefuisefhsiefhisefhisufhweajdsyfi');
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}



?>