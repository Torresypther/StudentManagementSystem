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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <style>
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

        .task-desc {
            max-width: 200px;
            word-wrap: break-word;
            white-space: normal;
            overflow: hidden;
        }

        .table-hover tbody tr:hover {
            background-color: #f1f5f9;
        }

        .table tbody tr:nth-child(even) {
            background-color: #f9fafb;
        }

        .table tbody tr:nth-child(odd) {
            background-color: #fff;
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
        <a href="#"><i class="bi bi-house-door"></i> Home</a>
        <a href="std-dashb.php"><i class="bi bi-book"></i> My Tasks</a>
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
        <div class="dashboard-header">
            <h1 class="dashboard-title">
                <i class="bi bi-kanban"></i> My Tasks
            </h1>
            <div class="date-time" id="dateTime"></div>
        </div>

        <div class="row justify-content-center table-container">
            <div class="col-12 mb-4">
                <h3>Pending Tasks</h3>
                <table class="table table-striped w-100">
                    <thead>
                        <tr>
                            <th scope="col">Task Name</th>
                            <th scope="col">Description</th>
                            <th scope="col">Deadline</th>
                            <th scope="col">Status</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="pendingTasksBody"></tbody>
                </table>
            </div>

            <template id="pendingTaskTemplate">
                <tr>
                    <td class="task-name">Task Name</td>
                    <td class="task-desc">Description</td>
                    <td class="task-deadline">Deadline</td>
                    <td class="task-status">Status</td>
                    <td>
                        <button class="btn btn-warning btn-sm edit-btn">
                            <i class="bi bi-eye"></i> View
                        </button>
                        <button class="btn btn-secondary btn-sm edit-btn">
                            <i class="bi bi-paperclip"></i> Attach
                        </button>
                    </td>
                </tr>
            </template>

            <div class="col-12">
                <h3>Completed Tasks</h3>
                <table class="table table-striped w-100">
                    <thead>
                        <tr>
                            <th scope="col">Task Name</th>
                            <th scope="col">Description</th>
                            <th scope="col">Deadline</th>
                            <th scope="col">Status</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="completedTasksBody"></tbody>
                </table>
            </div>

            <template id="completedTaskTemplate">
                <tr>
                    <td class="task-name">Task Name</td>
                    <td class="task-desc">Description</td>
                    <td class="task-deadline">Deadline</td>
                    <td class="task-status">Status</td>
                    <td>
                    <button class="btn btn-warning btn-sm edit-btn">
                            <i class="bi bi-eye"></i> View
                        </button>
                    </td>
                </tr>
            </template>
        </div>
    </div>

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
        referrerpolicy="no-referrer">
    </script>
    <script
        src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous">
    </script>
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

    <script>
        function fetchUserTasks(user_id) {
            $.ajax({
                url: "std-tasks.php",
                type: "GET",
                data: { user_id: user_id },
                dataType: "json",
            })
            .done(function(data) {
                console.log("Tasks fetched successfully:", data);

                const pendingTasksBody = document.getElementById("pendingTasksBody");
                const completedTasksBody = document.getElementById("completedTasksBody");
                pendingTasksBody.innerHTML = "";
                completedTasksBody.innerHTML = "";

                const pendingTaskTemplate = document.getElementById("pendingTaskTemplate");
                const completedTaskTemplate = document.getElementById("completedTaskTemplate");

                if (!pendingTaskTemplate || !completedTaskTemplate) {
                    console.error("Task templates not found in the DOM.");
                    return;
                }

                data.forEach(task => {
                    let taskRow;

                    if (task.task_status === "pending") {
                        taskRow = pendingTaskTemplate.content.cloneNode(true);
                    } else if (task.task_status === "completed") {
                        taskRow = completedTaskTemplate.content.cloneNode(true);
                    } else {
                        return;
                    }

                    taskRow.querySelector(".task-name").textContent = task.task_name;
                    taskRow.querySelector(".task-desc").textContent = task.task_desc;
                    taskRow.querySelector(".task-deadline").textContent = task.task_deadline;
                    taskRow.querySelector(".task-status").textContent = task.task_status;

                    if (task.task_status === "pending") {
                        pendingTasksBody.appendChild(taskRow);
                    } else if (task.task_status === "completed") {
                        completedTasksBody.appendChild(taskRow);
                    }
                });
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
                console.error("Failed to fetch user tasks:", textStatus, errorThrown);
            });
        }

        const user_id = <?php echo json_encode($user_id); ?>;
        console.log("User ID:", user_id);

        fetchUserTasks(user_id);
    </script>

    <script src="main.js"></script>
</body>
</html>