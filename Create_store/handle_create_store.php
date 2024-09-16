<?php
include('../Connection/connection.php');
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['logged_in'] != true || !isset($_SESSION['can_access_create_page']) || $_SESSION['can_access_create_page'] != true) {
    header('Location: website_buildup.php');
    exit();
}

unset($_SESSION['can_access_create_page']);

function getCssVariables($theme) {
    $cssFile = "../User_Stores/$theme/css/style.css";
    $scssFile = "../User_Stores/$theme/scss/style.scss";

    if (file_exists($cssFile)) {
        $cssContent = file_get_contents($cssFile);
        if (preg_match_all('/--(.*?):\s*([^;]*)/', $cssContent, $matches)) {
            return array_combine($matches[1], $matches[2]);
        }
    }

    if (file_exists($scssFile)) {
        $scssContent = file_get_contents($scssFile);
        if (preg_match_all('/\$([a-zA-Z0-9_-]+):\s*([^;]*)/', $scssContent, $matches)) {
            return array_combine($matches[1], $matches[2]);
        }
    }

    return [];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_SESSION['user_id'];
    $category = $_POST['category'];
    $storeName = $_POST['storeName'];
    $storeName = str_replace(' ', '_', $storeName);
    $preview_image = $_POST['preview_image'];
    $template = $_POST['template_checked'];
    $newTemplateName = $storeName . '_' . $template; 

    $variables = getCssVariables($newTemplateName);

    function duplicateTemplate($templateName, $newDir) {
        $source = "../Templates/$templateName";
        $destination = "../User_Stores/$newDir";

        if (!is_dir($source)) {
            return false;
        }

        $dir = opendir($source);
        @mkdir($destination);

        while (false !== ($file = readdir($dir))) {
            if ($file != '.' && $file != '..') {
                if (is_dir("$source/$file")) {
                    duplicateTemplate("$templateName/$file", "$newDir/$file");
                } else {
                    copy("$source/$file", "$destination/$file");
                }
            }
        }
        closedir($dir);
        return true;
    }

    // Duplicate the selected template
    if (!duplicateTemplate($template, $newTemplateName)) {
        echo "Failed to duplicate template.";
        exit();
    }

    // Handle logo upload
    if (isset($_FILES['storeLogo']) && $_FILES['storeLogo']['error'] == UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['storeLogo']['tmp_name'];
        $fileName = $_FILES['storeLogo']['name'];
        $fileSize = $_FILES['storeLogo']['size'];
        $fileType = $_FILES['storeLogo']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        $allowedfileExtensions = array('jpg', 'gif', 'png', 'jpeg');
        if (in_array($fileExtension, $allowedfileExtensions) && $fileSize < 5000000) {
            $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
            $uploadFileDir = '../User_Uploads/';
            $dest_path = $uploadFileDir . $newFileName;

            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                $baseURL = "http://localhost/Aptech_vision/User_Uploads/";
                $logoURL = $baseURL . $newFileName;
                $store_baseURL = "http://localhost/Aptech_vision/User_Stores/";
                $store_path = $store_baseURL . $newTemplateName;

                $stmt = $conn->prepare("INSERT INTO store (name, category, logo, preview_image, template, path, created_by) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("ssssssi", $storeName, $category, $logoURL, $preview_image, $newTemplateName, $store_path, $id);

                if ($stmt->execute()) {
                    $last_id = $conn->insert_id;
                    header('Location: ./dashboard.php?id=' . $last_id);
                } else {
                    echo "Error: " . $stmt->error;
                }
                $stmt->close();
            } else {
                echo "There was an error moving the uploaded file.";
            }
        } else {
            echo "Upload failed. Allowed file types: " . implode(',', $allowedfileExtensions) . ". Max file size: 5MB.";
        }
    } else {
        echo "Error: " . $_FILES['storeLogo']['error'];
    }
}

$conn->close();
?>