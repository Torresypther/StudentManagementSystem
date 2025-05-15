<?php
session_start();

if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin'])) {
    header("Location: user_login.php");
    exit();
}

if ($_SESSION['is_admin'] != 1) {
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

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet" />

    <!-- Bootstrap Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet" />

    <!-- Bootstrap JS -->
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
            background: linear-gradient(to bottom right, #007358, rgb(1, 101, 77));
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
            color: #c8ffe9;
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
            /* Adds space between the icon and the text */
        }

        .sidebar a:hover {
            background-color: rgb(21, 214, 160);
            color: #fff;
        }

        .main-content {
            margin-left: 250px;
            padding: 30px;
            background-color: #e8fff7;
            width: calc(100% - 250px);
            box-sizing: border-box;
        }

        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #fff;
            color: #007358;
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
            color: #007358;
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
            color: #007358;
        }

        .table {
            border-collapse: separate;
            border-spacing: 0 10px;
        }

        .table th {
            color: #c8ffe9;
            background-color: #007358;
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
            color: #007358;
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
            background-color: rgb(179, 246, 219);
        }

        .table tbody tr:nth-child(even) {
            background-color: #e8fff7;
        }

        .table tbody tr:nth-child(odd) {
            background-color: #c8ffe9;
        }

        .table-container .no-data {
            text-align: center;
            color: #e8fff7;
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

        .status-tag {
            display: inline-block;
            width: 100px;
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 13.5px;
            color: #3d43aa;
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

        .status-tag.approved {
            background-color: #d1fae5;
            color: #065f46;
        }

        .status-tag.unapproved {
            background-color: #fee2e2;
            color: #b91c1c;
        }

        .status-tag.missing {
            background-color: #fee2e2;
            color: #b91c1c;
        }

        .status-tag.submitted {
            background-color: #d1fae5;
            color: #065f46;
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
            color: #c8ffe9;
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

        /* Modal Header */
        .modal-header {
            background-color: #007358;
            /* Primary green color */
            color: #ffffff;
            /* White text for contrast */
            border-bottom: none;
            /* Remove default border */
        }

        .modal-header .btn-close {
            background-color: #ffffff;
            /* White close button */
            border: none;
            opacity: 1;
        }

        .modal-header .btn-close:hover {
            background-color: #c8ffe9;
            /* Light green hover effect */
        }

        /* Modal Title */
        .modal-title {
            font-size: 20px;
            font-weight: 700;
        }

        .modal-body {
            background-color: rgb(251, 255, 254);
            /* Light green background */
            color: #007358;
            /* Primary text color */
            padding: 20px;
            border-radius: 8px;
        }

        .modal-footer {
            background-color: rgb(251, 255, 254);
            /* Light green background */
            border-top: none;
            /* Remove default border */
        }

        .modal-footer .btn-primary {
            background-color: #007358;
            border: none;
            color: #ffffff;
        }

        .modal-footer .btn-primary:hover {
            background-color: rgb(1, 101, 77);
        }

        .modal-footer .btn-secondary {
            background-color: #c8ffe9;
            border: none;
            color: #007358;
        }

        .modal-footer .btn-secondary:hover {
            background-color: #b3f6db;
        }

        .modal-body .form-control {
            border: 1px solid #007358;
            border-radius: 5px;
            padding: 10px;
            color: #007358;
        }

        .modal-body .form-control:focus {
            border-color: rgb(1, 101, 77);
            box-shadow: 0 0 5px rgba(1, 101, 77, 0.5);
        }

        .modal-body label {
            font-weight: 600;
            color: #007358;
        }

        .modal-body .input-file label,
        .modal-body .input-link label {
            font-weight: 600;
            color: #007358;
        }

        .modal-body .input-file input,
        .modal-body .input-link input {
            border: 1px solid #007358;
            border-radius: 5px;
            padding: 10px;
            color: #007358;
        }

        .modal-body .text h5 {
            color: #007358;
            font-weight: 700;
            text-align: center;
            margin: 15px 0;
        }

        /* Modal Field Tags */
        .modal-body .tag {
            display: inline-block;
            padding: 8px 12px;
            font-size: 14px;
            font-weight: 600;
            color: #fff;
            border-radius: 20px;
            margin-top: 5px;
            margin-bottom: 5px;
            text-align: center;
            white-space: nowrap;
        }

        /* Specific Colors for Tags */
        .modal-body .tag.task-name {
            background-color: #007358;
            /* Primary green */
        }

        .modal-body .tag.deadline {
            background-color: #f59e0b;
            /* Warning yellow */
        }

        .modal-body .tag.status {
            background-color: #10b981;
            /* Success green */
        }

        .modal-body .tag.description {
            background-color: #3b82f6;
            /* Info blue */
        }

        .modal-body .tag.submission {
            background-color: #6b7280;
            /* Secondary gray */
            text-decoration: underline;
            cursor: pointer;
        }

        /* Hover Effect for Submission Link */
        .modal-body .tag.submission:hover {
            background-color: #4b5563;
            /* Darker gray */
            text-decoration: none;
        }
    </style>

</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Dashboard</h2>
        <a href="#"><i class="bi bi-house-door"></i> Home</a>
        <a href="std-dashb.php"><i class="bi bi-book"></i> My Tasks</a>
        <a href="churn_prediction.html"><i class="bi bi-book"></i> Churn Prediction</a>

        <!-- User Profile Section -->
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

    <!-- Main Content -->
    <div class="main-content">
        <div class="dashboard-header">
            <h1 class="dashboard-title">
                <i class="bi bi-kanban"></i> My Tasks
            </h1>
            <div class="date-time" id="dateTime"></div>
        </div>
        <!-- Pending Tasks Table -->
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
            <!-- Pending Task Template -->
            <template id="pendingTaskTemplate">
                <tr data-id="">
                    <td class="task-name">Task Name</td>
                    <td class="task-desc">Description</td>
                    <td class="task-deadline">Deadline</td>
                    <td class="task-status"><span class="status-tag"></span></td>
                    <td>
                        <button type="button" class="btn btn-info btn-md attach-file-btn" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <i class="bi bi-paperclip"></i>
                        </button>
                    </td>
                </tr>
            </template>
            <!-- Completed Tasks Table -->
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
            <!-- Completed Task Template -->
            <template id="completedTaskTemplate">
                <tr data-id="">
                    <td class="task-name">Task Name</td>
                    <td class="task-desc">Description</td>
                    <td class="task-deadline">Deadline</td>
                    <td class="task-status"><span class="status-tag"></span></td>
                    <td>
                        <button class="btn btn-warning btn-md edit-btn" data-bs-toggle="modal" data-bs-target="#viewTaskModal">
                            <i class="bi bi-eye"></i>
                        </button>
                    </td>
                </tr>
            </template>
            <!-- Approved Tasks Table -->
            <div class="col-12">
                <h3>Approved Tasks</h3>
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
                    <tbody id="approvedTasksBody"></tbody>
                </table>
            </div>
            <!-- Approved Task Template -->
            <template id="approvedTaskTemplate">
                <tr data-id="">
                    <td class="task-name">Task Name</td>
                    <td class="task-desc">Description</td>
                    <td class="task-deadline">Deadline</td>
                    <td class="task-status"><span class="status-tag"></span></td>
                    <td>
                        <button class="btn btn-warning btn-md edit-btn" data-bs-toggle="modal" data-bs-target="#viewTaskModal">
                            <i class="bi bi-eye"></i>
                        </button>
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

    <!-- Student Submission Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Submission Portal</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="formContainer">
                        <form id="submissionForm" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="task_id" id="task_id" value="" />
                            <input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id; ?>" />

                            <div class="mb-3">
                                <label for="type" class="form-label">Submission Type</label>
                                <select name="type" id="type" class="form-control">
                                    <option value="">Select</option>
                                    <option value="file">File</option>
                                    <option value="link">Link</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="file" class="form-label">File</label>
                                <input type="file" name="student_file" id="file" class="form-control" disabled />
                            </div>

                            <div class="text-center my-3">
                                <h5>OR</h5>
                            </div>

                            <div class="mb-3">
                                <label for="link" class="form-label">Link</label>
                                <input type="text" name="link" id="link" class="form-control" placeholder="www.example.com" disabled />
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- View Task Modal -->
    <div class="modal fade" id="viewTaskModal" tabindex="-1" aria-labelledby="viewTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewTaskModalLabel">View Completed Task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Task Name, Deadline, and Status in One Row -->
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Task Name</label>
                            <input type="text" id="viewTaskName" class="form-control bg-light text-muted" readonly />
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Deadline</label>
                            <input type="text" id="viewTaskDeadline" class="form-control bg-light text-muted" readonly />
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Status</label>
                            <input type="text" id="viewTaskStatus" class="form-control bg-light text-muted" readonly />
                        </div>
                    </div>
                    <!-- Description Below -->
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Description</label>
                            <textarea id="viewTaskDescription" class="form-control bg-light text-muted" rows="3" readonly></textarea>
                        </div>
                    </div>
                    <!-- View Submission Below Description -->
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Submitted: File or Link</label>
                            <a href="#" id="viewTaskSubmission" target="_blank" class="btn btn-link">View File/Link</a>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery Library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.js" integrity="sha512-+k1pnlgt4F1H8L7t3z95o3/KO+o78INEcXTbnoJQ/F2VqDVhWoaiVml/OEHv9HsVgxUaVW+IbiZPUJQfF/YxZw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- jQuery Fallback -->
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

    <!-- Script for Profile Edit Trigger -->
    <script>
        document.querySelector('.profile-edit-trigger').addEventListener('click', function() {
            const form = document.getElementById('editUserForm');
            form.style.display = form.style.display === 'none' ? 'block' : 'none';
        });
    </script>

    <!-- Script for Updating Date and Time -->
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

    <!-- Handle File Type Input Enabling -->
    <script>
        $(document).ready(function() {
            // Handle submission type selection
            $("#type").on("change", function() {
                const selectedType = $(this).val();

                if (selectedType === "file") {
                    // Enable file input and disable link input
                    $("#file").prop("disabled", false);
                    $("#link").prop("disabled", true).val(""); // Clear the link input
                } else if (selectedType === "link") {
                    // Enable link input and disable file input
                    $("#link").prop("disabled", false);
                    $("#file").prop("disabled", true).val(""); // Clear the file input
                } else {
                    // If no type is selected, disable both inputs
                    $("#file").prop("disabled", true).val("");
                    $("#link").prop("disabled", true).val("");
                }
            });

            // Trigger the change event on page load to set the initial state
            $("#type").trigger("change");
        });
    </script>

    <!-- Script for Handling Attach File Button -->
    <script>
        $(document).on("click", ".attach-file-btn", function() {
            const taskRow = $(this).closest("tr");
            const taskId = taskRow.data("id");
            const userId = <?php echo json_encode($user_id); ?>;

            if (taskId && userId) {
                // Set the task_id and user_id in the hidden input fields of the submission form
                $("#submissionForm").find("input[name='task_id']").val(taskId);
                $("#submissionForm").find("input[name='user_id']").val(userId);
            } else {
                console.error("Task ID or User ID not found for the clicked row.");
            }
        });
    </script>

    <!-- Script for Fetching User Tasks -->
    <script>
        // Define user_id from PHP session at the top
        const user_id = <?php echo json_encode($user_id); ?>;
        console.log("User ID:", user_id);

        function fetchUserTasks(user_id) {
            $.ajax({
                    url: "std-tasks.php",
                    type: "GET",
                    data: {
                        user_id: user_id
                    },
                    dataType: "json",
                })
                .done(function(data) {
                    console.log("Tasks fetched successfully:", data);

                    const pendingTasksBody = document.getElementById("pendingTasksBody");
                    const completedTasksBody = document.getElementById("completedTasksBody");
                    pendingTasksBody.innerHTML = "";
                    completedTasksBody.innerHTML = "";
                    approvedTasksBody.innerHTML = "";

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
                        } else if (task.task_status === "approved") {
                            taskRow = approvedTaskTemplate.content.cloneNode(true);
                        } else {
                            return;
                        }

                        taskRow.querySelector(".task-name").textContent = task.task_name;
                        taskRow.querySelector(".task-desc").textContent = task.task_desc;
                        taskRow.querySelector(".task-deadline").textContent = task.task_deadline;
                        taskRow.querySelector(".task-status").textContent = task.task_status;

                        const row = taskRow.querySelector("tr");
                        row.setAttribute("data-id", task.task_id);

                        if (task.task_status === "pending") {
                            pendingTasksBody.appendChild(taskRow);
                        } else if (task.task_status === "completed") {
                            completedTasksBody.appendChild(taskRow);
                        } else if (task.task_status === "approved") {
                            approvedTasksBody.appendChild(taskRow);
                        }
                    });
                })
                .fail(function(jqXHR, textStatus, errorThrown) {
                    console.error("Failed to fetch user tasks:", textStatus, errorThrown);
                });
        }

        fetchUserTasks(user_id);
    </script>

    <!-- Script for Viewing Task Details -->
    <script>
        $(document).on("click", ".edit-btn", function() {
            const taskRow = $(this).closest("tr");
            const taskId = taskRow.data("id");
            const userId = <?php echo json_encode($user_id); ?>;

            if (taskId && userId) {
                $.ajax({
                    url: "std-task-details.php",
                    type: "GET",
                    data: {
                        task_id: taskId,
                        user_id: userId,
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data.success) {
                            // Populate the modal fields
                            $("#viewTaskName").val(data.task_name);
                            $("#viewTaskDeadline").val(data.task_deadline);
                            $("#viewTaskStatus").val(data.task_status);
                            $("#viewTaskDescription").val(data.task_desc);
                            $("#viewTaskSubmission").attr("href", data.submitted_file).text("View File/Link");
                        } else {
                            alert("Failed to fetch task details: " + data.msg);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error("Error fetching task details:", textStatus, errorThrown);
                        alert("An error occurred while fetching task details.");
                    },
                });
            } else {
                console.error("Task ID or User ID not found for the clicked row.");
            }
        });
    </script>

    <!-- Main JS File -->
    <script src="main.js"></script>
</body>

</html>