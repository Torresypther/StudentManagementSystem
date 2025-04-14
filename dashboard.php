<?php
session_start();

if (!isset($_SESSION['user_id'])) {
  header("Location: user_login.php");
  exit();
}

$user_id = $_SESSION['user_id'];
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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
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
      width: 250px;
      background-color: #1e293b;
      color: #fff;
      display: flex;
      flex-direction: column;
      padding: 20px;
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
      display: block;
      font-size: 16px;
    }

    .sidebar a:hover {
      background-color: #334155;
      color: #fff;
    }

    .main-content {
      flex: 1;
      padding: 30px;
      background-color: #f9fafb;
    }

    /* Dashboard Header */
    .dashboard-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background-color: #fff;
      color: #1e293b;
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
      color: #1e293b;
    }

    /* Summary Boxes */
    .summary-boxes {
      display: flex;
      gap: 20px;
      /* Space between boxes */
      margin-bottom: 30px;
      flex-wrap: nowrap;
      /* Prevent wrapping to the next row */
      justify-content: space-between;
      /* Distribute boxes evenly */
    }

    .summary-box {
      flex-basis: 30%;
      /* Each box takes 30% of the row width */
      max-width: 300px;
      /* Optional: Limit the maximum width */
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
      color: #1e293b;
      margin-bottom: 10px;
    }

    .summary-box .value {
      font-size: 28px;
      font-weight: 700;
      color: #1e293b;
    }

    .summary-box .icon {
      position: absolute;
      top: 10px;
      right: 10px;
      font-size: 24px;
      color: #6b7280;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
      .summary-boxes {
        flex-direction: column;
        /* Stack boxes vertically */
        gap: 15px;
        /* Reduce gap between boxes */
      }

      .summary-box {
        flex-basis: 100%;
        /* Each box takes full width */
        max-width: 100%;
        /* Remove maximum width */
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
      color: #1e293b;
    }

    .table {
      border-collapse: separate;
      border-spacing: 0 10px;
    }

    .table th {
      background-color: #f3f4f6;
      color: #1e293b;
      font-weight: 600;
      text-align: center;
      padding: 12px;
    }

    .table td {
      color: #4b5563;
      text-align: center;
      vertical-align: middle;
      padding: 12px;
      background-color: #fff;
      border-bottom: 1px solid #e5e7eb;
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
      /* White background */
      color: #1e293b;
      /* Sidebar color for text */
      padding: 20px 30px;
      /* Padding for spacing */
      border-radius: 8px;
      /* Rounded corners */
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      /* Subtle shadow */
      margin-bottom: 20px;
      /* Space below the header */
    }

    .dashboard-header h1 {
      font-size: 24px;
      font-weight: 700;
      margin: 0;
    }

    .dashboard-header .date-time {
      font-size: 16px;
      font-weight: 500;
      color: #1e293b;
    }

    .status {
      font-weight: 500;
      padding: 2px 8px;
      border-radius: 5px;
      display: inline-block;
      text-align: center;
      margin: 0 auto;
    }

    .status.verified {
      background-color: #d1fae5;
      color: #065f46;
    }

    .status.unverified {
      background-color: #fee2e2;
      color: #b91c1c;
    }

    /* User Profile Section in Sidebar */
    .user-profile {
      margin-top: auto;
      /* Push the profile section to the bottom */
      text-align: center;
      padding: 20px 0;
      border-top: 1px solid #334155;
      /* Add a subtle border at the top */
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
      /* Light gray text */
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
      /* Darker red on hover */
    }
  </style>
</head>

<body>
  <div class="sidebar">
    <h2>Dashboard</h2>
    <a href="#"><i class="bi bi-house-door"></i> Home</a>
    <a href="#"><i class="bi bi-people"></i> Students</a>
    <a href="#"><i class="bi bi-book"></i> Courses</a>
    <a href="#"><i class="bi bi-bar-chart"></i> Reports</a>
    <a href="#"><i class="bi bi-gear"></i> Settings</a>

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
      <h1>Dashboard</h1>
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