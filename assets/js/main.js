$(document).ready(function () {
  $("#signinback").on("click", function (e) {
    e.preventDefault();
    Swal.fire({
      title: "Go to Login",
      text: "Back to SignIn Page",
      icon: "success",
      toast: true,
      position: "top-end",
      timer: 3000,
      showConfirmButton: false,
    }).then(() => {
      window.location.href = base_url + "src/";
    });
  });

// GET METHODS =============================================================================
    $(document).on("click", "#getID", function (e) {
      const employee_id = $(this).data("id");
      document.getElementById("employee_id").value = employee_id;
    });
    $(document).on("click", "#getLeaveIdDelete", function (e) {
      const leaves_id = $(this).data("id");
      document.getElementById("delete_leaves_id").value = leaves_id;
    });
    $(document).on("click", "#delete-file", function (e) {
      const files_id = $(this).data("id");
      document.getElementById("files_id").value = files_id;
    });
    $("#InclusiveFrom, #InclusiveTo").on("change", function () {
      $("#numberOfDays").removeClass("is-invalid");
      $("#daysError").text("");
    });
    $(document).on('click', '#getEmployeeId', function () {
          const employee_id = $(this).data('id');
          document.getElementById('approval_employeeID').value = employee_id;
          document.getElementById('rejection_employeeID').value = employee_id;
    });
    $(document).on("click", "#scheduleTemplateId", function () {
      const TemplateId = $(this).data("id");
      document.getElementById("TemplateId").value = TemplateId;
    });
    $(document).on("click", "#GetDeleteIdFromUniitSection", function (){
      const unitSectionId = $(this).data('id');
      // alert(unitSectionId);
      document.getElementById('deleteUnitSectionsId').value = unitSectionId;
      document.getElementById('editUnitSectionsId').value = unitSectionId;
    });
    $(document).on("click", "#getDeletionEmployee_id", function (){
      const employee_id = $(this).data('id');
      // alert(employee_id);
      document.getElementById('deletion_employeeID').value = employee_id;
    });

  // Login Forms here ===========================================================
      // $(document).on("submit", "#login-form", function (e) {
      //     e.preventDefault();
      //     const $form = $(this);
      //     if ($form.data("isSubmitted")) return;
      //     $form.data("isSubmitted", true);

      //     const formData = new FormData(this);
      //     const $btn = $form.find("button[type='submit']");
      //     $btn.prop("disabled", true);
      //     $btn.html('<i class="fas fa-spinner fa-spin me-1"></i> Sending Verification Code...');

      //     $.ajax({
      //         url: base_url + "authentication/action.php?action=login",
      //         type: "POST",
      //         data: formData,
      //         processData: false,
      //         contentType: false,
      //         dataType: "json",
      //         success: function (response) {
      //             if (response.status === 1) {
      //                 Swal.fire({
      //                     title: "Success!",
      //                     text: response.message,
      //                     icon: "success",
      //                     toast: true,
      //                     position: "top-end",
      //                     timer: 3000,
      //                     showConfirmButton: false,
      //                 }).then(() => {
      //                   window.location.href = 'loginVerification.php';
      //                 });
      //             } else {
      //                 Swal.fire({
      //                     title: "Error",
      //                     text: response.message,
      //                     icon: "error",
      //                     toast: true,
      //                     position: "top-end",
      //                     timer: 3000,
      //                     showConfirmButton: false,
      //                 });
      //             }
      //         },
      //         error: function (jqXHR, textStatus, err) {
      //             console.error("AJAX error:", textStatus, err);
      //             Swal.fire({
      //                 title: "Connection Error",
      //                 text: textStatus + ": " + err,
      //                 icon: "error",
      //                 toast: true,
      //                 position: "top-end",
      //                 timer: 3000,
      //                 showConfirmButton: false,
      //             });
      //         },
      //         complete: function () {
      //             $form.data("isSubmitted", false);
      //             $btn.prop("disabled", false).html('Create Account');
      //         }
      //     });
      // });
  //  ============================================================================================
  
  $(document).on("submit", "#login-verification-form", function (e) {
    e.preventDefault();

    const $form = $(this);
    if ($form.data("isSubmitted")) return;
    $form.data("isSubmitted", true);

    const formData = new FormData(this);
    const $btn = $form.find("button[type='submit']");
    $btn
      .prop("disabled", true)
      .html('<i class="fas fa-spinner fa-spin me-1"></i> Processing...');

    $.ajax({
      url:
        base_url + "authentication/action.php?action=login_verification_form",
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      dataType: "json",
      success: function (response) {
        if (response.status == 1) {
          // ✅ Success state
          $btn.html(`<i class="fas fa-check me-1"></i> Login Success!`);

          let userRole = "ADMIN";
          if (response.user_role) {
            userRole = response.user_role;
            userRole =
              userRole.charAt(0).toUpperCase() +
              userRole.slice(1).toLowerCase().replace(/_/g, " ");
          }

          Swal.fire({
            title: `<div class="d-flex align-items-center justify-content-center mb-3">
                                <img src="../assets/image/system_logo/pueri-logo.png" style="height: 90px; width: auto;"/>
                              </div>`,
            html: `
                          <h5 style="font-weight: 500; color: #000; margin-bottom: 20px;">
                              Logging in as <strong style="color: #E32126;">${userRole}</strong>
                          </h5>
                          <div style="height: 1rem; !important; width: 16.9rem !important;  margin: 15px; border-radius: 4px; background: #f5f5f5; overflow: hidden;">
                              <div style="height: 1rem !important; width: 16.9rem !important; 
                                        background: linear-gradient(90deg, #e3212791 50%, #E32126 100%);
                                        background-size: 200% 100%;
                                        animation: progressAnimation 6.5s linear infinite;">
                              </div>
                          </div>
                      `,
            showConfirmButton: false,
            allowOutsideClick: false,
            customClass: {
              popup: "custom-swal",
              htmlContainer: "custom-html-container",
            },
            didOpen: () => {
              const loadingIcon = document.querySelector(
                ".swal2-icon.swal2-loading"
              );
              if (loadingIcon) loadingIcon.style.display = "none";
            },
          });

          // ✅ Redirect after delay
          setTimeout(() => {
            const redirectUrl = response.redirect_url
              ? base_url + response.redirect_url
              : base_url + "src/";
            window.location.href = redirectUrl;
          }, 1500);
        } else {
          // ❌ Failed response
          Swal.fire({
            title: "Error",
            text: response.message || "Login failed, please try again.",
            icon: "error",
            toast: true,
            position: "top-end",
            timer: 3000,
            showConfirmButton: false,
          });
        }
      },
      error: function (jqXHR, textStatus, err) {
        console.error("AJAX error:", textStatus, err);
        Swal.fire({
          title: "Connection Error",
          text: "Please check your connection and try again.",
          icon: "error",
          toast: true,
          position: "top-end",
          timer: 3000,
          showConfirmButton: false,
        });
      },
      complete: function () {
        $form.data("isSubmitted", false);
        $btn.prop("disabled", false).html("Login");
      },
    });
  });
  //   this is for offline login, and will be the back-up
  // $("body").on("submit", "#login-form", function (e) {
  //   e.preventDefault();
  //   const $this = $(this);
  //   const username = $this.find("input[name=username]").val();
  //   const password = $this.find("input[name=password]").val();

  //   if (!$this.hasClass("processing")) {
  //     $this.addClass("processing");

  //     const $submitBtn = $this.find("button[type='submit']");
  //     const originalBtnText = $submitBtn.text();

  //     $.ajax({
  //       url: base_url + "/authentication/action.php?action=login",
  //       method: "POST",
  //       dataType: "json",
  //       data: {
  //         username: username,
  //         password: password,
  //       },
  //       beforeSend: function () {
  //         $submitBtn
  //           .prop("disabled", true)
  //           .html(
  //             `<span class="spinner-border spinner-border-sm"></span> Processing...`
  //           );
  //       },
  //       success: function (response) {
  //         if (response.status == 1) {
  //           $this.find("button").text("Login Success!");
  //           Swal.fire({
  //             title: "Success!",
  //             text: response.message,
  //             icon: "success",
  //             toast: true,
  //             position: "top-end",
  //             timer: 3000,
  //             showConfirmButton: false,
  //           }).then(() => {
  //             window.location.href =
  //               base_url + response.redirect_url || base_url + "src/";
  //           });
  //           $this.removeClass("processing");
  //         } else {
  //           showError(response.message);
  //           $this.removeClass("processing");
  //           $this.find("button").text("Login");
  //         }
  //       },
  //       error: function (jqXHR, textStatus, errorThrown) {
  //         console.error("AJAX error:", textStatus, errorThrown);
  //         if (jqXHR) {
  //           Swal.fire({
  //             title: "Failed",
  //             icon: "error",
  //             text: "Incorrect Email/Username or Password",
  //             toast: true,
  //             position: "top-end",
  //             timer: 3000,
  //             showConfirmButton: false,
  //           });
  //           $this.removeClass("processing");
  //         }
  //         $this.removeClass("processing");
  //       },
  //       complete: function () {
  //         $submitBtn.prop("disabled", false).html(originalBtnText);
  //         $this.removeClass("processing");
  //       },
  //     });
  //   }
  // });

  $("body").on("submit", "#login-form", function (e) {
    e.preventDefault();
    const $this = $(this);
    const username = $this.find("input[name=username]").val();
    const password = $this.find("input[name=password]").val();

    if (!$this.hasClass("processing")) {
      $this.addClass("processing");

      const $submitBtn = $this.find("button[type='submit']");
      const originalBtnText = $submitBtn.text();

      $.ajax({
        url: base_url + "/authentication/action.php?action=login",
        method: "POST",
        dataType: "json",
        data: {
          username: username,
          password: password,
        },
        beforeSend: function () {
          $submitBtn
            .prop("disabled", true)
            .html(
              `<span class="spinner-border spinner-border-sm"></span> Processing...`
            );
        },
        success: function (response) {
        if (response.status == 1) {
          // ✅ Success state
          $submitBtn.html(`<i class="fas fa-check me-1"></i> Login Success!`);

          let userRole = "User";
          if (response.user_role) {
            userRole = response.user_role;
            userRole =
              userRole.charAt(0).toUpperCase() +
              userRole.slice(1).toLowerCase().replace(/_/g, " ");
          }

          Swal.fire({
            title: `<div class="d-flex align-items-center justify-content-center mb-3">
                                <img src="../assets/image/system_logo/pueri-logo.png" style="height: 90px; width: auto;"/>
                              </div>`,
            html: `
                          <h5 style="font-weight: 500; color: #000; margin-bottom: 20px;">
                              Logging in as <strong style="color: #E32126;">${userRole}</strong>
                          </h5>
                          <div style="height: 1rem; !important; width: 16.9rem !important;  margin: 15px; border-radius: 4px; background: #f5f5f5; overflow: hidden;">
                              <div style="height: 1rem !important; width: 16.9rem !important; 
                                        background: linear-gradient(90deg, #e3212791 50%, #E32126 100%);
                                        background-size: 200% 100%;
                                        animation: progressAnimation 6.5s linear infinite;">
                              </div>
                          </div>
                      `,
            showConfirmButton: false,
            allowOutsideClick: false,
            customClass: {
              popup: "custom-swal",
              htmlContainer: "custom-html-container",
            },
            didOpen: () => {
              const loadingIcon = document.querySelector(
                ".swal2-icon.swal2-loading"
              );
              if (loadingIcon) loadingIcon.style.display = "none";
            },
          });

          // ✅ Redirect after delay
          setTimeout(() => {
            const redirectUrl = response.redirect_url
              ? base_url + response.redirect_url
              : base_url + "src/";
            window.location.href = redirectUrl;
          }, 1500);
        } else {
            showError(response.message);
            $this.removeClass("processing");
            $this.find("button").text("Login");
          }
        },
        error: function (jqXHR, textStatus, errorThrown) {
          console.error("AJAX error:", textStatus, errorThrown);
          if (jqXHR) {
            Swal.fire({
              title: "Failed",
              icon: "error",
              text: "Incorrect Email/Username or Password",
              toast: true,
              position: "top-end",
              timer: 3000,
              showConfirmButton: false,
            });
            $this.removeClass("processing");
          }
          $this.removeClass("processing");
        },
        complete: function () {
          $submitBtn.prop("disabled", false).html(originalBtnText);
          $this.removeClass("processing");
        },
      });
    }
  });

  $("body").on("click", "#logout", function (e) {
    e.preventDefault();
    const $this = $(this);
    $.ajax({
      url: base_url + "authentication/action.php?action=logout",
      method: "POST",
      dataType: "json",
      beforeSend: function () {
        $this.text("Logging out...");
      },
      success: function (response) {
        if (response.status == 1) {
          Swal.fire({
            title: "Success!",
            text: response.message,
            icon: "success",
            toast: true,
            position: "top-end",
            timer: 3000,
            showConfirmButton: false,
          }).then(() => {
            window.location.href =
              base_url + (response.redirect_url || "index.php");
          });
        } else {
          showError(response.message);
        }
      },
      error: function () {
        console.error("AJAX error");
      },
    });
  });

// FORGOT ACCOUNT ============================================================================== 
  $(document).on("submit", "#changePassword-verification-form", function (e) { 
      e.preventDefault();
      const $form = $(this);
      if ($form.data("isSubmitted")) return;
      $form.data("isSubmitted", true);
      
      const formData = new FormData(this);
      const $btn = $form.find("button[type='submit']");
      $btn.prop("disabled", true);
      $btn.html('<i class="fas fa-spinner fa-spin me-1"></i> Sending Verification Code...');
      
      $.ajax({
          url: base_url + "authentication/action.php?action=changePassword_verification_form",
          type: "POST",
          data: formData,
          processData: false,
          contentType: false,
          dataType: "json",
          success: function (response) {
              if (response.status === 1) {
                  Swal.fire({
                      title: "Success!",
                      text: response.message,
                      icon: "success",
                      toast: true,
                      position: "top-end",
                      timer: 1000,
                      showConfirmButton: false,
                  }).then(() => {
                    window.location.href = 'changePassword.php';
                  });
              } else {
                  Swal.fire({
                      title: "Error",
                      text: response.message,
                      icon: "error",
                      toast: true,
                      position: "top-end",
                      timer: 1000,
                      showConfirmButton: false,
                  });
              }
          },
          error: function (jqXHR, textStatus, err) {
              console.error("AJAX error:", textStatus, err);
              Swal.fire({
                  title: "Connection Error",
                  text: "Please check your connection and try again.",
                  icon: "error",
                  toast: true,
                  position: "top-end",
                  timer: 1000,
                  showConfirmButton: false,
              });
          },
          complete: function () {
              $form.data("isSubmitted", false);
              $btn.prop("disabled", false).html('Success!');
          }
      });
  });
  $(document).on("submit", "#changePassword-form", function (e) {
    e.preventDefault();
    const $form = $(this);
    if ($form.data("isSubmitted")) return;
    $form.data("isSubmitted", true);

    // Validate passwords match
    const password = $form.find('[name="password"]').val();
    const cpassword = $form.find('[name="cpassword"]').val();

    const formData = new FormData(this);
    const $btn = $form.find("button[type='submit']");
    $btn.prop("disabled", true);
    $btn.html(
      '<i class="fas fa-spinner fa-spin me-1"></i> Sending Verification Code...'
    );

    $.ajax({
      url: base_url + "authentication/action.php?action=password_form",
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      dataType: "json",
      success: function (response) {
        if (response.status === 1) {
          Swal.fire({
            title: "Success!",
            text: response.message,
            icon: "success",
            toast: true,
            position: "top-end",
            timer: 3000,
            showConfirmButton: false,
          }).then(() => {
            window.location.href = "index.php";
          });
        } else {
          Swal.fire({
            title: "Error",
            text: response.message,
            icon: "error",
            toast: true,
            position: "top-end",
            timer: 3000,
            showConfirmButton: false,
          });
        }
      },
      error: function (jqXHR, textStatus, err) {
        console.error("AJAX error:", textStatus, err);
        Swal.fire({
          title: "Connection Error",
          text: "Please check your connection and try again.",
          icon: "error",
          toast: true,
          position: "top-end",
          timer: 3000,
          showConfirmButton: false,
        });
      },
      complete: function () {
        $form.data("isSubmitted", false);
        $btn.prop("disabled", false).html("Processing");
      },
    });
  });
  $(document).on("submit", "#forget-account-form", function (e) {
    e.preventDefault();
    const $form = $(this);
    if ($form.data("isSubmitted")) return;
    $form.data("isSubmitted", true);

    // Validate passwords match
    const password = $form.find('[name="password"]').val();
    const cpassword = $form.find('[name="cpassword"]').val();

    const formData = new FormData(this);
    const $btn = $form.find("button[type='submit']");
    $btn.prop("disabled", true);
    $btn.html(
      '<i class="fas fa-spinner fa-spin me-1"></i> Sending Verification Code...'
    );

    $.ajax({
      url: base_url + "authentication/action.php?action=forget_account_form",
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      dataType: "json",
      success: function (response) {
        if (response.status === 1) {
          Swal.fire({
            title: "Success!",
            text: response.message,
            icon: "success",
            toast: true,
            position: "top-end",
            timer: 3000,
            showConfirmButton: false,
          }).then(() => {
            window.location.href = "veirificationPass.php";
          });
        } else {
          Swal.fire({
            title: "Error",
            text: response.message,
            icon: "error",
            toast: true,
            position: "top-end",
            timer: 3000,
            showConfirmButton: false,
          });
        }
      },
      error: function (jqXHR, textStatus, err) {
        console.error("AJAX error:", textStatus, err);
        Swal.fire({
          title: "Connection Error",
          text: "Please check your connection and try again.",
          icon: "error",
          toast: true,
          position: "top-end",
          timer: 3000,
          showConfirmButton: false,
        });
      },
      complete: function () {
        $form.data("isSubmitted", false);
        $btn.prop("disabled", false).html("Processing");
      },
    });
  });
  

// DEPARTMENTS =======================================================================
  $(document).on("submit", "#department-form", function (e) { 
      e.preventDefault();
      const $form = $(this);
      if ($form.data("isSubmitted")) return;
      $form.data("isSubmitted", true);
      
      const formData = new FormData(this);
      const $btn = $form.find("button[type='submit']");
      $btn.prop("disabled", true);
      $btn.html('<i class="fas fa-spinner fa-spin me-1"></i> Processing...');
      
      $.ajax({
          url: base_url + "authentication/action.php?action=department_form",
          type: "POST",
          data: formData,
          processData: false,
          contentType: false,
          dataType: "json",
          success: function (response) {
              if (response.status === 1) {
                  Swal.fire({
                      title: "Success!",
                      text: response.message,
                      icon: "success",
                      toast: true,
                      position: "top-end",
                      timer: 1000,
                      showConfirmButton: false,
                  }).then(() => {
                      location.reload();
                  });
              } else {
                  Swal.fire({
                      title: "Error",
                      text: response.message,
                      icon: "error",
                      toast: true,
                      position: "top-end",
                      timer: 1000,
                      showConfirmButton: false,
                  });
              }
          },
          error: function (jqXHR, textStatus, err) {
              console.error("AJAX error:", textStatus, err);
              Swal.fire({
                  title: "Connection Error",
                  text: "Please check your connection and try again.",
                  icon: "error",
                  toast: true,
                  position: "top-end",
                  timer: 1000,
                  showConfirmButton: false,
              });
          },
          complete: function () {
              $form.data("isSubmitted", false);
              $btn.prop("disabled", false).html('Create Department');
          }
      });
  });
  $(document).on("submit", "#edit-department", function (e) {
    e.preventDefault();
    const $form = $(this);
    if ($form.data("isSubmitted")) return;
    $form.data("isSubmitted", true);

    // Validate passwords match
    const password = $form.find('[name="password"]').val();
    const cpassword = $form.find('[name="cpassword"]').val();

    if (password !== cpassword) {
      Swal.fire({
        title: "Error",
        text: "Passwords do not match!",
        icon: "error",
        toast: true,
        position: "top-end",
        timer: 1000,
        showConfirmButton: false,
      });
      $form.data("isSubmitted", false);
      return;
    }

    const formData = new FormData(this);
    const $btn = $form.find("button[type='submit']");
    $btn.prop("disabled", true);
    $btn.html('<i class="fas fa-spinner fa-spin me-1"></i> Processing...');

    $.ajax({
      url: base_url + "authentication/action.php?action=edit_department",
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      dataType: "json",
      success: function (response) {
        if (response.status === 1) {
          Swal.fire({
            title: "Success!",
            text: response.message,
            icon: "success",
            toast: true,
            position: "top-end",
            timer: 1000,
            showConfirmButton: false,
          }).then(() => {
            location.reload();
          });
        } else {
          Swal.fire({
            title: "Error",
            text: response.message,
            icon: "error",
            toast: true,
            position: "top-end",
            timer: 1000,
            showConfirmButton: false,
          });
        }
      },
      error: function (jqXHR, textStatus, err) {
        console.error("AJAX error:", textStatus, err);
        Swal.fire({
          title: "Connection Error",
          text: "Please check your connection and try again.",
          icon: "error",
          toast: true,
          position: "top-end",
          timer: 1000,
          showConfirmButton: false,
        });
      },
      complete: function () {
        $form.data("isSubmitted", false);
        $btn.prop("disabled", false).html("Edit Department");
      },
    });
  });
  $(document).on("submit", "#department-delete-form", function (e) {
    e.preventDefault();
    const $form = $(this);
    if ($form.data("isSubmitted")) return;
    $form.data("isSubmitted", true);

    const formData = new FormData(this);
    const $btn = $form.find("button[type='submit']");
    $btn.prop("disabled", true);
    $btn.html('<i class="fas fa-spinner fa-spin me-1"></i> Processing...');

    $.ajax({
      url: base_url + "authentication/action.php?action=department_delete_form",
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      dataType: "json",
      success: function (response) {
        if (response.status === 1) {
          Swal.fire({
            title: "Success!",
            text: response.message,
            icon: "success",
            toast: true,
            position: "top-end",
            timer: 1000,
            showConfirmButton: false,
          }).then(() => {
            location.reload();
          });
        } else {
          Swal.fire({
            title: "Error",
            text: response.message,
            icon: "error",
            toast: true,
            position: "top-end",
            timer: 1000,
            showConfirmButton: false,
          });
        }
      },
      error: function (jqXHR, textStatus, err) {
        console.error("AJAX error:", textStatus, err);
        Swal.fire({
          title: "Connection Error",
          text: "Please check your connection and try again.",
          icon: "error",
          toast: true,
          position: "top-end",
          timer: 1000,
          showConfirmButton: false,
        });
      },
      complete: function () {
        $form.data("isSubmitted", false);
        $btn.prop("disabled", false).html("Delete Department");
      },
    });
  });
  
// Unit Sections =======================================================================
  $(document).on("submit", "#unitsection-form", function (e) { 
      e.preventDefault();
      const $form = $(this);
      if ($form.data("isSubmitted")) return;
      $form.data("isSubmitted", true);
      
      const formData = new FormData(this);
      const $btn = $form.find("button[type='submit']");
      $btn.prop("disabled", true);
      $btn.html('<i class="fas fa-spinner fa-spin me-1"></i> Processing...');
      
      $.ajax({
          url: base_url + "authentication/action.php?action=unitsection_form",
          type: "POST",
          data: formData,
          processData: false,
          contentType: false,
          dataType: "json",
          success: function (response) {
              if (response.status === 1) {
                  Swal.fire({
                      title: "Success!",
                      text: response.message,
                      icon: "success",
                      toast: true,
                      position: "top-end",
                      timer: 1000,
                      showConfirmButton: false,
                  }).then(() => {
                      location.reload();
                  });
              } else {
                  Swal.fire({
                      title: "Error",
                      text: response.message,
                      icon: "error",
                      toast: true,
                      position: "top-end",
                      timer: 1000,
                      showConfirmButton: false,
                  });
              }
          },
          error: function (jqXHR, textStatus, err) {
              console.error("AJAX error:", textStatus, err);
              Swal.fire({
                  title: "Connection Error",
                  text: "Please check your connection and try again.",
                  icon: "error",
                  toast: true,
                  position: "top-end",
                  timer: 1000,
                  showConfirmButton: false,
              });
          },
          complete: function () {
              $form.data("isSubmitted", false);
              $btn.prop("disabled", false).html('Create Unit/Section');
          }
      });
  });
  $(document).on("submit", "#edit-unitsection", function (e) {
    e.preventDefault();
    const $form = $(this);
    if ($form.data("isSubmitted")) return;
    $form.data("isSubmitted", true);

    const formData = new FormData(this);
    const $btn = $form.find("button[type='submit']");
    $btn.prop("disabled", true);
    $btn.html('<i class="fas fa-spinner fa-spin me-1"></i> Processing...');

    $.ajax({
      url: base_url + "authentication/action.php?action=edit_unitsection",
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      dataType: "json",
      success: function (response) {
        if (response.status === 1) {
          Swal.fire({
            title: "Success!",
            text: response.message,
            icon: "success",
            toast: true,
            position: "top-end",
            timer: 1000,
            showConfirmButton: false,
          }).then(() => {
            location.reload();
          });
        } else {
          Swal.fire({
            title: "Error",
            text: response.message,
            icon: "error",
            toast: true,
            position: "top-end",
            timer: 1000,
            showConfirmButton: false,
          });
        }
      },
      error: function (jqXHR, textStatus, err) {
        console.error("AJAX error:", textStatus, err);
        Swal.fire({
          title: "Connection Error",
          text: "Please check your connection and try again.",
          icon: "error",
          toast: true,
          position: "top-end",
          timer: 1000,
          showConfirmButton: false,
        });
      },
      complete: function () {
        $form.data("isSubmitted", false);
        $btn.prop("disabled", false).html("Edit Unit/Section");
      },
    });
  });
  $(document).on("submit", "#unitsection-delete-form", function (e) {
    e.preventDefault();
    const $form = $(this);
    if ($form.data("isSubmitted")) return;
    $form.data("isSubmitted", true);

    const formData = new FormData(this);
    const $btn = $form.find("button[type='submit']");
    $btn.prop("disabled", true);
    $btn.html('<i class="fas fa-spinner fa-spin me-1"></i> Processing...');

    $.ajax({
      url: base_url + "authentication/action.php?action=unitsection_delete_form",
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      dataType: "json",
      success: function (response) {
        if (response.status === 1) {
          Swal.fire({
            title: "Success!",
            text: response.message,
            icon: "success",
            toast: true,
            position: "top-end",
            timer: 1000,
            showConfirmButton: false,
          }).then(() => {
            location.reload();
          });
        } else {
          Swal.fire({
            title: "Error",
            text: response.message,
            icon: "error",
            toast: true,
            position: "top-end",
            timer: 1000,
            showConfirmButton: false,
          });
        }
      },
      error: function (jqXHR, textStatus, err) {
        console.error("AJAX error:", textStatus, err);
        Swal.fire({
          title: "Connection Error",
          text: "Please check your connection and try again.",
          icon: "error",
          toast: true,
          position: "top-end",
          timer: 1000,
          showConfirmButton: false,
        });
      },
      complete: function () {
        $form.data("isSubmitted", false);
        $btn.prop("disabled", false).html("Delete Unit/Section");
      },
    });
  });

// JOB TITLE ==============================================================================
  $(document).on("submit", "#update-jobInfo", function (e) { 
      e.preventDefault();
      const $form = $(this);
      if ($form.data("isSubmitted")) return;
      $form.data("isSubmitted", true);
      
      const formData = new FormData(this);
      const $btn = $form.find("button[type='submit']");
      $btn.prop("disabled", true);
      $btn.html('<i class="fas fa-spinner fa-spin me-1"></i> Processing...');
      
      $.ajax({
          url: base_url + "authentication/action.php?action=update_jobInfo",
          type: "POST",
          data: formData,
          processData: false,
          contentType: false,
          dataType: "json",
          success: function (response) {
              if (response.status === 1) {
                  Swal.fire({
                      title: "Success!",
                      text: response.message,
                      icon: "success",
                      toast: true,
                      position: "top-end",
                      timer: 1000,
                      showConfirmButton: false,
                  }).then(() => {
                      location.reload();
                  });
              } else {
                  Swal.fire({
                      title: "Error",
                      text: response.message,
                      icon: "error",
                      toast: true,
                      position: "top-end",
                      timer: 1000,
                      showConfirmButton: false,
                  });
              }
          },
          error: function (jqXHR, textStatus, err) {
              console.error("AJAX error:", textStatus, err);
              Swal.fire({
                  title: "Connection Error",
                  text: "Please check your connection and try again.",
                  icon: "error",
                  toast: true,
                  position: "top-end",
                  timer: 1000,
                  showConfirmButton: false,
              });
          },
          complete: function () {
              $form.data("isSubmitted", false);
              $btn.prop("disabled", false).html('Edit job title');
          }
      });
  });
  $(document).on("submit", "#jobtitle-delete-form", function (e) { 
      e.preventDefault();
      const $form = $(this);
      if ($form.data("isSubmitted")) return;
      $form.data("isSubmitted", true);
      
      const formData = new FormData(this);
      const $btn = $form.find("button[type='submit']");
      $btn.prop("disabled", true);
      $btn.html('<i class="fas fa-spinner fa-spin me-1"></i> Processing...');
      
      $.ajax({
          url: base_url + "authentication/action.php?action=jobtitle_delete_form",
          type: "POST",
          data: formData,
          processData: false,
          contentType: false,
          dataType: "json",
          success: function (response) {
              if (response.status === 1) {
                  Swal.fire({
                      title: "Success!",
                      text: response.message,
                      icon: "success",
                      toast: true,
                      position: "top-end",
                      timer: 1000,
                      showConfirmButton: false,
                  }).then(() => {
                      location.reload();
                  });
              } else {
                  Swal.fire({
                      title: "Error",
                      text: response.message,
                      icon: "error",
                      toast: true,
                      position: "top-end",
                      timer: 1000,
                      showConfirmButton: false,
                  });
              }
          },
          error: function (jqXHR, textStatus, err) {
              console.error("AJAX error:", textStatus, err);
              Swal.fire({
                  title: "Connection Error",
                  text: "Please check your connection and try again.",
                  icon: "error",
                  toast: true,
                  position: "top-end",
                  timer: 1000,
                  showConfirmButton: false,
              });
          },
          complete: function () {
              $form.data("isSubmitted", false);
              $btn.prop("disabled", false).html('Delete Job Title');
          }
      });
  });
  $(document).on("submit", "#jobtitle-form", function (e) { 
      e.preventDefault();
      const $form = $(this);
      if ($form.data("isSubmitted")) return;
      $form.data("isSubmitted", true);
      
      const formData = new FormData(this);
      const $btn = $form.find("button[type='submit']");
      $btn.prop("disabled", true);
      $btn.html('<i class="fas fa-spinner fa-spin me-1"></i> Processing...');
      
      $.ajax({
          url: base_url + "authentication/action.php?action=jobtitle_form",
          type: "POST",
          data: formData,
          processData: false,
          contentType: false,
          dataType: "json",
          success: function (response) {
              if (response.status === 1) {
                  Swal.fire({
                      title: "Success!",
                      text: response.message,
                      icon: "success",
                      toast: true,
                      position: "top-end",
                      timer: 1000,
                      showConfirmButton: false,
                  }).then(() => {
                      location.reload();
                  });
              } else {
                  Swal.fire({
                      title: "Error",
                      text: response.message,
                      icon: "error",
                      toast: true,
                      position: "top-end",
                      timer: 1000,
                      showConfirmButton: false,
                  });
              }
          },
          error: function (jqXHR, textStatus, err) {
              console.error("AJAX error:", textStatus, err);
              Swal.fire({
                  title: "Connection Error",
                  text: "Please check your connection and try again.",
                  icon: "error",
                  toast: true,
                  position: "top-end",
                  timer: 1000,
                  showConfirmButton: false,
              });
          },
          complete: function () {
              $form.data("isSubmitted", false);
              $btn.prop("disabled", false).html('Create Job Title');
          }
      });
  });

// ACCOUNT MANAGEMENT =====================================================================
  $(document).on("submit", "#validation-form", function (e) {
    e.preventDefault();
    const $form = $(this);
    if ($form.data("isSubmitted")) return;
    $form.data("isSubmitted", true);

    // Validate passwords match
    const password = $form.find('[name="password"]').val();
    const cpassword = $form.find('[name="cpassword"]').val();

    if (password !== cpassword) {
      Swal.fire({
        title: "Error",
        text: "Passwords do not match!",
        icon: "error",
        toast: true,
        position: "top-end",
        timer: 3000,
        showConfirmButton: false,
      });
      $form.data("isSubmitted", false);
      return;
    }

    const formData = new FormData(this);
    const $btn = $form.find("button[type='submit']");
    $btn.prop("disabled", true);
    $btn.html('<i class="fas fa-spinner fa-spin me-1"></i> Processing...');

    $.ajax({
      url: base_url + "authentication/action.php?action=validation-form",
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      dataType: "json",
      success: function (response) {
        if (response.status === 1) {
          Swal.fire({
            title: "Success!",
            text: response.message,
            icon: "success",
            toast: true,
            position: "top-end",
            timer: 1000,
            showConfirmButton: false,
          }).then(() => {
            location.reload();
          });
        } else {
          Swal.fire({
            title: "Error",
            text: response.message,
            icon: "error",
            toast: true,
            position: "top-end",
            timer: 1000,
            showConfirmButton: false,
          });
        }
      },
      error: function (jqXHR, textStatus, err) {
        console.error("AJAX error:", textStatus, err);
        Swal.fire({
          title: "Connection Error",
          text: "Please check your connection and try again.",
          icon: "error",
          toast: true,
          position: "top-end",
          timer: 1000,
          showConfirmButton: false,
        });
      },
      complete: function () {
        $form.data("isSubmitted", false);
        $btn.prop("disabled", false).html("Create Account");
      },
    });
  });
  $(document).on("submit", "#register-form", function (e) {
    e.preventDefault();
    const $form = $(this);
    if ($form.data("isSubmitted")) return;
    $form.data("isSubmitted", true);

    // Validate passwords match
    const password = $form.find('[name="password"]').val();
    const cpassword = $form.find('[name="cpassword"]').val();

    if (password !== cpassword) {
      Swal.fire({
        title: "Error",
        text: "Passwords do not match!",
        icon: "error",
        toast: true,
        position: "top-end",
        timer: 3000,
        showConfirmButton: false,
      });
      $form.data("isSubmitted", false);
      return;
    }

    const formData = new FormData(this);
    const $btn = $form.find("button[type='submit']");
    $btn.prop("disabled", true);
    $btn.html('<i class="fas fa-spinner fa-spin me-1"></i> Processing...');

    $.ajax({
      url: base_url + "authentication/action.php?action=register-form",
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      dataType: "json",
      success: function (response) {
        if (response.status === 1) {
          Swal.fire({
            title: "Success!",
            text: response.message,
            icon: "success",
            toast: true,
            position: "top-end",
            timer: 3000,
            showConfirmButton: false,
          }).then(() => {
            window.location.href = "verification.php";
          });
        } else {
          Swal.fire({
            title: "Error",
            text: response.message,
            icon: "error",
            toast: true,
            position: "top-end",
            timer: 3000,
            showConfirmButton: false,
          });
        }
      },
      error: function (jqXHR, textStatus, err) {
        console.error("AJAX error:", textStatus, err);
        Swal.fire({
          title: "Connection Error",
          text: "Please check your connection and try again.",
          icon: "error",
          toast: true,
          position: "top-end",
          timer: 3000,
          showConfirmButton: false,
        });
      },
      complete: function () {
        $form.data("isSubmitted", false);
        $btn.prop("disabled", false).html("Create Account");
      },
    });
  });
  $(document).on("submit", "#verification-form", function (e) {
    e.preventDefault();
    const $form = $(this);
    if ($form.data("isSubmitted")) return;
    $form.data("isSubmitted", true);

    // Validate passwords match
    const password = $form.find('[name="password"]').val();
    const cpassword = $form.find('[name="cpassword"]').val();

    const formData = new FormData(this);
    const $btn = $form.find("button[type='submit']");
    $btn.prop("disabled", true);
    $btn.html('<i class="fas fa-spinner fa-spin me-1"></i> Processing...');

    $.ajax({
      url: base_url + "authentication/action.php?action=verification_form",
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      dataType: "json",
      success: function (response) {
        if (response.status === 1) {
          Swal.fire({
            title: "Success!",
            text: response.message,
            icon: "success",
            toast: true,
            position: "top-end",
            timer: 3000,
            showConfirmButton: false,
          }).then(() => {
            window.location.href = "register.php";
          });
        } else {
          Swal.fire({
            title: "Error",
            text: response.message,
            icon: "error",
            toast: true,
            position: "top-end",
            timer: 3000,
            showConfirmButton: false,
          });
        }
      },
      error: function (jqXHR, textStatus, err) {
        console.error("AJAX error:", textStatus, err);
        Swal.fire({
          title: "Connection Error",
          text: "Please check your connection and try again.",
          icon: "error",
          toast: true,
          position: "top-end",
          timer: 3000,
          showConfirmButton: false,
        });
      },
      complete: function () {
        $form.data("isSubmitted", false);
        $btn.prop("disabled", false).html("Verifiy code");
      },
    });
  });
  $(document).on("change", ".select_status", function () {
    let $form = $(this).closest(".form_select"); // find the form in the same row
    let formData = new FormData($form[0]);

    $.ajax({
      url: base_url + "authentication/action.php?action=select_status",
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      dataType: "json",
      success: function (response) {
        if (response.status === 1) {
          Swal.fire({
            title: "Success!",
            text: response.message,
            icon: "success",
            toast: true,
            position: "top-end",
            timer: 2000,
            showConfirmButton: false,
          }).then(() => {
            location.reload();
          });
        } else {
          Swal.fire({
            title: "Error",
            text: response.message,
            icon: "error",
            toast: true,
            position: "top-end",
            timer: 3000,
            showConfirmButton: false,
          });
        }
      },
    });
  });
  $(document).on("submit", "#approval-form", function (e) {
    e.preventDefault();
    const $form = $(this);
    if ($form.data("isSubmitted")) return;
    $form.data("isSubmitted", true);

    // Validate passwords match
    const password = $form.find('[name="password"]').val();
    const cpassword = $form.find('[name="cpassword"]').val();

    if (password !== cpassword) {
      Swal.fire({
        title: "Error",
        text: "Passwords do not match!",
        icon: "error",
        toast: true,
        position: "top-end",
        timer: 1000,
        showConfirmButton: false,
      });
      $form.data("isSubmitted", false);
      return;
    }

    const formData = new FormData(this);
    const $btn = $form.find("button[type='submit']");
    $btn.prop("disabled", true);
    $btn.html('<i class="fas fa-spinner fa-spin me-1"></i> Processing...');

    $.ajax({
      url: base_url + "authentication/action.php?action=approval-form",
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      dataType: "json",
      success: function (response) {
        if (response.status === 1) {
          Swal.fire({
            title: "Success!",
            text: response.message,
            icon: "success",
            toast: true,
            position: "top-end",
            timer: 1000,
            showConfirmButton: false,
          }).then(() => {
            location.reload();
          });
        } else {
          Swal.fire({
            title: "Error",
            text: response.message,
            icon: "error",
            toast: true,
            position: "top-end",
            timer: 1000,
            showConfirmButton: false,
          });
        }
      },
      error: function (jqXHR, textStatus, err) {
        console.error("AJAX error:", textStatus, err);
        Swal.fire({
          title: "Connection Error",
          text: "Please check your connection and try again.",
          icon: "error",
          toast: true,
          position: "top-end",
          timer: 1000,
          showConfirmButton: false,
        });
      },
      complete: function () {
        $form.data("isSubmitted", false);
        $btn.prop("disabled", false).html("Create Account");
      },
    });
  });
  $(document).on("submit", "#delete-employee-form", function (e) {
    e.preventDefault();
    const $form = $(this);
    if ($form.data("isSubmitted")) return;
    $form.data("isSubmitted", true);

    const formData = new FormData(this);
    const $btn = $form.find("button[type='submit']");
    $btn.prop("disabled", true);
    $btn.html('<i class="fas fa-spinner fa-spin me-1"></i> Processing...');

    $.ajax({
      url: base_url + "authentication/action.php?action=delete_employee_form",
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      dataType: "json",
      success: function (response) {
        if (response.status === 1) {
          Swal.fire({
            title: "Success!",
            text: response.message,
            icon: "success",
            toast: true,
            position: "top-end",
            timer: 1000,
            showConfirmButton: false,
          }).then(() => {
            location.reload();
          });
        } else {
          Swal.fire({
            title: "Error",
            text: response.message,
            icon: "error",
            toast: true,
            position: "top-end",
            timer: 1000,
            showConfirmButton: false,
          });
        }
      },
      error: function (jqXHR, textStatus, err) {
        console.error("AJAX error:", textStatus, err);
        Swal.fire({
          title: "Connection Error",
          text: "Please check your connection and try again.",
          icon: "error",
          toast: true,
          position: "top-end",
          timer: 1000,
          showConfirmButton: false,
        });
      },
      complete: function () {
        $form.data("isSubmitted", false);
        $btn.prop("disabled", false).html("Create Account");
      },
    });
  });
  $(document).on("submit", "#rejection-form", function (e) {
    e.preventDefault();
    const $form = $(this);
    if ($form.data("isSubmitted")) return;
    $form.data("isSubmitted", true);

    // Validate passwords match
    const password = $form.find('[name="password"]').val();
    const cpassword = $form.find('[name="cpassword"]').val();

    if (password !== cpassword) {
      Swal.fire({
        title: "Error",
        text: "Passwords do not match!",
        icon: "error",
        toast: true,
        position: "top-end",
        timer: 1000,
        showConfirmButton: false,
      });
      $form.data("isSubmitted", false);
      return;
    }

    const formData = new FormData(this);
    const $btn = $form.find("button[type='submit']");
    $btn.prop("disabled", true);
    $btn.html('<i class="fas fa-spinner fa-spin me-1"></i> Processing...');

    $.ajax({
      url: base_url + "authentication/action.php?action=rejection-form",
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      dataType: "json",
      success: function (response) {
        if (response.status === 1) {
          Swal.fire({
            title: "Success!",
            text: response.message,
            icon: "success",
            toast: true,
            position: "top-end",
            timer: 1000,
            showConfirmButton: false,
          }).then(() => {
            location.reload();
          });
        } else {
          Swal.fire({
            title: "Error",
            text: response.message,
            icon: "error",
            toast: true,
            position: "top-end",
            timer: 1000,
            showConfirmButton: false,
          });
        }
      },
      error: function (jqXHR, textStatus, err) {
        console.error("AJAX error:", textStatus, err);
        Swal.fire({
          title: "Connection Error",
          text: "Please check your connection and try again.",
          icon: "error",
          toast: true,
          position: "top-end",
          timer: 1000,
          showConfirmButton: false,
        });
      },
      complete: function () {
        $form.data("isSubmitted", false);
        $btn.prop("disabled", false).html("Create Account");
      },
    });
  });

// PROFILE MANAGEMENT ADMIN =============================================================
  $(document).on("submit", "#profile_update", function (e) { 
      e.preventDefault();
      const $form = $(this);
      if ($form.data("isSubmitted")) return;
      $form.data("isSubmitted", true);
      
      // Validate passwords match
      const password = $form.find('[name="password"]').val();
      const cpassword = $form.find('[name="cpassword"]').val();
      
      if (password !== cpassword) {
          Swal.fire({
              title: "Error",
              text: "Passwords do not match!",
              icon: "error",
              toast: true,
              position: "top-end",
              timer: 1000,
              showConfirmButton: false
          });
          $form.data("isSubmitted", false);
          return;
      }
      
      const formData = new FormData(this);
      const $btn = $form.find("button[type='submit']");
      $btn.prop("disabled", true);
      $btn.html('<i class="fas fa-spinner fa-spin me-1"></i> Processing...');
      
      $.ajax({
          url: base_url + "authentication/action.php?action=profile_update",
          type: "POST",
          data: formData,
          processData: false,
          contentType: false,
          dataType: "json",
          success: function (response) {
              if (response.status === 1) {
                  Swal.fire({
                      title: "Success!",
                      text: response.message,
                      icon: "success",
                      toast: true,
                      position: "top-end",
                      timer: 1000,
                      showConfirmButton: false,
                  }).then(() => {
                        location.reload();
                    });
              } else {
                  Swal.fire({
                      title: "Error",
                      text: response.message,
                      icon: "error",
                      toast: true,
                      position: "top-end",
                      timer: 1000,
                      showConfirmButton: false,
                  });
              }
          },
          error: function (jqXHR, textStatus, err) {
              console.error("AJAX error:", textStatus, err);
              Swal.fire({
                  title: "Connection Error",
                  text: "Please check your connection and try again.",
                  icon: "error",
                  toast: true,
                  position: "top-end",
                  timer: 1000,
                  showConfirmButton: false,
              });
          },
          complete: function () {
              $form.data("isSubmitted", false);
              $btn.prop("disabled", false).html('Updated');
          }
      });
  });
  $(document).on("submit", "#employment_update", function (e) {
    e.preventDefault();
    const $form = $(this);
    if ($form.data("isSubmitted")) return;
    $form.data("isSubmitted", true);

    // Validate passwords match
    const password = $form.find('[name="password"]').val();
    const cpassword = $form.find('[name="cpassword"]').val();

    if (password !== cpassword) {
      Swal.fire({
        title: "Error",
        text: "Passwords do not match!",
        icon: "error",
        toast: true,
        position: "top-end",
        timer: 1000,
        showConfirmButton: false,
      });
      $form.data("isSubmitted", false);
      return;
    }

    const formData = new FormData(this);
    const $btn = $form.find("button[type='submit']");
    $btn.prop("disabled", true);
    $btn.html('<i class="fas fa-spinner fa-spin me-1"></i> Processing...');

    $.ajax({
      url: base_url + "authentication/action.php?action=employment_update",
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      dataType: "json",
      success: function (response) {
        if (response.status === 1) {
          Swal.fire({
            title: "Success!",
            text: response.message,
            icon: "success",
            toast: true,
            position: "top-end",
            timer: 1000,
            showConfirmButton: false,
          }).then(() => {
            location.reload();
          });
        } else {
          Swal.fire({
            title: "Error",
            text: response.message,
            icon: "error",
            toast: true,
            position: "top-end",
            timer: 1000,
            showConfirmButton: false,
          });
        }
      },
      error: function (jqXHR, textStatus, err) {
        console.error("AJAX error:", textStatus, err);
        Swal.fire({
          title: "Connection Error",
          text: "Please check your connection and try again.",
          icon: "error",
          toast: true,
          position: "top-end",
          timer: 1000,
          showConfirmButton: false,
        });
      },
      complete: function () {
        $form.data("isSubmitted", false);
        $btn.prop("disabled", false).html("Updated");
      },
    });
  });
  $(document).on("submit", "#family_update", function (e) {
    e.preventDefault();
    const $form = $(this);
    if ($form.data("isSubmitted")) return;
    $form.data("isSubmitted", true);

    const formData = new FormData(this);
    const $btn = $form.find("button[type='submit']");
    $btn.prop("disabled", true);
    $btn.html('<i class="fas fa-spinner fa-spin me-1"></i> Processing...');

    $.ajax({
      url: base_url + "authentication/action.php?action=family_update",
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      dataType: "json",
      success: function (response) {
        if (response.status === 1) {
          Swal.fire({
            title: "Success!",
            text: response.message,
            icon: "success",
            toast: true,
            position: "top-end",
            timer: 1000,
            showConfirmButton: false,
          }).then(() => {
            location.reload();
          });
        } else {
          Swal.fire({
            title: "Error",
            text: response.message,
            icon: "error",
            toast: true,
            position: "top-end",
            timer: 1000,
            showConfirmButton: false,
          });
        }
      },
      error: function (jqXHR, textStatus, err) {
        console.error("AJAX error:", textStatus, err);
        Swal.fire({
          title: "Connection Error",
          text: "Please check your connection and try again.",
          icon: "error",
          toast: true,
          position: "top-end",
          timer: 1000,
          showConfirmButton: false,
        });
      },
      complete: function () {
        $form.data("isSubmitted", false);
        $btn.prop("disabled", false).html("Update");
      },
    });
  });
  $(document).on("submit", "#leave_update", function (e) {
    e.preventDefault();
    const $form = $(this);
    if ($form.data("isSubmitted")) return;
    $form.data("isSubmitted", true);

    const formData = new FormData(this);
    const $btn = $form.find("button[type='submit']");
    $btn.prop("disabled", true);
    $btn.html('<i class="fas fa-spinner fa-spin me-1"></i> Processing...');

    $.ajax({
      url: base_url + "authentication/action.php?action=leave_update",
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      dataType: "json",
      success: function (response) {
        if (response.status === 1) {
          Swal.fire({
            title: "Success!",
            text: response.message,
            icon: "success",
            toast: true,
            position: "top-end",
            timer: 1000,
            showConfirmButton: false,
          }).then(() => {
            location.reload();
          });
        } else {
          Swal.fire({
            title: "Error",
            text: response.message,
            icon: "error",
            toast: true,
            position: "top-end",
            timer: 1000,
            showConfirmButton: false,
          });
        }
      },
      error: function (jqXHR, textStatus, err) {
        console.error("AJAX error:", textStatus, err);
        Swal.fire({
          title: "Connection Error",
          text: "Please check your connection and try again.",
          icon: "error",
          toast: true,
          position: "top-end",
          timer: 1000,
          showConfirmButton: false,
        });
      },
      complete: function () {
        $form.data("isSubmitted", false);
        $btn.prop("disabled", false).html("Updated");
      },
    });
  });
  $(document).on("submit", "#admin_profile_update", function (e) {
    e.preventDefault();
    const $form = $(this);
    if ($form.data("isSubmitted")) return;
    $form.data("isSubmitted", true);

    const formData = new FormData(this);
    const $btn = $form.find("button[type='submit']");
    $btn.prop("disabled", true);
    $btn.html('<i class="fas fa-spinner fa-spin me-1"></i> Processing...');

    $.ajax({
      url: base_url + "authentication/action.php?action=admin_profile_update",
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      dataType: "json",
      success: function (response) {
        if (response.status === 1) {
          Swal.fire({
            title: "Success!",
            text: response.message,
            icon: "success",
            toast: true,
            position: "top-end",
            timer: 1000,
            showConfirmButton: false,
          }).then(() => {
            location.reload();
          });
        } else {
          Swal.fire({
            title: "Error",
            text: response.message,
            icon: "error",
            toast: true,
            position: "top-end",
            timer: 1000,
            showConfirmButton: false,
          });
        }
      },
      error: function (jqXHR, textStatus, err) {
        console.error("AJAX error:", textStatus, err);
        Swal.fire({
          title: "Connection Error",
          text: "Please check your connection and try again.",
          icon: "error",
          toast: true,
          position: "top-end",
          timer: 1000,
          showConfirmButton: false,
        });
      },
      complete: function () {
        $form.data("isSubmitted", false);
        $btn.prop("disabled", false).html("Updated");
      },
    });
  });

// PROFILE MANAGEMENT EMPLOYEES =============================================================
  $(document).on("submit", "#profile_update_employee", function (e) {
    e.preventDefault();
    const $form = $(this);
    if ($form.data("isSubmitted")) return;
    $form.data("isSubmitted", true);

    const formData = new FormData(this);
    const $btn = $form.find("button[type='submit']");
    $btn
      .prop("disabled", true)
      .html('<i class="fas fa-spinner fa-spin me-1"></i> Processing...');

    $.ajax({
      url:
        base_url + "authentication/action.php?action=profile_update_employee",
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      dataType: "json",
      success: function (response) {
        Swal.fire({
          title: response.status ? "Success!" : "Error",
          text: response.message,
          icon: response.status ? "success" : "error",
          toast: true,
          position: "top-end",
          timer: 1200,
          showConfirmButton: false,
        }).then(() => {
            location.reload();
          });
      },
      error: function () {
        Swal.fire({
          title: "Connection Error",
          text: "Please check your connection and try again.",
          icon: "error",
          toast: true,
          position: "top-end",
          timer: 1200,
          showConfirmButton: false,
        });
      },
      complete: function () {
        $form.data("isSubmitted", false);
        $btn.prop("disabled", false).html("Update");
      },
    });
  });
  $(document).on("submit", "#family_update_employee", function (e) {
    e.preventDefault();
    const $form = $(this);
    if ($form.data("isSubmitted")) return;
    $form.data("isSubmitted", true);

    const formData = new FormData(this);
    const $btn = $form.find("button[type='submit']");
    $btn.prop("disabled", true);
    $btn.html('<i class="fas fa-spinner fa-spin me-1"></i> Processing...');

    $.ajax({
      url: base_url + "authentication/action.php?action=family_update_employee",
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      dataType: "json",
      success: function (response) {
        if (response.status === 1) {
          Swal.fire({
            title: "Success!",
            text: response.message,
            icon: "success",
            toast: true,
            position: "top-end",
            timer: 1000,
            showConfirmButton: false,
          }).then(() => {
            location.reload();
          });
        } else {
          Swal.fire({
            title: "Error",
            text: response.message,
            icon: "error",
            toast: true,
            position: "top-end",
            timer: 1000,
            showConfirmButton: false,
          });
        }
      },
      error: function (jqXHR, textStatus, err) {
        console.error("AJAX error:", textStatus, err);
        Swal.fire({
          title: "Connection Error",
          text: "Please check your connection and try again.",
          icon: "error",
          toast: true,
          position: "top-end",
          timer: 1000,
          showConfirmButton: false,
        });
      },
      complete: function () {
        $form.data("isSubmitted", false);
        $btn.prop("disabled", false).html("Update");
      },
    });
  });
  $(document).ready(function () {
    $(document).on("submit", "#educational_update", function (e) {
      e.preventDefault();
      const $form = $(this);
      if ($form.data("isSubmitted")) return;
      $form.data("isSubmitted", true);

      const formData = new FormData(this);
      const $btn = $form.find("button[type='submit']");
      $btn.prop("disabled", true);
      $btn.html('<i class="fas fa-spinner fa-spin me-1"></i> Processing...');

      $.ajax({
        url: base_url + "authentication/action.php?action=educational_update",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        dataType: "json",
        success: function (response) {
          console.log("AJAX Success:", response);
          if (response.status === 1) {
            Swal.fire({
              title: "Success!",
              text: response.message,
              icon: "success",
              toast: true,
              position: "top-end",
              timer: 1000,
              showConfirmButton: false,
            }).then(() => {
              location.reload();
            });
          } else {
            Swal.fire({
              title: "Error",
              text: response.message,
              icon: "error",
              toast: true,
              position: "top-end",
              timer: 1000,
              showConfirmButton: false,
            });
          }
        },
        error: function (jqXHR, textStatus, err) {
          console.error("AJAX error:", textStatus, err);
          console.log("Response text:", jqXHR.responseText);
          Swal.fire({
            title: "Connection Error",
            text: "Please check your connection and try again.",
            icon: "error",
            toast: true,
            position: "top-end",
            timer: 1000,
            showConfirmButton: false,
          });
        },
        complete: function () {
          console.log("AJAX complete");
          $form.data("isSubmitted", false);
          $btn.prop("disabled", false).html("Update");
        },
      });
    });
    $(document).on("submit", "#educational_update_employee", function (e) {
      e.preventDefault();
      const $form = $(this);
      if ($form.data("isSubmitted")) return;
      $form.data("isSubmitted", true);

      const formData = new FormData(this);
      const $btn = $form.find("button[type='submit']");
      $btn.prop("disabled", true);
      $btn.html('<i class="fas fa-spinner fa-spin me-1"></i> Processing...');

      $.ajax({
        url:
          base_url +
          "authentication/action.php?action=educational_update_employee",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        dataType: "json",
        success: function (response) {
          console.log("AJAX Success:", response);
          if (response.status === 1) {
            Swal.fire({
              title: "Success!",
              text: response.message,
              icon: "success",
              toast: true,
              position: "top-end",
              timer: 1000,
              showConfirmButton: false,
            });
          } else {
            Swal.fire({
              title: "Error",
              text: response.message,
              icon: "error",
              toast: true,
              position: "top-end",
              timer: 1000,
              showConfirmButton: false,
            });
          }
        },
        error: function (jqXHR, textStatus, err) {
          console.error("AJAX error:", textStatus, err);
          console.log("Response text:", jqXHR.responseText);
          Swal.fire({
            title: "Connection Error",
            text: "Please check your connection and try again.",
            icon: "error",
            toast: true,
            position: "top-end",
            timer: 1000,
            showConfirmButton: false,
          });
        },
        complete: function () {
          console.log("AJAX complete");
          $form.data("isSubmitted", false);
          $btn.prop("disabled", false).html("Update");
        },
      });
    });
  });

// CHANGE PASSWORD SETTINGS =================================================================================
  $(document).on("submit", "#changePass_form", function (e) {
    e.preventDefault();
    const $form = $(this);
    if ($form.data("isSubmitted")) return;
    $form.data("isSubmitted", true);

    const formData = new FormData(this);
    const $btn = $form.find("button[type='submit']");
    $btn.prop("disabled", true);
    $btn.html('<i class="fas fa-spinner fa-spin me-1"></i> Processing...');

      $.ajax({
          url: base_url + "authentication/action.php?action=changePassword_form",
          type: "POST",
          data: formData,
          processData: false,
          contentType: false,
          dataType: "json",
          success: function (response) {
              if (response.status === 1) {
                  Swal.fire({
                      title: "Success!",
                      text: response.message,
                      icon: "success",
                      toast: true,
                      position: "top-end",
                      timer: 1000,
                      showConfirmButton: false,
                  }).then(() => {
                      location.reload();
                  });
              } else {
                  Swal.fire({
                      title: "Error",
                      text: response.message,
                      icon: "error",
                      toast: true,
                      position: "top-end",
                      timer: 1000,
                      showConfirmButton: false,
                  });
              }
          },
          error: function (jqXHR, textStatus, err) {
              console.error("AJAX error:", textStatus, err);
              Swal.fire({
                  title: "Connection Error",
                  text: "Please check your connection and try again.",
                  icon: "error",
                  toast: true,
                  position: "top-end",
                  timer: 1000,
                  showConfirmButton: false,
              });
          },
          complete: function () {
              $form.data("isSubmitted", false);
              $btn.prop("disabled", false).html('Create Account');
          }
      });
  });

// SCHEDULE TEMPLATE ====================================================================
  $(document).on("submit", "#schedule-template-form", function (e) {
    e.preventDefault();
    const $form = $(this);
    if ($form.data("isSubmitted")) return;
    $form.data("isSubmitted", true);

    const formData = new FormData(this);
    const $btn = $form.find("button[type='submit']");
    $btn.prop("disabled", true);
    $btn.html('<i class="fas fa-spinner fa-spin me-1"></i> Processing...');

    $.ajax({
      url: base_url + "authentication/action.php?action=schedule_template_form",
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      dataType: "json",
      success: function (response) {
        if (response.status === 1) {
          Swal.fire({
            title: "Success!",
            text: response.message,
            icon: "success",
            toast: true,
            position: "top-end",
            timer: 1000,
            showConfirmButton: false,
          }).then(() => {
            $form[0].reset(); // Reset form on success
          });
        } else {
          Swal.fire({
            title: "Error",
            text: response.message,
            icon: "error",
            toast: true,
            position: "top-end",
            timer: 1000,
            showConfirmButton: false,
          });
        }
      },
      error: function (jqXHR, textStatus, err) {
        console.error("AJAX error:", textStatus, err);
        Swal.fire({
          title: "Connection Error",
          text: "Please check your connection and try again.",
          icon: "error",
          toast: true,
          position: "top-end",
          timer: 1000,
          showConfirmButton: false,
        });
      },
      complete: function () {
        $form.data("isSubmitted", false);
        $btn.prop("disabled", false).html("Create Schedule Template");
      },
    });
  });
  $(document).on("submit", "#delete-template-form", function (e) {
    e.preventDefault();
    const $form = $(this);
    if ($form.data("isSubmitted")) return;
    $form.data("isSubmitted", true);

    const formData = new FormData(this);
    const $btn = $form.find("button[type='submit']");
    $btn.prop("disabled", true);
    $btn.html('<i class="fas fa-spinner fa-spin me-1"></i> Processing...');

    $.ajax({
      url: base_url + "authentication/action.php?action=delete_template_form",
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      dataType: "json",
      success: function (response) {
        if (response.status === 1) {
          Swal.fire({
            title: "Success!",
            text: response.message,
            icon: "success",
            toast: true,
            position: "top-end",
            timer: 1000,
            showConfirmButton: false,
          }).then(() => {
            location.reload();
          });
        } else {
          Swal.fire({
            title: "Error",
            text: response.message,
            icon: "error",
            toast: true,
            position: "top-end",
            timer: 1000,
            showConfirmButton: false,
          });
        }
      },
      error: function (jqXHR, textStatus, err) {
        console.error("AJAX error:", textStatus, err);
        Swal.fire({
          title: "Connection Error",
          text: "Please check your connection and try again.",
          icon: "error",
          toast: true,
          position: "top-end",
          timer: 1000,
          showConfirmButton: false,
        });
      },
      complete: function () {
        $form.data("isSubmitted", false);
        $btn.prop("disabled", false).html("Schedule Deleted");
      },
    });
  });
   $(document).on("click", ".editScheduleBtn", function () {
    let id = $(this).data("id");

    // Set template id first
    $("#template_id").val(id);

    // Fetch the data
    $.ajax({
      url: base_url + "authentication/action.php?action=fetch_template",
      type: "POST",
      data: { template_id: id },
      dataType: "json",
      success: function (data) {
        if (data) {
          // Fill modal inputs
          $("[name='scheduleName']").val(data.scheduleName);
          $("[name='schedule_from']").val(data.schedule_from);
          $("[name='schedule_to']").val(data.schedule_to);
          $("[name='shift']").val(data.shift);
          $("[name='day']").val(data.day);
          $("[name='department']").val(data.department);
        }
      },
      error: function () {
        Swal.fire({
          icon: "error",
          title: "Error",
          text: "Unable to load schedule information.",
        });
      },
    });
  });
  $(document).on("submit", "#edit-schedule", function (e) {
    e.preventDefault();

    let formData = new FormData(this);
    let $btn = $(this).find("button[type='submit']");

    $btn
      .prop("disabled", true)
      .html('<i class="fas fa-spinner fa-spin"></i> Updating...');

    $.ajax({
      url: base_url + "authentication/action.php?action=update_template",
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      dataType: "json",
      success: function (response) {
        if (response.status === 1) {
          Swal.fire({
            title: "Success!",
            text: response.message,
            icon: "success",
            toast: true,
            position: "top-end",
            timer: 1000,
            showConfirmButton: false,
          }).then(() => {
            location.reload();
          });
        } else {
          Swal.fire({
            title: "Error",
            text: response.message,
            icon: "error",
            toast: true,
            position: "top-end",
            timer: 1000,
            showConfirmButton: false,
          });
        }
      },
      error: function (jqXHR, textStatus, err) {
        console.error("AJAX error:", textStatus, err);
        Swal.fire({
          title: "Connection Error",
          text: "Please check your connection and try again.",
          icon: "error",
          toast: true,
          position: "top-end",
          timer: 1000,
          showConfirmButton: false,
        });
      },
      complete: function () {
        $form.data("isSubmitted", false);
        $btn.prop("disabled", false).html("Schedule Deleted");
      },
    });
  });
  
// LEAVES =================================================================================
  $(document).on("submit", "#leave-form", function (e) {
    e.preventDefault();
    const $form = $(this);

    // Prevent double submissions
    if ($form.data("isSubmitted")) return;
    $form.data("isSubmitted", true);

    const formData = new FormData(this);
    const $btn = $form.find("button[type='submit']");
    const originalBtnText = $btn.html();

    $btn.prop("disabled", true);
    $btn.html('<i class="fas fa-spinner fa-spin me-1"></i> Processing...');

    $.ajax({
      url: base_url + "authentication/action.php?action=leave_form",
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      dataType: "json",

      success: function (response) {
        // 🔴 NOT ENOUGH CREDITS — highlight input
        if (
          response.status === 0 &&
          response.message.includes("Not enough leave credits")
        ) {
          $("#numberOfDays").addClass("is-invalid");
          $("#daysError").text(response.message);

          $form.data("isSubmitted", false);
          $btn.prop("disabled", false).html(originalBtnText);

          return; // STOP reload
        }

        // 🟢 SUCCESS
        if (response.status === 1) {
          Swal.fire({
            title: "Success!",
            text: response.message,
            icon: "success",
            toast: true,
            position: "top-end",
            timer: 1000,
            showConfirmButton: false,
          }).then(() => {
            location.reload();
          });
        }

        // ❌ OTHER ERRORS
        else {
          Swal.fire({
            title: "Error",
            text: response.message,
            icon: "error",
            toast: true,
            position: "top-end",
            timer: 1000,
            showConfirmButton: false,
          });
        }
      },

      error: function (jqXHR, textStatus, err) {
        console.error("AJAX error:", textStatus, err);
        console.log("Response:", jqXHR.responseText);

        Swal.fire({
          title: "Error",
          text: "An error occurred, please try again!",
          icon: "error",
          toast: true,
          position: "top-end",
          timer: 1000,
          showConfirmButton: false,
        });
      },

      complete: function () {
        $form.data("isSubmitted", false);
        $btn.prop("disabled", false).html(originalBtnText);
      },
    });
  });
  $(document).on("submit", "#cancel-leave-form", function (e) {
    e.preventDefault();
    const $form = $(this);
    if ($form.data("isSubmitted")) return;
    $form.data("isSubmitted", true);

    const formData = new FormData(this);
    const $btn = $form.find("button[type='submit']");
    $btn
      .prop("disabled", true)
      .html('<i class="fas fa-spinner fa-spin me-1"></i> Processing...');

    $.ajax({
      url:
        base_url + "authentication/action.php?action=cancel_leave_form",
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      dataType: "json",
      success: function (response) {
        Swal.fire({
          title: response.status ? "Success!" : "Error",
          text: response.message,
          icon: response.status ? "success" : "error",
          toast: true,
          position: "top-end",
          timer: 1200,
          showConfirmButton: false,
        }).then(() => {
            location.reload();
          });
      },
      error: function () {
        Swal.fire({
          title: "Connection Error",
          text: "Please check your connection and try again.",
          icon: "error",
          toast: true,
          position: "top-end",
          timer: 1200,
          showConfirmButton: false,
        });
      },
      complete: function () {
        $form.data("isSubmitted", false);
        $btn.prop("disabled", false).html("Update");
      },
    });
  });
  $(document).on("submit", "#leave-types-form", function (e) {
    e.preventDefault();
    const $form = $(this);
    if ($form.data("isSubmitted")) return;
    $form.data("isSubmitted", true);

    const formData = new FormData(this);
    const $btn = $form.find("button[type='submit']");
    $btn.prop("disabled", true);
    $btn.html('<i class="fas fa-spinner fa-spin me-1"></i> Processing...');

    $.ajax({
      url: base_url + "authentication/action.php?action=leave_types_form",
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      dataType: "json",
      success: function (response) {
        if (response.status === 1) {
          Swal.fire({
            title: "Success!",
            text: response.message,
            icon: "success",
            toast: true,
            position: "top-end",
            timer: 1000,
            showConfirmButton: false,
          }).then(() => {
             location.reload();
          });
        } else {
          Swal.fire({
            title: "Error",
            text: response.message,
            icon: "error",
            toast: true,
            position: "top-end",
            timer: 1000,
            showConfirmButton: false,
          });
        }
      },
      error: function (jqXHR, textStatus, err) {
        console.error("AJAX error:", textStatus, err);
        Swal.fire({
          title: "Connection Error",
          text: "Please check your connection and try again.",
          icon: "error",
          toast: true,
          position: "top-end",
          timer: 1000,
          showConfirmButton: false,
        });
      },
      complete: function () {
        $form.data("isSubmitted", false);
        $btn.prop("disabled", false).html("Create Leave");
      },
    });
  });
  $(document).on("submit", "#delete-leave_type-form", function (e) {
    e.preventDefault();
    const $form = $(this);
    if ($form.data("isSubmitted")) return;
    $form.data("isSubmitted", true);

    const formData = new FormData(this);
    const $btn = $form.find("button[type='submit']");
    $btn.prop("disabled", true);
    $btn.html('<i class="fas fa-spinner fa-spin me-1"></i> Processing...');

    $.ajax({
      url: base_url + "authentication/action.php?action=delete_leave_type_form",
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      dataType: "json",
      success: function (response) {
        if (response.status === 1) {
          Swal.fire({
            title: "Success!",
            text: response.message,
            icon: "success",
            toast: true,
            position: "top-end",
            timer: 1000,
            showConfirmButton: false,
          }).then(() => {
             location.reload();
          });
        } else {
          Swal.fire({
            title: "Error",
            text: response.message,
            icon: "error",
            toast: true,
            position: "top-end",
            timer: 1000,
            showConfirmButton: false,
          });
        }
      },
      error: function (jqXHR, textStatus, err) {
        console.error("AJAX error:", textStatus, err);
        Swal.fire({
          title: "Connection Error",
          text: "Please check your connection and try again.",
          icon: "error",
          toast: true,
          position: "top-end",
          timer: 1000,
          showConfirmButton: false,
        });
      },
      complete: function () {
        $form.data("isSubmitted", false);
        $btn.prop("disabled", false).html("Create Leave");
      },
    });
  });
  $(document).on("submit", "#edit-leave_type", function (e) {
    e.preventDefault();
    const $form = $(this);
    if ($form.data("isSubmitted")) return;
    $form.data("isSubmitted", true);

    const formData = new FormData(this);
    const $btn = $form.find("button[type='submit']");
    $btn.prop("disabled", true);
    $btn.html('<i class="fas fa-spinner fa-spin me-1"></i> Processing...');

    $.ajax({
      url: base_url + "authentication/action.php?action=edit_leave_type",
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      dataType: "json",
      success: function (response) {
        if (response.status === 1) {
          Swal.fire({
            title: "Success!",
            text: response.message,
            icon: "success",
            toast: true,
            position: "top-end",
            timer: 1000,
            showConfirmButton: false,
          }).then(() => {
             location.reload();
          });
        } else {
          Swal.fire({
            title: "Error",
            text: response.message,
            icon: "error",
            toast: true,
            position: "top-end",
            timer: 1000,
            showConfirmButton: false,
          });
        }
      },
      error: function (jqXHR, textStatus, err) {
        console.error("AJAX error:", textStatus, err);
        Swal.fire({
          title: "Connection Error",
          text: "Please check your connection and try again.",
          icon: "error",
          toast: true,
          position: "top-end",
          timer: 1000,
          showConfirmButton: false,
        });
      },
      complete: function () {
        $form.data("isSubmitted", false);
        $btn.prop("disabled", false).html("Create Leave");
      },
    });
  });
// 201 FILES ===============================================================================
  $(document).on("submit", "#file-form", function (e) {
    e.preventDefault();
    const $form = $(this);

    if ($form.data("isSubmitted")) return;
    $form.data("isSubmitted", true);

    const formData = new FormData(this);
    const $btn = $form.find("button[type='submit']");
    const originalBtnText = $btn.html();

    $btn.prop("disabled", true);
    $btn.html('<i class="fas fa-spinner fa-spin me-1"></i> Processing...');

    $.ajax({
      url: base_url + "authentication/action.php?action=file_form",
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      dataType: "json",
      success: function (response) {
        if (response.status === 1) {
          Swal.fire({
            title: "Success!",
            text: response.message,
            icon: "success",
            toast: true,
            position: "top-end",
            timer: 1000,
            showConfirmButton: false,
          }).then(() => {
            location.reload();
          });
        } else {
          Swal.fire({
            title: "Error",
            text: response.message,
            icon: "error",
            toast: true,
            position: "top-end",
            timer: 1000,
            showConfirmButton: false,
          });
        }
      },
      error: function (jqXHR, textStatus, err) {
        console.error("AJAX error:", textStatus, err);
        console.log("Response:", jqXHR.responseText);

        Swal.fire({
          title: "error",
          text: "Not enough leave credits!... please try again.",
          icon: "error",
          toast: true,
          position: "top-end",
          timer: 1000,
          showConfirmButton: false,
        });
      },
      complete: function () {
        $form.data("isSubmitted", false);
        $btn.prop("disabled", false).html(originalBtnText);
      },
    });
  });
  $(document).on("submit", "#file-delete-form", function (e) {
    e.preventDefault();
    const $form = $(this);

    if ($form.data("isSubmitted")) return;
    $form.data("isSubmitted", true);

    const formData = new FormData(this);
    const $btn = $form.find("button[type='submit']");
    const originalBtnText = $btn.html();

    $btn.prop("disabled", true);
    $btn.html('<i class="fas fa-spinner fa-spin me-1"></i> Processing...');

    $.ajax({
      url: base_url + "authentication/action.php?action=file_delete_form",
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      dataType: "json",
      success: function (response) {
        if (response.status === 1) {
          Swal.fire({
            title: "Success!",
            text: response.message,
            icon: "success",
            toast: true,
            position: "top-end",
            timer: 1000,
            showConfirmButton: false,
          }).then(() => {
            location.reload();
          });
        } else {
          Swal.fire({
            title: "Error",
            text: response.message,
            icon: "error",
            toast: true,
            position: "top-end",
            timer: 1000,
            showConfirmButton: false,
          });
        }
      },
      error: function (jqXHR, textStatus, err) {
        console.error("AJAX error:", textStatus, err);
        console.log("Response:", jqXHR.responseText);

        Swal.fire({
          title: "error",
          text: "Not enough leave credits!... please try again.",
          icon: "error",
          toast: true,
          position: "top-end",
          timer: 1000,
          showConfirmButton: false,
        });
      },
      complete: function () {
        $form.data("isSubmitted", false);
        $btn.prop("disabled", false).html(originalBtnText);
      },
    });
  });
  
// PERSONAL DATA SHEETS =====================================================================
  $(document).on("submit", "#pds-update", function (e) {
    e.preventDefault();
    const $form = $(this);
    if ($form.data("isSubmitted")) return;
    $form.data("isSubmitted", true);

    const formData = new FormData(this);
    const $btn = $form.find("button[type='submit']");
    $btn.prop("disabled", true);
    $btn.html('<i class="fas fa-spinner fa-spin me-1"></i> Processing...');

    $.ajax({
      url: base_url + "authentication/action.php?action=pds_update",
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      dataType: "json",
      success: function (response) {
        if (response.status === 1) {
          Swal.fire({
            title: "Success!",
            text: response.message,
            icon: "success",
            toast: true,
            position: "top-end",
            timer: 3000,
            showConfirmButton: false,
          }).then(() => {
            location.reload();
          });
        } else {
          Swal.fire({
            title: "Error",
            text: response.message,
            icon: "error",
            toast: true,
            position: "top-end",
            timer: 3000,
            showConfirmButton: false,
          });
        }
      },
      error: function (jqXHR, textStatus, err) {
        console.error("AJAX error:", textStatus, err);
        Swal.fire({
          title: "Connection Error",
          text: "Please check your connection and try again.",
          icon: "error",
          toast: true,
          position: "top-end",
          timer: 3000,
          showConfirmButton: false,
        });
      },
      complete: function () {
        $form.data("isSubmitted", false);
        $btn.prop("disabled", false).html("Update");
      },
    });
  });
  

  function showError(message) {
    Swal.fire({
      title: "Failed",
      text: message,
      icon: "error",
      toast: true,
      position: "top-end",
      timer: 3000,
      showConfirmButton: false,
    });
  }
});
