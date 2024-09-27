<?php
session_start();
include('../Connection/connection.php');
$store_data = $_SESSION['store_data'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $scssFilePath = '../User_Stores/'.$store_data['template'].'/scss/style.scss';
    $cssFilePath = '../User_Stores/'.$store_data['template'].'/css/style.css';

    function updateVariables($filePath, $variables) {
        $content = file_get_contents($filePath);
        foreach ($variables as $variable => $value) {
            $content = preg_replace("/($variable:\s*)(.*?)(;)/", "$1$value$3", $content);
        }
        file_put_contents($filePath, $content);
    }

    function getVariables($theme, $variablesArray) {
        $cssFile = "../User_Stores/$theme/css/style.css";
        $scssFile = "../User_Stores/$theme/css/style.scss";
        $variables = [];

        if (file_exists($cssFile)) {
            $cssContent = file_get_contents($cssFile);
            foreach ($variablesArray as $var => $defaultValue) {
                if (preg_match("/--$var:\s*([^;]*)/", $cssContent, $match)) {
                    $variables[$var] = trim($match[1]);
                }
            }
        }

        if (count($variables) < count($variablesArray) && file_exists($scssFile)) {
            $scssContent = file_get_contents($scssFile);
            foreach ($variablesArray as $var => $defaultValue) {
                if (preg_match("/\$$var:\s*([^;]*)/", $scssContent, $match)) {
                    $variables[$var] = trim($match[1]);
                } elseif (!isset($variables[$var])) {
                    $variables[$var] = $defaultValue;
                }
            }
        }

        foreach ($variablesArray as $var => $defaultValue) {
            if (!isset($variables[$var])) {
                $variables[$var] = $defaultValue;
            }
        }

        return $variables;
    }

    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['theme'])) {
        $theme = $data['theme'];
        $stmt = $conn->prepare("UPDATE store SET theme = ? WHERE id = ?");
        $stmt->bind_param("si", $theme, $store_data['id']);
        if ($stmt->execute()) {
            $response = [
                'status' => 'success',
                'theme' => $theme,
                'message' => 'Theme updated successfully in the database'
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Failed to update theme in the database'
            ];
        }
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }

    $variablesArray = $data;
  

    updateVariables($scssFilePath, $variablesArray);
    updateVariables($cssFilePath, $variablesArray);


    $response = [
        'status' => 'success',
        'theme' => $theme,
        'message' => 'Theme settings updated successfully'
    ];

    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
?>
