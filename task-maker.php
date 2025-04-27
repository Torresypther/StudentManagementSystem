<?php
session_start();

if (!isset($_SESSION['user_id'])) {
  header("Location: user_login.php");
  exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user data from the database
require 'db_conn.php';
$users_stmt = $conn->prepare("SELECT user_id, CONCAT(first_name, ' ', last_name) AS full_name FROM user_table");
$users_stmt->execute();
$users = $users_stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard</title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet" />
  <link
    href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap"
    rel="stylesheet" />
  <link
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css"
    rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <style>
    /* General Styling */
    body {
      font-family: "Roboto", sans-serif;
      margin: 0;
      padding: 0;
      display: flex;
      height: 100vh;
      background-color: #f9fafb;
      overflow-x: hidden;
    }

    .sidebar {
      position: fixed;
      top: 0;
      left: 0;
      height: 100%;
      width: 250px;
      background: linear-gradient(to bottom right, #484ebd, #3d43aa);
      color: #fff;
      display: flex;
      flex-direction: column;
      padding: 20px;
      overflow-y: auto;
      z-index: 1000;
    }

    .sidebar h2 {
      text-align: center;
      margin-bottom: 20px;
    }

    .sidebar a {
      color: #cbd5e1;
      text-decoration: none;
      padding: 10px 15px;
      margin: 5px 0;
      border-radius: 5px;
      display: flex;
      align-items: center;
      font-size: 16px;
      transition: background-color 0.3s, color 0.3s;
    }

    .sidebar a i {
      margin-right: 10px;
    }

    .sidebar a:hover {
      background-color: rgb(42, 47, 152);
      color: #fff;
    }

    .main-content {
      margin-left: 250px;
      padding: 30px;
      background-color: #f9fafb;
      width: calc(100% - 250px);
      box-sizing: border-box;
    }

    /* Dashboard Header */
    .dashboard-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background-color: #fff;
      color: #3d43aa;
      padding: 20px 30px;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      margin-bottom: 20px;
    }

        .dashboard-title {
      font-size: 28px; /* Slightly larger font size for emphasis */
      font-weight: 700; /* Bold font weight */
      color: #3d43aa; /* Match the color with other elements */
      margin: 0;
      text-transform: uppercase; /* Optional: Make the text uppercase for a professional look */
      letter-spacing: 1px; /* Optional: Add slight spacing between letters */
    }

    .dashboard-header h1 {
      font-size: 24px;
      font-weight: 700;
      margin: 0;
    }

    .dashboard-header .date-time {
      font-size: 16px;
      font-weight: 500;
      color: #3d43aa;
    }

    .summary-boxes {
      display: flex;
      gap: 20px;
      margin-bottom: 30px;
      flex-wrap: nowrap;
      justify-content: space-between;

    }

    .summary-box {
      flex-basis: 30%;
      max-width: 300px;
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      padding: 20px;
      text-align: center;
      position: relative;
      height: 120px;
    }

    .summary-box h4 {
      font-size: 16px;
      font-weight: 500;
      color: #3d43aa;
      margin-bottom: 10px;
    }

    .summary-box .value {
      font-size: 28px;
      font-weight: 700;
      color: #3d43aa;
    }

    .summary-box .icon {
      position: absolute;
      top: 10px;
      right: 10px;
      font-size: 24px;
      color: rgb(92, 97, 201);
    }

    @media (max-width: 768px) {
      .summary-boxes {
        flex-direction: column;
        gap: 15px;
      }

      .summary-box {
        flex-basis: 100%;
        max-width: 100%;
      }

      .sidebar {
        width: 200px;
      }

      .main-content {
        margin-left: 200px;
        width: calc(100% - 200px);
      }
    }

    .table-container {
      background: #fff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .table-container h3 {
      margin-bottom: 20px;
      font-size: 20px;
      font-weight: 700;
      color: #3d43aa;
    }

    .table {
      border-collapse: separate;
      border-spacing: 0 10px;
    }

    .table th {
      background-color: #f3f4f6;
      color: #3d43aa;
      font-weight: 600;
      text-align: center;
      padding: 12px;
    }

    .table td {
      color: rgb(74, 79, 169);
      text-align: center;
      vertical-align: middle;
      padding: 12px;
      background-color: #fff;
      border-bottom: 1px solid #e5e7eb;
    }

    .tdesc{
      max-width: 250px;
      word-wrap: break-word;
      white-space: normal;
      overflow: hidden;
    }

    .table-hover tbody tr:hover {
      background-color: #f1f5f9;
    }

    .profile-img {
      border-radius: 50%;
      width: 40px;
      height: 40px;
      object-fit: cover;
    }

    .btn-warning {
      background-color: #f59e0b;
      border: none;
    }

    .btn-warning:hover {
      background-color: #d97706;
    }

    .btn-danger {
      background-color: #ef4444;
      border: none;
    }

    .btn-danger:hover {
      background-color: #dc2626;
    }

    .dashboard-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background-color: #fff;
      color: #011f4b;
      padding: 20px 30px;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      margin-bottom: 20px;
    }

    .dashboard-header h1 {
      font-size: 24px;
      font-weight: 700;
      margin: 0;
    }

    .dashboard-header .date-time {
      font-size: 16px;
      font-weight: 500;
      color: #3d43aa;
    }

    .status-tag {
      display: inline-block;
      padding: 8px 15px;
      border-radius: 15px;
      font-size: 13.5px;
      font-weight: 600;
      text-align: center;
      color: #fff;
    }
    
    .status-tag.pending {
      background-color: #fef3c7;
      color: #92400e;
    }
    
    .status-tag.completed {
      background-color: #d1fae5;
      color: #065f46;
    }
    
    .status-tag.overdue {
      background-color: #fee2e2;
      color: #b91c1c;
    }

    .user-profile {
      margin-top: auto;
      text-align: center;
      padding: 20px 0;
      border-top: 1px solid #334155;
    }

    .user-profile .profile-img {
      border-radius: 50%;
      width: 60px;
      height: 60px;
      object-fit: cover;
      margin-bottom: 10px;
    }

    .user-profile .user-info {
      color: #cbd5e1;
    }

    .user-profile .user-name {
      font-size: 16px;
      font-weight: 600;
      margin: 0;
      margin-bottom: 10px;
    }

    .user-profile .logout-btn {
      background-color: #ef4444;
      /* Red background */
      border: none;
      color: #fff;
      padding: 5px 10px;
      font-size: 14px;
      border-radius: 5px;
      cursor: pointer;
    }

    .user-profile .logout-btn:hover {
      background-color: #dc2626;
    }

    .selected-badge {
      background-color: #e0f7fa !important;
      color: #006064 !important;
      border: 1px solid #b2ebf2;
    }
  </style>
