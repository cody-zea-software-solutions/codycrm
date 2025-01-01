<?php
require 'db.php'; // Your database connection
$callCode = $_GET['call_code'];
$result = Databases::search("SELECT * FROM `calls` WHERE `call_code` = '$callCode'");

if ($result->num_rows > 0) {
    $callData = $result->fetch_assoc();

    // Fetch additional details
    $callCode = $callData["call_code"];
    $name = $callData["name"];
    $mobile = $callData["mobile"];
    $date_time_Date_the_project_was_taken = $callData["date_time"];
    $description = $callData["description"];
    $budget = $callData["budget"];
    $sy = Databases::search("SELECT * FROM `system_type` WHERE `type_id`='" . $callData["system_id"] . "';");
    $syy = $sy->fetch_assoc();
    $system_type = $syy["type_name"];
    $dis = Databases::search("SELECT * FROM district WHERE `district_id`='" . $callData["district_id"] . "';");
    $distric = $dis->fetch_assoc();
    $distric_name = $distric["district_name"];
    
    $xm = Databases::search("SELECT * FROM `ongoing_projects` WHERE `call_id`='" .  $callData['call_code'] . "' ");
    $xnum = $xm->num_rows;
    if ($xnum == 1) {
        $deadline = $xm->fetch_assoc();
        $deadline_date = $deadline["deadline"];
    }else{
        $deadline_date = "empty";
    }

    // Prepare HTML content with additional details
    $htmlContent = "
    <h1>Call Information</h1>
    <p><strong>Call Code:</strong> $callCode</p>
    <p><strong>Name:</strong> $name</p>
    <p><strong>Mobile:</strong> $mobile</p>
    <p><strong>Project was_taken Date:</strong> $date_time_Date_the_project_was_taken</p>
    <p><strong>Description:</strong> $description</p>
    <p><strong>Budget:</strong> $budget</p>
    <p><strong>System Type:</strong> $system_type</p>
    <p><strong>District:</strong> $distric_name</p>
    <p><strong><b>deadline_date:: </b>$deadline_date</strong></p>
    ";

    // API key from PDF.co
    $apiKey = "sahantaraka.net@gmail.com_aVa9rbanHmRi9zHf6X9bOMP02CDH5sGItCsPzpb2bmKT0VPlFKKcvVMVUA1PfLvC";

    // API endpoint for PDF generation
    $url = "https://api.pdf.co/v1/pdf/convert/from/html";

    // Prepare payload
    $data = array(
        "html" => $htmlContent,
        "name" => "call_info.pdf"
    );

    // cURL request
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_HTTPHEADER => array(
            "Content-Type: application/json",
            "x-api-key: $apiKey"
        ),
        CURLOPT_POSTFIELDS => json_encode($data)
    ));

    $response = curl_exec($curl);
    curl_close($curl);

    // Decode response
    $responseData = json_decode($response, true);

    // Check if the request was successful
    $pdfUrl = isset($responseData['url']) ? $responseData['url'] : null;
    ?>
    
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>PDF Modal</title>
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            .modal-content iframe {
                width: 100%;
                height: 500px;
                border: none;
            }
        </style>
    </head>

    <body>
        <div class="container mt-5">
            <!-- Button to trigger modal -->
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#pdfModal" <?php if (!$pdfUrl) echo 'disabled'; ?>>
                View PDF
            </button>
            <?php if (!$pdfUrl) : ?>
                <p class="text-danger mt-3">Error generating PDF: <?php echo $responseData['message']; ?></p>
            <?php endif; ?>
        </div>

        <!-- PDF Modal -->
        <div class="modal fade" id="pdfModal" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="pdfModalLabel">Generated PDF</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <?php if ($pdfUrl) : ?>
                            <iframe src="<?php echo $pdfUrl; ?>"></iframe>
                        <?php endif; ?>
                    </div>
                    <div class="modal-footer">
                        <a href="<?php echo $pdfUrl; ?>" class="btn btn-success" target="_blank">Open PDF</a>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    </body>

    </html>

<?php
} else {
    echo "Invalid call code.";
}
?>
