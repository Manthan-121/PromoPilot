<?php
include_once("./includes/config.php");

$query = "SELECT id, name, email, status, created_at FROM recipients ORDER BY id DESC";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $sqn = 1;
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $sqn++ . "</td>
                <td>" . htmlspecialchars($row['name']) . "</td>
                <td>" . htmlspecialchars($row['email']) . "</td>
                <td>" . ucfirst($row['status']) . "</td>
                <td>" . date('d M Y', strtotime($row['created_at'])) . "</td>
                <td>
                    <button class='btn btn-success btn-sm edit-btn' data-id='{$row['id']}' data-name='" . htmlspecialchars($row['name']) . "'data-email='" . htmlspecialchars($row['email']) . "'>
                        Edit
                    </button>
                    <button class='btn btn-danger btn-sm delete-btn' data-id='{$row['id']}'>Delete</button>
                </td>
            </tr>";
    }
} else {
    echo "<tr><td colspan='5' class='text-center'>No recipients found.</td></tr>";
}
