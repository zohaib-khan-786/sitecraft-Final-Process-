<?php
include('../Connection/connection.php');

if (isset($_GET['id'])) {
    $store_id = $_GET['id'];
    
    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        $store_name = $_POST['newStoreName'];

        // Check if the new store name already exists
        $check_sql = "SELECT id FROM store WHERE name = ? AND id != ?";
        if ($check_stmt = $conn->prepare($check_sql)) {
            // Bind parameters
            $check_stmt->bind_param("si", $store_name, $store_id);
            $check_stmt->execute();
            $check_stmt->store_result();
            
            if ($check_stmt->num_rows > 0) {
                // Store name already exists
                echo "Error: Store name is already taken. Please choose a different name.";
            } else {
                // Get current store details for renaming the directory
                $old_store_sql = "SELECT name, template FROM store WHERE id = ?";
                if ($old_store_stmt = $conn->prepare($old_store_sql)) {
                    $old_store_stmt->bind_param("i", $store_id);
                    $old_store_stmt->execute();
                    $old_store_stmt->bind_result($old_store_name, $template);
                    $old_store_stmt->fetch();
                    $old_store_stmt->close();
                    
                    // Construct old and new directory paths
                    $oldDir = "../User_Stores/{$template}";
                    $newTemplateName = $store_name . '_' . substr($template, strpos($template, '_') + 1); // New template name with updated store name
                    $newDir = "../User_Stores/{$newTemplateName}";

                    // Update the store name in the database
                    $update_sql = "UPDATE store SET name = ? WHERE id = ?";
                    if ($update_stmt = $conn->prepare($update_sql)) {
                        $update_stmt->bind_param("si", $store_name, $store_id);
                        
                        if ($update_stmt->execute()) {
                            // Rename the directory
                            if (is_dir($oldDir)) {
                                if (rename($oldDir, $newDir)) {
                                    // Update the store path in the database
                                    $update_path_sql = "UPDATE store SET template = ?, path = ? WHERE id = ?";
                                    if ($update_path_stmt = $conn->prepare($update_path_sql)) {
                                        $newPath = "http://localhost:82/Aptech_vision/User_Stores/{$newTemplateName}";
                                        $update_path_stmt->bind_param("ssi", $newTemplateName, $newPath, $store_id);
                                        $update_path_stmt->execute();
                                        $update_path_stmt->close();
                                    } else {
                                        echo "Error preparing path update statement: " . $conn->error;
                                    }
                                    
                                    // Redirect to the desired page
                                    header('Location: website_buildup.php');
                                    exit();
                                } else {
                                    echo "Failed to rename directory. Error: " . error_get_last()['message'];
                                }
                            } else {
                                echo "Old directory does not exist.";
                            }
                        } else {
                            echo "Error executing query: " . $update_stmt->error;
                        }
                        // Close the statement
                        $update_stmt->close();
                    } else {
                        echo "Error preparing statement: " . $conn->error;
                    }
                } else {
                    echo "Error preparing statement: " . $conn->error;
                }
            }
            // Close the statement
            $check_stmt->close();
        } else {
            echo "Error preparing statement: " . $conn->error;
        }
    } else {
        echo "Invalid request method.";
    }
} else {
    echo "No store ID provided.";
}

// Close the database connection
$conn->close();
?>
