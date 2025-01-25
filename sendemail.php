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
                                             <button class="btn btn-danger btn-sm" onclick="deleteEntry('<?= $row['call_code'] ?>')">Delete</button>
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
               req.open("POST","addemailpro.php",true);
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