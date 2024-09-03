<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Device Manager</title>
    <link rel="stylesheet" href="styles.css">
    <script src="script.js" defer></script>
</head>
<body>
    <div class="container">
        <h1>Device Manager</h1>
        <table>
            <thead>
                <tr>
                    <th>Device Name</th>
                    <th>State</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $servername = "";
                    $username = "";
                    $password = "";
                    $dbname = "";
                    
                    $conn = new mysqli($servername, $username, $password, $dbname);

                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    $sql = "SELECT * FROM Devices";  
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        // Output data of each row
                        while($row = $result->fetch_assoc()) {
                            $isChecked = ($row["state"] == "on") ? "checked" : "";
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row["Appliances"]) . "</td>";  
                            echo "<td class='state-cell'>" . $row["state"] . "</td>"; 
                            echo "<td>
                                    <label class='switch'>
                                        <input type='checkbox' onchange='toggleDevice(" . $row["id"] . ", this)' $isChecked>
                                        <span class='slider'></span>
                                    </label>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3'>No devices found</td></tr>";
                    }

                    $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
