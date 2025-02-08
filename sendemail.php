<?php
include 'db.php';

// Fetch all data from the `calls` table
$query = "SELECT * FROM calls";
$result = Databases::search($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Responsive Dashboard</title>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
     <style>
          .btn-action {
               display: flex;
               gap: 5px;
          }

          .table-wrapper {
               overflow-x: auto;
          }

          .table th,
          .table td {
               vertical-align: middle;
          }

          .table td button {
               white-space: nowrap;
          }
     </style>
</head>

<body>
     <div class="container mt-5">
          <h1 class="mb-4 text-center">Calls Dashboard</h1>
          <div class="table-wrapper">
               <table class="table table-striped table-bordered table-hover">
                    <thead class="table-dark">
                         <tr>
                              <th>#</th>
                              <th>Call Code</th>
                              <th>Name</th>
                              <th>Mobile</th>
                              <th>Date/Time</th>
                              <th>Description</th>
                              <th>Budget</th>
                              <th>Priority</th>
                              <th>System</th>
                              <th>District</th>
                              <th>User</th>
                              <th>Note</th>
                              <th>Email</th>
                              <th>Actions</th>
                         </tr>
                    </thead>
                    <tbody>
                         <?php $count = 1;
                         while ($row = $result->fetch_assoc()) : ?>
                              <tr>
                                   <td><?= $count++ ?></td>
                                   <td><?= htmlspecialchars($row['call_code']) ?></td>
                                   <td><?= htmlspecialchars($row['name']) ?></td>
                                   <td><?= htmlspecialchars($row['mobile']) ?></td>
                                   <td><?= htmlspecialchars($row['date_time']) ?></td>
                                   <td><?= htmlspecialchars($row['description']) ?></td>
                                   <td><?= htmlspecialchars($row['budget']) ?></td>
                                   <td><?= htmlspecialchars($row['prioraty_id']) ?></td>
                                   <td><?= htmlspecialchars($row['system_id']) ?></td>
                                   <td><?= htmlspecialchars($row['district_id']) ?></td>
                                   <td><?= htmlspecialchars($row['user_id']) ?></td>
                                   <td><?= htmlspecialchars($row['note']) ?></td>
                                   <td>
                                        <?php if (empty($row['email'])) : ?>
                                             <button class="btn btn-warning btn-sm" onclick="openModal('<?= $row['call_code'] ?>');">Add Email</button>
                                        <?php else : ?>
                                             <button class="btn btn-success btn-sm" onclick="changeEmail('<?= $row['call_code'] ?>');">Change Email</button>
                                        <?php endif; ?>
                                        <div><?= htmlspecialchars($row['email']) ?></div>
                                   </td>
                                   <td>
                                        <div class="btn-action">
                                             <button class="btn btn-primary btn-sm" onclick="sendMail('<?= htmlspecialchars($row['email']) ?>')">Send Email</button>
                                             <!-- Button to trigger modal -->
                                             <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#emailTemplateModal" onclick="setCallCode('<?= $row['call_code'] ?>')">
                                                  Send Email Template
                                             </button>
                                             <!-- Button to trigger the modal -->
                                             <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#emailTemplateModal2" onclick="sendcustome('<?= $row['email'] ?>')">
                                                  Send Custom Email
                                             </button>
                                             <script>
                                                  function sendcustome(email) {
                                                       var modal = new bootstrap.Modal(document.getElementById('emailTemplateModal2'));
                                                       modal.show();
                                                       document.getElementById("email2").textContent = email;
                                                  }
                                             </script>
                                             <!-- Modal -->
                                             <div class="modal fade" id="emailTemplateModal2" tabindex="-1" aria-labelledby="emailTemplateModalLabel" aria-hidden="true">
                                                  <div class="modal-dialog modal-lg">
                                                       <div class="modal-content">
                                                            <div class="modal-header bg-danger text-white">
                                                                 <p id="email2" type="email" readonly>
                                                                 <h5 class="modal-title" id="emailTemplateModalLabel">Custom Email Template</h5>
                                                                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                 <form id="emailTemplateForm" enctype="multipart/form-data">
                                                                      <!-- Title Input -->
                                                                      <div class="mb-3">
                                                                           <label for="emailTitle" class="form-label">Title</label>
                                                                           <textarea id="emailTitle" name="emailTitle" placeholder="Enter email title"></textarea>
                                                                      </div>

                                                                      <!-- Description Input -->
                                                                      <div class="mb-3">
                                                                           <label for="emailDescription" class="form-label">Description</label>
                                                                           <textarea id="emailDescription" name="emailDescription" placeholder="Enter email description"></textarea>
                                                                      </div>

                                                                      <!-- Header Image Upload -->
                                                                      <div class="mb-3">
                                                                           <label for="headerImage" class="form-label">Header Image</label>
                                                                           <input type="file" class="form-control" id="headerImage" name="headerImage" accept="image/*">
                                                                      </div>

                                                                      <!-- Footer Image Upload -->
                                                                      <div class="mb-3">
                                                                           <label for="footerImage" class="form-label">Footer Image</label>
                                                                           <input type="file" class="form-control" id="footerImage" name="footerImage" accept="image/*">
                                                                      </div>
                                                                 </form>
                                                            </div>
                                                            <div class="modal-footer">
                                                                 <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                 <button type="button" class="btn btn-danger" onclick="sendEditEmail();">Send Email</button>
                                                            </div>
                                                       </div>
                                                  </div>
                                             </div>
                                             <script src="https://cdn.ckeditor.com/ckeditor5/36.0.0/classic/ckeditor.js"></script>
                                             <script>
                                                  let emailTitleEditor, emailDescriptionEditor;

                                                  document.addEventListener("DOMContentLoaded", () => {
                                                       // Set the license key
                                                       window.CKEDITOR_LICENSE_KEY = 'eyJhbGciOiJFUzI1NiJ9.eyJleHAiOjE3NzA1OTUxOTksImp0aSI6ImMxMDE4YjEzLTNmOWMtNDYyMi05MGNhLWJlMjBkNGNiMWNjMiIsInVzYWdlRW5kcG9pbnQiOiJodHRwczovL3Byb3h5LWV2ZW50LmNrZWRpdG9yLmNvbSIsImRpc3RyaWJ1dGlvbkNoYW5uZWwiOlsiY2xvdWQiLCJkcnVwYWwiXSwiZmVhdHVyZXMiOlsiRFJVUCJdLCJ2YyI6ImE4MTlkNmQwIn0.AGE_WHmzPBHNQh0NVlnOO8ZMYrK52X7mbzkj84Zinh5ADLVTGJB8hYNHxUzqVEPFoRN56lRWJrUcr-2ALxvxCQ';

                                                       // Configuration for CKEditor with all features enabled
                                                       const editorConfig = {
                                                            toolbar: [
                                                                 'heading', '|',
                                                                 'bold', 'italic', 'underline', 'strikethrough', '|',
                                                                 'fontFamily', 'fontSize', 'fontColor', 'fontBackgroundColor', '|',
                                                                 'link', 'bulletedList', 'numberedList', '|',
                                                                 'alignment', 'indent', 'outdent', '|',
                                                                 'imageUpload', 'blockQuote', 'insertTable', 'mediaEmbed', '|',
                                                                 'undo', 'redo'
                                                            ],
                                                            language: 'en',
                                                            image: {
                                                                 toolbar: ['imageTextAlternative', 'imageStyle:full', 'imageStyle:side']
                                                            },
                                                            table: {
                                                                 contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells']
                                                            },
                                                            licenseKey: window.CKEDITOR_LICENSE_KEY
                                                       };

                                                       // Initialize CKEditor for Title
                                                       ClassicEditor.create(document.querySelector("#emailTitle"), editorConfig)
                                                            .then((editor) => {
                                                                 emailTitleEditor = editor;
                                                            })
                                                            .catch((error) => {
                                                                 console.error("Error initializing emailTitleEditor:", error);
                                                            });

                                                       // Initialize CKEditor for Description
                                                       ClassicEditor.create(document.querySelector("#emailDescription"), editorConfig)
                                                            .then((editor) => {
                                                                 emailDescriptionEditor = editor;
                                                            })
                                                            .catch((error) => {
                                                                 console.error("Error initializing emailDescriptionEditor:", error);
                                                            });
                                                  });
                                             </script>


                                             <script>
                                                  function sendEditEmail() {
                                                       // Get data from TinyMCE editors
                                                       var emailtitle = emailTitleEditor.getData();
                                                       var emailDescription = emailDescriptionEditor.getData();
                                                       var email = document.getElementById("email2").textContent;
                                                       alert(email);

                                                       // Get files from input elements
                                                       var headerImage = document.getElementById("headerImage").files[0];
                                                       var footerImage = document.getElementById("footerImage").files[0];

                                                       // Create FormData and append the data
                                                       var r = new FormData();
                                                       r.append("title", emailtitle);
                                                       r.append("des", emailDescription);
                                                       r.append("email", email);
                                                       if (headerImage) {
                                                            r.append("himage", headerImage);
                                                       }
                                                       if (footerImage) {
                                                            r.append("fimage", footerImage);
                                                       }

                                                       // Create an XMLHttpRequest and send data to customemailsend.php
                                                       var req = new XMLHttpRequest();
                                                       req.open("POST", "customemailsend.php", true);

                                                       // Optional: Add a handler to check the response
                                                       req.onload = function() {
                                                            if (req.status === 200) {
                                                                 alert("Email data sent successfully: " + req.responseText);
                                                            } else {
                                                                 alert("Error sending email data: " + req.statusText);
                                                            }
                                                       };

                                                       // Send the form data
                                                       req.send(r);
                                                  }
                                             </script>

                                             <script src="https://cdn.ckeditor.com/ckeditor5/37.1.0/classic/ckeditor.js"></script>



                                             <!-- Bootstrap Modal -->
                                             <div class="modal fade" id="emailTemplateModal" tabindex="-1" aria-labelledby="emailTemplateModalLabel" aria-hidden="true">
                                                  <div class="modal-dialog">
                                                       <div class="modal-content">
                                                            <div class="modal-header">
                                                                 <h5 class="modal-title" id="emailTemplateModalLabel">Enter Email Template</h5>
                                                                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                 <input id="callCode">
                                                                 <textarea id="emailTemplate" class="form-control" rows="5" placeholder="Enter email template..."></textarea>
                                                            </div>
                                                            <div class="modal-footer">
                                                                 <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                 <button type="button" class="btn btn-primary" onclick="sendEmailTemplate()">Send</button>
                                                            </div>
                                                       </div>
                                                  </div>
                                             </div>

                                             <!-- JavaScript -->
                                             <script>
                                                  function setCallCode(callCode) {
                                                       document.getElementById('callCode').value = callCode;
                                                  }

                                                  function sendEmailTemplate() {
                                                       let callCode = document.getElementById('callCode').value;
                                                       let templateContent = document.getElementById('emailTemplate').value;

                                                       if (templateContent.trim() === "") {
                                                            alert("Please enter an email template.");
                                                            return;
                                                       }

                                                       let formData = new FormData();
                                                       formData.append("call_code", callCode);
                                                       formData.append("template", templateContent);

                                                       fetch('send_emailpro.php', {
                                                                 method: 'POST',
                                                                 body: formData // No JSON headers needed
                                                            })
                                                            .then(response => response.text()) // Expecting plain text response
                                                            .then(data => {
                                                                 alert(data); // Show response message
                                                                 document.getElementById('emailTemplate').value = "";
                                                                 let modal = new bootstrap.Modal(document.getElementById('emailTemplateModal'));
                                                                 modal.hide();
                                                            })
                                                            .catch(error => console.error('Error:', error));
                                                  }
                                             </script>
                                        </div>
                                   </td>
                              </tr>
                         <?php endwhile; ?>
                    </tbody>
               </table>
          </div>
     </div>

     <!-- Add Email Modal -->
     <div class="modal fade" id="addEmailModal" tabindex="-1" aria-labelledby="addEmailModalLabel" aria-hidden="true">
          <div class="modal-dialog">
               <div class="modal-content">
                    <div class="modal-header">
                         <h5 class="modal-title" id="addEmailModalLabel">Add Email for Call Code: <span id="callCodeTitle"></span></h5>
                         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                         <form id="addEmailForm">
                              <div class="mb-3">
                                   <label for="emailInput" class="form-label">Email Address</label>
                                   <input type="email" class="form-control" id="emailInput" placeholder="Enter email" required>
                              </div>
                              <input type="hidden" id="callCodeInput">
                              <div class="text-end">
                                   <button type="button" class="btn btn-primary" onclick="insertEmail()">Insert</button>
                              </div>
                         </form>
                    </div>
               </div>
          </div>
     </div>

     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
     <script>
          function openModal(callCode) {
               document.getElementById('callCodeTitle').innerText = callCode;
               document.getElementById('callCodeInput').value = callCode;
               const modal = new bootstrap.Modal(document.getElementById('addEmailModal'));
               modal.show();
          }

          function insertEmail() {
               const email = document.getElementById('emailInput').value;
               const callCode = document.getElementById('callCodeInput').value;

               if (!email.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/)) {
                    alert("Please enter a valid email address.");
                    return;
               }
               var req = new XMLHttpRequest();
               var form = new FormData();
               form.append("email", email);
               form.append("callcode", callCode);
               req.onreadystatechange = function() {
                    if (req.readyState === 4) {
                         if (req.status === 200) {
                              const modal = bootstrap.Modal.getInstance(document.getElementById('addEmailModal'));
                              modal.hide();
                              console.log(`Email: ${email}, Call Code: ${callCode}`);
                              alert(req.responseText);
                              //  alert(`Email "${email}" added for Call Code: ${callCode}`);
                         }
                    }
               }
               req.open("POST", "addemailpro.php", true);
               req.send(form);
          }

          function deleteEntry(callCode) {
               if (confirm("Are you sure you want to delete this entry?")) {
                    console.log(`Deleting entry with Call Code: ${callCode}`);
                    alert(`Entry with Call Code "${callCode}" deleted.`);
                    // Add logic for deletion here
               }
          }

          function changeEmail(callCode) {
               openModal(callCode);
          }
     </script>
</body>
<script src="sahan.js"></script>

</html>