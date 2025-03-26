<?php
session_start();
require_once('../dataconnect.php');

// Handle filter and sort options
$filter_user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : '';
$filter_status = isset($_GET['status']) ? $_GET['status'] : '';
$sort_by = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'created_at';
$sort_order = isset($_GET['sort_order']) ? $_GET['sort_order'] : 'DESC';

// Build the SQL query with filters and sorting
$searchQuery = "SELECT * FROM user_queries WHERE 1=1";
if ($filter_user_id) {
    $searchQuery .= " AND user_id = $filter_user_id";
}
if ($filter_status) {
    $searchQuery .= " AND status = '" . mysqli_real_escape_string($conp, $filter_status) . "'";
}
$searchQuery .= " ORDER BY $sort_by $sort_order";

$result = mysqli_query($conp, $searchQuery);
$queries_list = "";
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $queries_list .= "<tr>";
        $queries_list .= "<td>{$row['id']}</td>";
        $queries_list .= "<td>{$row['user_id']}</td>";
        $queries_list .= "<td>{$row['query_text']}</td>";
        $queries_list .= "<td>{$row['created_at']}</td>";
        $queries_list .= "<td>{$row['status']}</td>";
        $queries_list .= "<td>
                            <form action='queryshow.php' method='post'>
                                <input type='hidden' name='query_id' value='{$row['id']}'>
                                <textarea name='response_text' required></textarea>
                                <select name='status'>
                                    <option value='pending' " . ($row['status'] == 'pending' ? 'selected' : '') . ">Pending</option>
                                    <option value='in-progress' " . ($row['status'] == 'in-progress' ? 'selected' : '') . ">In Progress</option>
                                    <option value='resolved' " . ($row['status'] == 'resolved' ? 'selected' : '') . ">Resolved</option>
                                </select>
                                <button type='submit' name='respond'>Respond</button>
                            </form>
                          </td>";
        $queries_list .= "</tr>";
    }
}

// Handle query responses
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['respond'])) {
    $query_id = intval($_POST['query_id']);
    $response_text = trim($_POST['response_text']);
    $response_text = mysqli_real_escape_string($conp, $response_text);
    $new_status = $_POST['status'];

    $updateQuery = "UPDATE user_queries SET response_text = '$response_text', status = '$new_status' WHERE id = $query_id";
    if (mysqli_query($conp, $updateQuery)) {
        echo "Query response updated successfully.";
        // Optionally, send notification to the user about the response
        // Implement your notification logic here
    } else {
        echo "Error updating query response: " . mysqli_error($conp);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Queries</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        h1, h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-container, .table-container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        button, select, input[type="text"], textarea {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
            cursor: pointer;
            font-size: 14px;
        }
        button {
            background-color: #017d73;
            color: white;
        }
        button:hover {
            background-color: #016a63;
        }
        .message {
            color: green;
            text-align: center;
        }
        header {
            background-color: rgb(13, 73, 68);
            color: white;
            padding: 10px 0;
        }
        footer {
            text-align: center;
            padding: 10px 0;
            background-color: rgb(13, 73, 68);
            color: white;
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <h1>Manage Queries</h1>
        </nav>
    </header>
    <div class="form-container">
        <form method="get" action="">
            <label for="user_id">Filter by User ID:</label>
            <input type="text" name="user_id" id="user_id" value="<?= htmlspecialchars($filter_user_id) ?>">
            <label for="status">Filter by Status:</label>
            <select name="status" id="status">
                <option value="">All</option>
                <option value="pending" <?= $filter_status == 'pending' ? 'selected' : '' ?>>Pending</option>
                <option value="in-progress" <?= $filter_status == 'in-progress' ? 'selected' : '' ?>>In Progress</option>
                <option value="resolved" <?= $filter_status == 'resolved' ? 'selected' : '' ?>>Resolved</option>
            </select>
            <label for="sort_by">Sort by:</label>
            <select name="sort_by" id="sort_by">
                <option value="created_at" <?= $sort_by == 'created_at' ? 'selected' : '' ?>>Date</option>
                <option value="user_id" <?= $sort_by == 'user_id' ? 'selected' : '' ?>>User ID</option>
                <option value="status" <?= $sort_by == 'status' ? 'selected' : '' ?>>Status</option>
            </select>
            <label for="sort_order">Order:</label>
            <select name="sort_order" id="sort_order">
                <option value="ASC" <?= $sort_order == 'ASC' ? 'selected' : '' ?>>Ascending</option>
                <option value="DESC" <?= $sort_order == 'DESC' ? 'selected' : '' ?>>Descending</option>
            </select>
            <button type="submit">Apply</button>
        </form>
    </div>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User ID</th>
                    <th>Query Text</th>
                    <th>Created At</th>
                    <th>Status</th>
                    <th>Response</th>
                </tr>
            </thead>
            <tbody>
                <?= $queries_list ?>
            </tbody>
        </table>
    </div>
    <footer>CareCompass Hospitals @2024</footer>
</body>
</html>