</head>

<body>
  <div class="sidebar">
    <h2>Dashboard</h2>
    <a href="dashboard.php"><i class="bi bi-house-door"></i> Home</a>
    <a href="task-maker.php"><i class="bi bi-book"></i> Tasks</a>
    <a href="churn_prediction.html"><i class="bi bi-book"></i> Churn Prediction</a>

    <div class="user-profile">
      <div class="profile-edit-trigger" data-bs-toggle="modal" data-bs-target="#editProfileModal">
        <img src="profiles/default.jpg" alt="Profile Picture" class="profile-img" />
        <div class="user-info">
          <p class="user-name">Loading...</p>
        </div>
      </div>
      <div class="logout-container">
        <button class="btn btn-danger btn-sm logout-btn">Logout</button>
      </div>
    </div>
  </div>

  <div class="main-content">
    <!-- Dashboard Header -->
    <div class="dashboard-header">
            <h1 class="dashboard-title">
        <i class="bi bi-kanban"></i> Task Management
      </h1>
      <div class="date-time" id="dateTime"></div>
    </div>

    <!-- Add Task Form -->
    <div class="card p-4 shadow-sm mb-4">
      <h3 class="mb-3 text-primary">Add New Task</h3>
      <form id="addTask" method="POST">
        <div class="mb-3">
          <label for="taskName" class="form-label">Task Name</label>
          <input type="text" class="form-control" id="taskName" name="task_name" required />
        </div>
        <div class="mb-3">
          <label for="description" class="form-label">Description</label>
          <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
        </div>
        <div class="mb-3">
          <label for="assignedStudents" class="form-label">Assigned Students</label>
          <div class="border p-2 rounded" id="assignedStudentsContainer" style="min-height: 50px;">
            <!-- Select All Option -->
            <div class="badge bg-secondary text-white me-2 mb-2 selectable-badge select-all"
              style="display: inline-block; padding: 10px 15px; border-radius: 20px; cursor: pointer;">
              Select All
            </div>
            <?php
            $colors = ['bg-primary', 'bg-success', 'bg-warning', 'bg-danger', 'bg-info']; // Array of Bootstrap colors
            if (count($users) > count($colors)) {
              for ($i = count($colors); $i < count($users); $i++) {
                $colors[] = sprintf('#%06X', mt_rand(0, 0xFFFFFF));
              }
            }
            $colorIndex = 0;
            foreach ($users as $user):
            ?>
              <div class="badge <?= $colors[$colorIndex] ?> text-white me-2 mb-2 selectable-badge"
                data-id="<?= htmlspecialchars($user['user_id']) ?>"
                style="display: inline-block; padding: 10px 15px; border-radius: 20px; cursor: pointer;">
                <?= htmlspecialchars($user['full_name']) ?>
              </div>
              <?php
              $colorIndex = ($colorIndex + 1) % count($colors); // Cycle through colors
              ?>
            <?php endforeach; ?>
          </div>
          <input type="hidden" id="assignedStudentsInput" name="assigned_students" />
        </div>
        <div class="mb-3">
          <label for="deadline" class="form-label">Duedate</label>
          <input type="datetime-local" class="form-control" id="duedate" name="duedate" required />
        </div>
        <button type="submit" class="btn btn-primary">Add Task</button>
      </form>
    </div>

    <div class="row justify-content-center table-container">
      <div class="col-12">
        <table class="table table-striped w-100">
          <thead>
            <tr>
              <th scope="col">Task Name</th>
              <th scope="col">Task Description</th>
              <th scope="col">Due Date</th>
              <th scope="col">Status</th>
              <th scope="col">Actions</th>
            </tr>
          </thead>
          <tbody id="tableBody">
            <!-- Rows will be dynamically populated here -->
          </tbody>
        </table>

        <!-- Template for task rows -->
        <template id="taskTemplate">
          <tr class="std-row">
            <td class="id" style="display: none">ID</td>
            <td class="tname">Task_name</td>
            <td class="tdesc">Task_desc</td>
            <td class="duedate">Task_deadline</td>
            <td class="status">
              <span class="status-tag">Task_Status</span>
            </td>
            <td class="actions">
            <button type="button" class="btn btn-info btn-md"><i class="bi bi-eye"></i></button>
            <button type="button" class="btn btn-warning btn-md"><i class="bi bi-pencil"></i></button>
            <button type="button" class="btn btn-success btn-md"><i class="bi bi-check-circle"></i></button>

            </td>
          </tr>
        </template>

      </div>
    </div>

    <!-- Edit Profile Modal -->
    <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form id="editProfileForm" enctype="multipart/form-data">
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label for="fname" class="form-label">First Name</label>
                  <input type="text" class="form-control" id="fname" name="fname" disabled required />
                </div>
                <div class="col-md-6 mb-3">
                  <label for="lname" class="form-label">Last Name</label>
                  <input type="text" class="form-control" id="lname" name="lname" disabled required />
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label for="email" class="form-label">Email</label>
                  <input type="email" class="form-control" id="email" name="email" disabled required />
                </div>
                <div class="col-md-6 mb-3">
                  <label for="address" class="form-label">Address</label>
                  <input type="text" class="form-control" id="address" name="address" disabled />
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label for="gender" class="form-label">Gender</label>
                  <select class="form-control" id="gender" name="gender" disabled>
                    <option value="">Select Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                  </select>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="birthdate" class="form-label">Birthday</label>
                  <input type="date" class="form-control" id="birthdate" name="birthdate" disabled />
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 mb-3 text-center">
                  <img id="profilePreview" src="profiles/default.jpg" alt="Profile Picture" class="img-thumbnail" style="max-width: 150px; max-height: 150px;" />
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 mb-3">
                  <label for="profileImage" class="form-label">Profile Picture</label>
                  <input type="file" class="form-control" id="profileImage" name="profileImage" accept="image/*" disabled />
                </div>
              </div>

              <div class="text-end">
                <button type="button" id="enableEditButton" class="btn btn-secondary">Edit</button>
                <button type="submit" class="btn btn-primary" disabled id="saveChangesButton">Save Changes</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <script>
      document.addEventListener('DOMContentLoaded', function() {
        const badges = document.querySelectorAll('.selectable-badge:not(.select-all)');
        const selectAllBadge = document.querySelector('.select-all');
        const hiddenInput = document.getElementById('assignedStudentsInput');
        const selectedIds = new Set();

        // Function to update the hidden input
        function updateHiddenInput() {
          hiddenInput.value = Array.from(selectedIds).join(',');
        }

        // Handle individual badge selection
        badges.forEach(badge => {
          badge.addEventListener('click', function() {
            const userId = this.getAttribute('data-id');
            if (selectedIds.has(userId)) {
              selectedIds.delete(userId);
              this.classList.remove('selected-badge'); // Remove selection highlight
            } else {
              selectedIds.add(userId);
              this.classList.add('selected-badge'); // Add selection highlight
            }
            updateHiddenInput();
          });
        });

        // Handle "Select All" functionality
        selectAllBadge.addEventListener('click', function() {
          if (selectedIds.size === badges.length) {
            // Deselect all
            selectedIds.clear();
            badges.forEach(badge => badge.classList.remove('selected-badge'));
          } else {
            // Select all
            badges.forEach(badge => {
              const userId = badge.getAttribute('data-id');
              selectedIds.add(userId);
              badge.classList.add('selected-badge');
            });
          }
          updateHiddenInput();
        });
      });
    </script>


    <script>
      document.querySelector('.profile-edit-trigger').addEventListener('click', function() {
        const form = document.getElementById('editUserForm');
        form.style.display = form.style.display === 'none' ? 'block' : 'none';
      });
    </script>

    <script
      src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.js"
      integrity="sha512-+k1pnlgt4F1H8L7t3z95o3/KO+o78INEcXTbnoJQ/F2VqDVhWoaiVml/OEHv9HsVgxUaVW+IbiZPUJQfF/YxZw=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"></script>
    <script
      src="https://code.jquery.com/jquery-3.7.1.js"
      integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
      crossorigin="anonymous"></script>
    <script>
      function updateDateTime() {
        const dateTimeElement = document.getElementById("dateTime");
        const now = new Date();
        const options = {
          weekday: "long",
          year: "numeric",
          month: "long",
          day: "numeric",
          hour: "2-digit",
          minute: "2-digit",
          second: "2-digit",
        };
        dateTimeElement.textContent = now.toLocaleDateString("en-US", options);
      }

      setInterval(updateDateTime, 1000);
      updateDateTime();
    </script>
    <script src="main.js"></script>
</body>

</html>