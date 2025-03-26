<?php
require '../db_connection/db.php'; // Only require it once
session_start(); // Start the session to check login status

// Check if the user is logged in (by checking if session variable 'user_id' is set)
if (isset($_SESSION['user_id'])) {
    // Fetch user information (like username or email) from session or database if necessary
    $username = $_SESSION['email']; // Assuming email is stored in session
} else {
    // If the user is not logged in, set username to null
    $username = null;
}

// Check if the search term is set
$searchTerm = isset($_GET['zoekterm']) ? mysqli_real_escape_string($connection, $_GET['zoekterm']) : '';

// Construct the SQL query to search for jobs based on the search term
$query = "SELECT id, title, bedrijf, soort, codetaal, start_datum, eind_datum, description, thumbnail, creator_email, inschrijvingen 
          FROM vacatures 
          WHERE title LIKE '%$searchTerm%' OR bedrijf LIKE '%$searchTerm%' OR description LIKE '%$searchTerm%' 
          LIMIT 20";

// Execute the query
$result = mysqli_query($connection, $query);

if (!$result) {
    die('Error: ' . mysqli_error($connection));
}

// Function to register for a job (Inschrijven)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['opdrachtId']) && $username) {
    $opdrachtId = mysqli_real_escape_string($connection, $_POST['opdrachtId']);

    // Check if the user is already registered for the job
    $checkQuery = "SELECT inschrijvingen FROM vacatures WHERE id = '$opdrachtId'";
    $checkResult = mysqli_query($connection, $checkQuery);
    $row = mysqli_fetch_assoc($checkResult);
    $inschrijvingen = $row['inschrijvingen'];

    if (strpos($inschrijvingen, $username) !== false) {
        // If the user is already registered, show an error message
        echo "<script>alert('Je bent al ingeschreven voor deze opdracht!');</script>";
    } else {
        // Register the user if not already registered
        $updateQuery = "UPDATE vacatures SET inschrijvingen = CONCAT(COALESCE(inschrijvingen, ''), '$username,') WHERE id = '$opdrachtId'";
        if (!mysqli_query($connection, $updateQuery)) {
            die('Error: ' . mysqli_error($connection));
        }

        // Re-fetch the updated job details after registration
        $result = mysqli_query($connection, $query);
        if (!$result) {
            die('Error: ' . mysqli_error($connection));
        }
    }
}

