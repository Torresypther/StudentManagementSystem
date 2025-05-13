<?php
session_start();

if (!isset($_SESSION['user_id'])) {
  header("Location: user_login.php");
  exit();
}

$user_id = $_SESSION['user_id'];

if ($user_id != 9) {
  header("Location: std-dashb.php");
  exit();
}
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
      padding: 20px;
      background-color: #ffffff;
      width: calc(100% - 250px);
      box-sizing: border-box;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .dashboard-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background-color: #fff;
      color: #333675;
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
      color: #333675;
    }

    /* Summary Boxes */
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
      color: #333675;
      margin-bottom: 10px;
    }

    .summary-box .value {
      font-size: 28px;
      font-weight: 700;
      color: #333675;
    }

    .summary-box .icon {
      position: absolute;
      top: 10px;
      right: 10px;
      font-size: 24px;
      color: #333675;
    }

    @media (max-width: 768px) {
      .sidebar {
        width: 200px;
      }

      .main-content {
        margin-left: 200px;
        padding: 20px;
      }

      .summary-boxes {
        flex-direction: column;
        gap: 15px;
      }

      .summary-box {
        flex-basis: 100%;
        max-width: 100%;
      }
    }

    .summary-box:hover {
      background-color: #f3f4f6;
      transition: background-color 0.3s;
    }

    .table-container h3 {
      margin-bottom: 20px;
      font-size: 20px;
      font-weight: 700;
      color: #333675;
    }

    .table {
      width: 100%;
      border-collapse: collapse;
      border-spacing: 0;
      margin-bottom: 20px;
    }

    .table th {
      background-color: #3b3d92;
      color: #ffffff;
      font-weight: 600;
      text-align: center;
      padding: 12px;
    }

    .table th:first-child {
      border-top-left-radius: 8px;
    }

    .table th:last-child {
      border-top-right-radius: 8px;
    }

    .table td {
      color: #333675;
      text-align: center;
      vertical-align: middle;
      padding: 12px;
      border-bottom: 2px solid #e5e7eb;
      background-color: inherit;
    }

    .table tbody tr:nth-child(even) {
      background-color: #f2f4fc;
    }

    .table tbody tr:nth-child(odd) {
      background-color: #e2e7f7;
    }

    .table td:first-child,
    .table th:first-child {
      border-left: none;
    }

    .table td:last-child,
    .table th:last-child {
      border-right: none;
      text-align: center;
    }

    .table-container .no-data {
      text-align: center;
      color: #6b7280;
      font-size: 16px;
      padding: 20px;
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

    .status {
      width: 100px;
      font-weight: 600;
      padding: 2px 10px;
      border-radius: 50px;
      display: inline-block;
      text-align: center;
      font-size: 12.5px;
      background-color: inherit;
    }

    .status.verified {
      background-color: #d1fae5;
      color: #065f46;
    }

    .status.unverified {
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
      font-weight: 400;
      margin: 0;
      margin-bottom: 10px;
    }

    .user-profile .logout-btn {
      background-color: #ef4444;
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
  </style>
</head>

<body>
  <div class="sidebar">
    <h2>Dashboard</h2>
    <a href="index.php"><i class="bi bi-house-door"></i> Home</a>
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
        <i class="bi bi-kanban"></i> Welcome to your Dashboard
      </h1>
      <div class="date-time" id="dateTime"></div>
    </div>

    <!-- Summary Boxes -->
    <div class="summary-boxes row">
      <div class="col-md-4">
        <div class="summary-box">
          <div class="icon">
            <i class="bi bi-people-fill"></i>
          </div>
          <h4>Verified Users</h4>
          <div class="value" id="verifiedUsersCount">0</div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="summary-box">
          <div class="icon">
            <i class="bi bi-book-fill"></i>
          </div>
          <h4>Active Sessions</h4>
          <div class="value">10</div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="summary-box">
          <div class="icon">
            <i class="bi bi-bar-chart-fill"></i>
          </div>
          <h4>System Health</h4>
          <div class="value">Good</div>
        </div>
      </div>
    </div>

    <!-- Student List Table -->
    <div class="row justify-content-center table-container">
      <div class="col-12">
        <h3>Verified Students</h3>
        <table class="table table-striped w-100">
          <thead>
            <tr>
              <th scope="col">First Name</th>
              <th scope="col">Last Name</th>
              <th scope="col">Degree</th>
              <th scope="col">Address</th>
              <th scope="col">Status</th>
            </tr>
          </thead>
          <tbody id="tableBody">
            <template id="productTemplate">
              <tr class="std-row">
                <td class="id" style="display: none">ID</td>
                <td class="fname">Fname</td>
                <td class="lname">Lname</td>
                <td class="course">Degree</td>
                <td class="address">Address</td>
                <td class="status">Status</td>
              </tr>
            </template>
          </tbody>
        </table>
      </div>
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