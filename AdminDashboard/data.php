<?php
session_start();
include "../Connection/connection.php";

// Ensure the admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch data from the database
$total_users_query = "select count(*) as count from users";
$total_users_result = $conn->query($total_users_query);
$total_users = $total_users_result->fetch_assoc()['count'];

$active_users_query = "select count(*) as count from users where Status_Update='active'";
$active_users_result = $conn->query($active_users_query);
$active_users = $active_users_result->fetch_assoc()['count'];

$non_active_users = $total_users - $active_users;

// Static profit value for now
$profit = 0;

// Query to get the counts
$publishedWebsites = 0;
$nonPublishedWebsites = 0;
$totalWebsites = 0;

$query = "select SUM(CASE when published = 1 then 1 else 0 END) AS published_count, SUM(CASE when published = 0 then 1 else 0 END) AS non_published_count, COUNT(*) AS total_count from store";

$result = mysqli_query($conn, $query);

if ($result) {
    $data = mysqli_fetch_assoc($result);
    $publishedWebsites = $data['published_count'];
    $nonPublishedWebsites = $data['non_published_count'];
    $totalWebsites = $data['total_count'];
} else {
    // Handle query failure
    echo "Error: " . mysqli_error($conn);
}

// Query to get the list of websites and their owners
$listQuery = "select store.id, store.name, store.category, store.published, users.username from store JOIN users ON store.created_by = users.id";

$listResult = mysqli_query($conn, $listQuery);

// Get the current month and year
$currentMonth = date('m');
$currentYear = date('Y');

// Query to get the number of users gained this month
$queryGained = "
    select count(*) AS gained from users where month(created_at) = ? and year(created_at) = ?
";
$stmt = $conn->prepare($queryGained);
$stmt->bind_param("ii", $currentMonth, $currentYear);
$stmt->execute();
$resultGained = $stmt->get_result();
$dataGained = $resultGained->fetch_assoc();
$usersGained = $dataGained['gained'];

// Query to get the number of users who deleted their accounts this month
$queryDecreased = "
    select count(*) AS decreased from users where month(deleted_at) = ? and year(deleted_at) = ?
";
$stmt->prepare($queryDecreased);
$stmt->bind_param("ii", $currentMonth, $currentYear);
$stmt->execute();
$resultDecreased = $stmt->get_result();
$dataDecreased = $resultDecreased->fetch_assoc();
$usersDecreased = $dataDecreased['decreased'];

//Query for Newly registered users
$newUsersQuery = "select username, email, created_at from users order by created_at desc limit 5"; 
$newUsersResult = mysqli_query($conn, $newUsersQuery);

// Query to get the users who deleted their accounts
$queryDeletedUsers = "select username, deleted_at from users where month(deleted_at) = ? and year(deleted_at) = ?";
$stmt = $conn->prepare($queryDeletedUsers);
$stmt->bind_param("ii", $currentMonth, $currentYear);
$stmt->execute();
$deletedUsersResult = $stmt->get_result();

$deletedUsers = [];
while ($row = $deletedUsersResult->fetch_assoc()) {
    $deletedUsers[] = $row;
}

$stmt->close();
$conn->close();
?>