// Function to unsubscribe from a job (Uitschrijven)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['opdrachtIdUnsubscribe']) && $username) {
    $opdrachtId = mysqli_real_escape_string($connection, $_POST['opdrachtIdUnsubscribe']);

    // Remove the user's email from the "inschrijvingen" field
    $unsubscribeQuery = "UPDATE vacatures 
                         SET inschrijvingen = REPLACE(inschrijvingen, '$username,', '') 
                         WHERE id = '$opdrachtId'";

    if (!mysqli_query($connection, $unsubscribeQuery)) {
        die('Error: ' . mysqli_error($connection));
    }

    // Re-fetch the updated job details after unsubscription
    $result = mysqli_query($connection, $query);
    if (!$result) {
        die('Error: ' . mysqli_error($connection));
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Opdrachten</title>
    <link rel="stylesheet" href="main.css">
    <link rel="icon" type="image/x-icon" href="../Icon.png">
</head>
<body>
    <header>
        <form class="search-form" method="GET" action="">
            <input type="text" placeholder="Zoek opdracht" name="zoekterm" value="<?php echo htmlspecialchars($searchTerm); ?>">
            <button type="submit">Zoeken</button>
        </form>
        
        <?php if ($username): ?>
            <!-- If the user is logged in, show their name and a logout button -->
            <p>Hallo, <?php echo htmlspecialchars($username); ?></p>
            <button class="top-right-button" onclick="window.location.href='../login_signup/logout.php'">Logout</button>
        <?php else: ?>
            <!-- If the user is not logged in, show the login button -->
            <button class="top-right-button" onclick="window.location.href='../../Login_signup/login.php'">Login</button>
        <?php endif; ?>
        
        <button class="aanmaak-button" onclick="window.location.href='../../aanmaak/aanmaak.php'">Opdracht maken</button>
    </header>

    <section class="content">
        <div class="opdracht-lijst">
            <h2>Beschikbare opdrachten</h2>
            <ul>
                <?php
                if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<li onclick=\"showDetails('opdracht" . htmlspecialchars($row['id']) . "')\">";
                        echo "<h3>" . htmlspecialchars($row['title']) . "</h3>";
                        echo "<p>" . htmlspecialchars($row['bedrijf']) . "</p>";
                        echo "</li>";
                    }
                } else {
                    echo "<p>Geen opdrachten beschikbaar.</p>";
                }

                // Free the result
                mysqli_free_result($result);
                ?>
            </ul>
        </div>

        <div class="opdracht-details">
            <?php
            // Fetch and display job details (same query for displaying details)
            $result = mysqli_query($connection, $query);
            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $thumbnail = !empty($row['thumbnail']) ? $row['thumbnail'] : null;

                    echo "<div id='opdracht" . htmlspecialchars($row['id']) . "' class='details' style='display:none;'>";

                    if ($thumbnail) {
                        // Display the thumbnail image using the stored file path
                        echo "<div class='thumbnail-container'>";
                        echo "<img src='" . htmlspecialchars($thumbnail) . "' alt='Thumbnail' width='100%' height='600px'>"; 
                        echo "</div>";
                    }

                    echo "<h2>Opdracht Details</h2>";
                    echo "<h3>" . htmlspecialchars($row['title']) . "</h3>";
                    echo "<p><strong>Bedrijf:</strong> " . htmlspecialchars($row['bedrijf']) . "</p>";
                    echo "<p><strong>Soort:</strong> " . htmlspecialchars($row['soort']) . "</p>";
                    echo "<p><strong>Code taal:</strong> " . htmlspecialchars($row['codetaal']) . "</p>";
                    echo "<p><strong>Startdatum:</strong> " . htmlspecialchars($row['start_datum']) . "</p>";
                    echo "<p><strong>Einddatum:</strong> " . htmlspecialchars($row['eind_datum']) . "</p>";
                    echo "<p><strong>Beschrijving:</strong> " . htmlspecialchars($row['description']) . "</p>";
                    echo "<p><strong>Ingeschreven gebruikers:</strong><br>";
                    $inschrijvingen = explode(',', $row['inschrijvingen']);
                    foreach ($inschrijvingen as $inschrijving) {
                        if (!empty($inschrijving)) {
                            echo htmlspecialchars($inschrijving) . "<br>";
                        }
                    }
                    echo "</p>";

                    // Only show the register button if the user is not already registered
                    if ($username && strpos($row['inschrijvingen'], $username) === false) {
                        echo "<form method='post' action=''>";
                        echo "<input type='hidden' name='opdrachtId' value='" . htmlspecialchars($row['id']) . "'>";
                        echo "<button type='submit' class='details-knop'>Inschrijven</button>";
                        echo "</form>";
                    } else {
                        // If already registered, show an "already registered" message
                        echo "<p>Je bent al ingeschreven voor deze opdracht.</p>";
                    }

                    // Unsubscribe button - only show if the user is already signed up for the job
                    if ($username && strpos($row['inschrijvingen'], $username) !== false) {
                        echo "<form method='post' action=''>";
                        echo "<input type='hidden' name='opdrachtIdUnsubscribe' value='" . htmlspecialchars($row['id']) . "'>";
                        echo "<button type='submit' class='details-knop'>Uitschrijven</button>";
                        echo "</form>";
                    }

                    // **Restored Edit and Delete buttons**
                    if ($username && $row['creator_email'] == $username) {
                        echo "<form action='../db.php' method='POST'>";
                        echo "<input type='hidden' name='opdrachtId' value='" . htmlspecialchars($row['id']) . "'>";
                        echo "<button type='update' class='details-knop'>Edit</button>";
                        echo "</form>";

                        echo "<form action='../aanmaak/delete_aanmaak.php' method='post' onsubmit='return confirm(\"Are you sure you want to delete this item?\");'>";
                        echo "<input type='hidden' name='opdrachtId' value='" . htmlspecialchars($row['id']) . "'>";
                        echo "<button type='submit' class='details-knop'>Delete</button>";
                        echo "</form>";
                    }

                    echo "</div>";
                }
            } else {
                echo "<p>Geen opdrachtdetails beschikbaar.</p>";
            }

            // Free the result
            mysqli_free_result($result);
            ?>
        </div>
    </section>
    <script>
        function showDetails(id) {
            document.querySelectorAll('.details').forEach(function (div) {
                div.style.display = 'none';
            });

            document.getElementById(id).style.display = 'block';
        }
    </script>
</body>
</html>
