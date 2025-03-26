<?php
// Functionality to edit a job
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editOpdrachtId']) && $username) {
    $opdrachtId = mysqli_real_escape_string($connection, $_POST['editOpdrachtId']);
    $title = mysqli_real_escape_string($connection, $_POST['title']);
    $bedrijf = mysqli_real_escape_string($connection, $_POST['bedrijf']);
    $soort = mysqli_real_escape_string($connection, $_POST['soort']);
    $codetaal = mysqli_real_escape_string($connection, $_POST['codetaal']);
    $start_datum = mysqli_real_escape_string($connection, $_POST['start_datum']);
    $eind_datum = mysqli_real_escape_string($connection, $_POST['eind_datum']);
    $description = mysqli_real_escape_string($connection, $_POST['description']);

    $updateQuery = "
        UPDATE vacatures 
        SET title = '$title', bedrijf = '$bedrijf', soort = '$soort', codetaal = '$codetaal', start_datum = '$start_datum', eind_datum = '$eind_datum', description = '$description' 
        WHERE id = '$opdrachtId' AND creator_email = '$username'
    ";

    if (!mysqli_query($connection, $updateQuery)) {
        die('Error: ' . mysqli_error($connection));
    }
}
echo "<form method='post' action=''>";
echo "<input type='hidden' name='editOpdrachtId' value='" . htmlspecialchars($row['id']) . "'>";
echo "<input type='text' name='title' value='" . htmlspecialchars($row['title']) . "' required>";
echo "<input type='text' name='bedrijf' value='" . htmlspecialchars($row['bedrijf']) . "' required>";
echo "<input type='text' name='soort' value='" . htmlspecialchars($row['soort']) . "' required>";
echo "<input type='text' name='codetaal' value='" . htmlspecialchars($row['codetaal']) . "' required>";
echo "<input type='date' name='start_datum' value='" . htmlspecialchars($row['start_datum']) . "' required>";
echo "<input type='date' name='eind_datum' value='" . htmlspecialchars($row['eind_datum']) . "' required>";
echo "<textarea name='description' required>" . htmlspecialchars($row['description']) . "</textarea>";
echo "<button type='submit' class='details-knop'>Save</button>";
echo "</form>";