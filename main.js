$(document).ready(function () {
  // Initialize all functionalities
  loginUser();
  fetchStudentData();
  handleUserRegistration();
  enableProfileEditing();
  fetchLoggedInUserData();
  handleProfileFormSubmission();
  handleLogout();
  handleProfileEditTrigger();
});

function loginUser() {
  $("#loginForm").submit(function (event) {
    event.preventDefault();

    let formData = {
      email: $("#email").val(),
      password: $("#password").val(),
    };

    $.ajax({
      url: "login.php",
      type: "POST",
      dataType: "json",
      data: formData,
    })
      .done(function (response) {
        console.log(response);

        if (response.res === "success") {
          window.location.href = "dashboard.php";
        } else {
          alert("Login failed: " + response.msg);
        }
      })
      .fail(function (jqXHR, textStatus, errorThrown) {
        console.error("AJAX error: ", textStatus, errorThrown);
        alert("An error occurred while processing your request.");
      });
  });
}

function fetchStudentData() {
  $.ajax({
    url: "user_data.php", // Backend endpoint to fetch student data
    type: "GET",
    dataType: "json",
  })
    .done(function (data) {
      if (!Array.isArray(data) || data.length === 0) {
        console.error("Invalid or empty student data received");
        return;
      }

      let template = document.querySelector("#productTemplate");
      let parent = document.querySelector("#tableBody");
      parent.innerHTML = ""; // Clear existing rows

      let verifiedCount = 0; // Initialize verified users count

      data.forEach((item) => {
        if (!item.user_id) {
          console.error("Invalid student data entry:", item);
          return;
        }

        let clone = template.content.cloneNode(true);
        clone.querySelector(".fname").innerHTML = item.first_name || "N/A";
        clone.querySelector(".lname").innerHTML = item.last_name || "N/A";
        clone.querySelector(".course").innerHTML = item.course || "N/A";
        clone.querySelector(".address").innerHTML = item.address || "N/A";

        let statusElement = clone.querySelector(".status");
        if (item.is_verified == 1) {
          statusElement.innerHTML = "Verified";
          statusElement.classList.add("verified");
          verifiedCount++; // Increment verified users count
        } else {
          statusElement.innerHTML = "Unverified";
          statusElement.classList.add("unverified");
        }

        parent.appendChild(clone);
      });

      // Update the verified users count in the summary box
      document.getElementById("verifiedUsersCount").textContent = verifiedCount;
    })
    .fail(function (jqXHR, textStatus, errorThrown) {
      console.error("Error fetching student data: ", textStatus, errorThrown);
    });
}

// Handle user registration form submission
function handleUserRegistration() {
  $("#registerUser").submit(function (event) {
    event.preventDefault();

    let formData = new FormData(this);

    $.ajax({
      url: "register.php",
      type: "POST",
      dataType: "json",
      data: formData,
      processData: false,
      contentType: false,
    })
      .done(function (result) {
        if (result.res === "success") {
          alert("Verification Request Sent");
          window.location.reload();
        } else {
          alert("Failed to Request Verification: " + result.msg);
        }
      })
      .fail(function (jqXHR, textStatus, errorThrown) {
        console.error("AJAX error: ", textStatus, errorThrown);
      });
  });
}

// Enable profile editing in the modal
function enableProfileEditing() {
  document.getElementById("enableEditButton").addEventListener("click", function () {
    const inputs = document.querySelectorAll("#editProfileForm input, #editProfileForm select");
    inputs.forEach((input) => {
      input.disabled = false;
    });

    document.getElementById("saveChangesButton").disabled = false;
    this.disabled = true;
  });
}

// Fetch and display logged-in user data
function fetchLoggedInUserData() {
  $.ajax({
    url: "logged_user.php",
    type: "GET",
    dataType: "json",
  })
    .done(function (data) {
      if (data && data.first_name && data.last_name) {
        $(".user-name").text(`${data.first_name} ${data.last_name}`);
        const profileSrc = data.profile && data.profile.trim() !== "" ? data.profile : "profiles/default.jpg";
        $(".profile-img").attr("src", profileSrc);
      } else {
        console.error("Invalid user data received");
        $(".profile-img").attr("src", "profiles/default.jpg");
      }
    })
    .fail(function (jqXHR, textStatus, errorThrown) {
      console.error("Error fetching user data: ", textStatus, errorThrown);
      $(".profile-img").attr("src", "profiles/default.jpg");
    });
}

// Handle profile form submission
function handleProfileFormSubmission() {
  $("#editProfileForm").submit(function (event) {
    event.preventDefault();

    const formData = new FormData(this);

    $.ajax({
      url: "user_update.php", // Endpoint to update user data
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
    })
      .done(function (response) {
        if (response.success) {
          alert("Profile updated successfully!");
          location.reload();
        } else {
          alert("Failed to update profile: " + response.message);
        }
      })
      .fail(function (jqXHR, textStatus, errorThrown) {
        console.error("Error updating profile: ", textStatus, errorThrown);
      });
  });
}

// Handle logout functionality
function handleLogout() {
  $(".logout-btn").click(function () {
    $.ajax({
      url: "logout.php", // Endpoint to handle logout
      type: "POST",
    })
      .done(function () {
        window.location.href = "user_login.php"; // Redirect to login page
      })
      .fail(function (jqXHR, textStatus, errorThrown) {
        console.error("Error during logout: ", textStatus, errorThrown);
      });
  });
}

// Fetch and populate profile data in the modal when triggered
function handleProfileEditTrigger() {
  document.querySelector(".profile-edit-trigger").addEventListener("click", function () {
    $.ajax({
      url: "get_user_profile.php", // Endpoint to fetch user profile data
      type: "POST",
      dataType: "json",
      success: function (data) {
        if (data) {
          $("#fname").val(data.first_name);
          $("#lname").val(data.last_name);
          $("#email").val(data.email);
          $("#address").val(data.address);
          $("#gender").val(data.gender);
          $("#birthdate").val(data.birthdate);

          const profileSrc = data.profile && data.profile.trim() !== "" ? data.profile : "profiles/default.jpg";
          $("#profilePreview").attr("src", profileSrc);
        } else {
          alert("Failed to load user data.");
        }
      },
      error: function (xhr, status, error) {
        console.error("Error fetching user data:", error);
      },
    });
  });
}