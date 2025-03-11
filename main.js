$(document).ready(function () {
  $.ajax({
    url: "student_data.php",
    type: "GET",
    dataType: "json",
  })
    .done(function (data) {
      if (!Array.isArray(data) || data.length === 0) {
        console.error("Invalid or empty student data received");
        return;
      }

      console.log(data);
      let template = document.querySelector("#productTemplate");
      let parent = document.querySelector("#tableBody");

      data.forEach((item) => {
        if (!item.student_id) {
          console.error("Invalid student data entry:", item);
          return;
        }

        let clone = template.content.cloneNode(true);
        clone.querySelector(".stud_ID").innerHTML = item.student_id;
        clone.querySelector(".fname").innerHTML = item.first_name || "N/A";
        clone.querySelector(".lname").innerHTML = item.last_name || "N/A";
        clone.querySelector(".email").innerHTML = item.email || "N/A";
        clone.querySelector(".gender").innerHTML = item.gender || "N/A";
        clone.querySelector(".course").innerHTML = item.course || "N/A";
        clone.querySelector(".address").innerHTML = item.address || "N/A";

        let birthdate = new Date(item.birthdate);
        let ageDifMs = Date.now() - birthdate.getTime();
        let ageDate = new Date(ageDifMs);
        let age = Math.abs(ageDate.getUTCFullYear() - 1970);
        clone.querySelector(".age").innerHTML = isNaN(age) ? "N/A" : age;

        let profileImage = clone.querySelector(".profile-img");
        profileImage.src =
          item.profile && item.profile.trim() !== ""
            ? item.profile
            : "profiles/default.jpg";

        clone
          .querySelector(".update-btn")
          .addEventListener("click", function () {
            showUpdateModal(item);
          });
        clone
          .querySelector(".delete-btn")
          .addEventListener("click", function () {
            deleteStudent(item.student_id);
          });

        parent.appendChild(clone);
      });
    })
    .fail(function (jqXHR, textStatus, errorThrown) {
      console.error("Error fetching student data: ", textStatus, errorThrown);
    });

  $("#addStudentForm").submit(function (event) {
    event.preventDefault();

    let formData = new FormData(this);
    console.log("Submitting form:", formData);

    $.ajax({
      url: "std_create.php",
      type: "POST",
      dataType: "json",
      data: formData,
      processData: false,
      contentType: false,
    })
      .done(function (result) {
        console.log(result);
        if (result.res === "success") {
          alert("Student added successfully");
          location.reload();
        } else {
          alert("Failed to add student: " + result.msg);
        }
      })
      .fail(function (jqXHR, textStatus, errorThrown) {
        console.error("AJAX error: ", textStatus, errorThrown);
      });
  });
});

function deleteStudent(studentID) {
  $.ajax({
    url: "std_delete.php",
    type: "POST",
    dataType: "json",
    data: {
      student_id: Number(studentID),
    },
  })
    .done(function (result) {
      console.log(result);
      if (result.res === "success") {
        alert("Student deleted successfully");
        window.location.reload();
      } else {
        alert("Failed to delete student");
      }
    })
    .fail(function (jqXHR, textStatus, errorThrown) {
      console.error("Delete request failed: ", textStatus, errorThrown);
    });
}

function showUpdateModal(item) {
  $("#fname").val(item.first_name);
  $("#lname").val(item.last_name);
  $("#email").val(item.email);
  $("#gender").val(item.gender);
  $("#course").val(item.course);
  $("#address").val(item.address);
  $("#birthday").val(item.birthdate);
  $("#profileImage").val("");

  let profileSrc =
    item.profile && item.profile.trim() !== ""
      ? item.profile
      : "profiles/default.jpg";
  $("#profilePreview").attr("src", profileSrc);

  $("#addModal").modal("show");

  $("#addStudentForm")
    .off("submit")
    .one("submit", function (event) {
      event.preventDefault();

      let formData = new FormData(this);
      formData.append("student_id", item.student_id);
      console.log("Updating student:", formData);

      $.ajax({
        url: "std_update.php",
        type: "POST",
        dataType: "json",
        data: formData,
        processData: false,
        contentType: false,
      })
        .done(function (result) {
          console.log(result);
          if (result.res === "success") {
            alert("Student updated successfully");
            window.location.reload();
          } else {
            alert("Failed to update student: " + result.msg);
          }
        })
        .fail(function (jqXHR, textStatus, errorThrown) {
          console.error("Update request failed: ", textStatus, errorThrown);
        });
    });
}
