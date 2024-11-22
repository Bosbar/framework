<body>

<h2>Halls and Visits</h2>

<table border="1">
    <tr>
        <th>Visit ID</th>
        <th>Hall Name</th>
        <th>Hall Visits</th>
        <th>Confirmed for Today</th>
        <th>Last Visit Date</th>
        <th>Visit Date</th>
        <th>Details</th>
    </tr>

    <?php
    // Assuming the data is stored in $_SESSION['visitArray']
    $visitArray = $_SESSION['visitArray'];

    foreach ($visitArray as $row) {
        echo "<tr>";
        echo "<td>" . $row["id"] . "</td>";
        echo "<td>" . ucfirst($row["hall_name"]) . "</td>";
        echo "<td>" . $row["hall_visits"] . "</td>";
        echo "<td>" . ($row["confirmed_for_today"] ?? "No") . "</td>";
        echo "<td>" . $row["last_visit_date"] . "</td>";
        echo "<td>" . $row["visit_date"] . "</td>";
        echo "<td>" . $row["details"] . "</td>";
        echo "</tr>";
    }
    ?>

</table>