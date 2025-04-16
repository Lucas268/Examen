<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vacature aanmaken</title>
    <link rel="stylesheet" href="aanmaak.css">
    <link rel="stylesheet" href="../header.css">
    <link rel="icon" type="image/x-icon" href="../Icon.png">
</head>
<body>
<div class="head">
    <button class="terug-button" onclick="window.location.href='../../main/main.php'">ga terug</button>
    <p>opdracht aanmaken</p>
</div>
<section class="content">
    <div class="box">
        <!-- Form to create a new opdracht -->
        <form method="POST" action="process_vacature.php" enctype="multipart/form-data">
            <ul>
                <li><input type="text" class="een" name="projectname" placeholder="Projectnaam" required></li><br>
                <li><input type="text" class="een" name="bedrijf" placeholder="Bedrijf" required></li><br>
                <li><input type="text" class="een" name="opdracht" placeholder="Opdracht" required></li><br>
                <li><input type="text" class="een" name="programmeertalen" placeholder="Programmeertalen" required></li><br>
                <li><select class="een" name="soort" required><option value="" disabled selected>Soort</option> <option value="Full-time">Full-time</option> <option value="Part-time">Part-time</option></select></li><br>

                
                <h1>Startdatum</h1>
                <li><input type="date" class="een" name="startdatum" id="startdatum" required></li><br>
                
                <h1>Einddatum</h1>
                <li><input type="date" class="een" name="einddatum" id="einddatum" required disabled></li><br>
                
                <li><input type="text" class="beschrijving" name="beschrijving" placeholder="Beschrijving" required></li><br>
                
                <h3>Upload een thumbnail</h3>
                <input type="file" id="fileUpload" class="file-upload" name="thumbnail">
                <label for="fileUpload" class="custom-button">Choose File</label><br>
                <!-- Hidden input to store the logged-in user's email -->
                <input type="hidden" name="creator_email" value="<?php echo $_SESSION['email']; ?>">

                <button class="submit-button"type="submit">Submit</button>
            </ul>
        </form>
        
        <p id="fileName"></p>
    </div>
</section>

<script>
    // Get start and end date elements
    const startdatum = document.getElementById('startdatum');
    const einddatum = document.getElementById('einddatum');

    // Initially disable the end date field
    einddatum.disabled = true;

    // Update the min attribute of einddatum whenever startdatum changes
    startdatum.addEventListener('change', function () {
        const startDate = startdatum.value;
        if (startDate) {
            // Enable the end date field when a start date is selected
            einddatum.disabled = false;
            // Set the minimum value for the end date to the selected start date
            einddatum.setAttribute('min', startDate);

            // Check if the end date is already set to a value that is before the start date
            const endDate = einddatum.value;
            if (endDate && new Date(endDate) < new Date(startDate)) {
                // If the end date is before the start date, reset the end date to the start date
                einddatum.value = startDate;
            }
        } else {
            // Disable the end date field if no start date is selected
            einddatum.disabled = true;
        }
    });

    // Update the min attribute of startdatum whenever einddatum changes
    einddatum.addEventListener('change', function () {
        const endDate = einddatum.value;
        if (endDate) {
            // Set the maximum value for the start date to the selected end date
            startdatum.setAttribute('max', endDate);

            // If the start date is later than the end date, reset the start date to the end date
            const startDate = startdatum.value;
            if (startDate && new Date(startDate) > new Date(endDate)) {
                startdatum.value = endDate;
            }
        }
    });

    // Also update the end date text content when a file is selected
    document.getElementById('fileUpload').addEventListener('change', function () {
        let fileName = this.files[0] ? this.files[0].name : 'No file chosen';
        document.getElementById('fileName').textContent = 'Selected file: ' + fileName;
    });
</script>
</body>
</html>
