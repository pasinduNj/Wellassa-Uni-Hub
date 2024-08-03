document.addEventListener("DOMContentLoaded", function () {
  //const userTypeSelect = document.getElementById("userType");
  const userTypeRadios = document.querySelectorAll('input[name="userType"]');
  const serviceProviderFields = document.getElementById(
    "serviceProviderFields"
  );

  function handleUserTypeChange() {
    userTypeRadios.forEach((radio) => {
      if (radio.checked && radio.value === "serviceProvider") {
        serviceProviderFields.style.display = "block";
      } else if (radio.checked) {
        serviceProviderFields.style.display = "none";
      }
    });
  }

  // Initial call to set the correct visibility on page load
  handleUserTypeChange();

  // Add change event listener to all radio buttons
  userTypeRadios.forEach((radio) => {
    radio.addEventListener("change", handleUserTypeChange);
  });

  // const signupForm = document.getElementById("signupForm");
  // signupForm.addEventListener("submit", function (event) {
  //   const password = document.getElementById("password").value;
  //   const confirmPassword = document.getElementById("confirmPassword").value;

  //   const passwordPattern = /^(?=.*\d)(?=.*[A-Z])(?=.*\W)(?!.*\s).{6,}$/;

  //   if (!passwordPattern.test(password)) {
  //     alert(
  //       "Password must:\n" +
  //         "1. Contain at least one digit.\n" +
  //         "2. Contain at least one uppercase letter.\n" +
  //         "3. Contain at least one special character.\n" +
  //         "4. Not contain white spaces.\n" +
  //         "5. Be at least 6 characters long."
  //     );
  //     event.preventDefault();
  //     return;
  //   }

  //   if (password !== confirmPassword) {
  //     event.preventDefault();
  //     alert("Passwords do not match.");
  //     return;
  //   }
  // });

  // const registerForm = document.getElementById("signupForm");
  // registerForm.addEventListener("submit", function (event) {
  //   const firstName = document.getElementById("firstName").value.trim();
  //   const lastName = document.getElementById("lastName").value.trim();
  //   const email = document
  //     .getElementById("email")
  //     .value.trim()
  //     .replace(/\s+/g, "");
  //   const contactNumber = document
  //     .getElementById("contactNumber")
  //     .value.trim()
  //     .replace(/\s+/g, "");

  //   if (
  //     firstName === "" ||
  //     lastName === "" ||
  //     email === "" ||
  //     contactNumber === "" ||
  //     password === "" ||
  //     confirmPassword === ""
  //   ) {
  //     event.preventDefault();
  //     alert("Please fill in all the required fields.");
  //     return;
  //   }

  //   if (!/^\S+@\S+\.\S+$/.test(email)) {
  //     event.preventDefault();
  //     alert("Invalid email format.");
  //     return;
  //   }

  //   if (!/^0\d{9}$/.test(contactNumber)) {
  //     event.preventDefault();
  //     alert("Contact number must be a 10-digit number starting with 0.");
  //     return;
  //   }

  //   // Additional validation for service provider fields
  //   const userType = document.getElementById("userType").value;

  //   if (userType === "serviceProvider") {
  //     const businessName = document.getElementById("businessName").value.trim();
  //     const nicNumber = document
  //       .getElementById("nicNumber")
  //       .value.trim()
  //       .replace(/\s+/g, "");
  //     const whatsappNumber = document
  //       .getElementById("whatsappNumber")
  //       .value.trim()
  //       .replace(/\s+/g, "");
  //     const serviceAddress = document
  //       .getElementById("serviceAddress")
  //       .value.trim();
  //     const serviceType = document.getElementById("serviceType").value;

  //     if (
  //       businessName === "" ||
  //       nicNumber === "" ||
  //       whatsappNumber === "" ||
  //       serviceAddress === "" ||
  //       serviceType === ""
  //     ) {
  //       event.preventDefault();
  //       alert("Please fill in all the service provider fields.");
  //       return;
  //     }

  //     if (!/^\d{9}$|^\d{12}$/.test(nicNumber)) {
  //       event.preventDefault();
  //       alert("NIC number must be either 9 or 12 digits long.");
  //       return;
  //     }

  //     if (!/^0\d{9}$/.test(whatsappNumber)) {
  //       event.preventDefault();
  //       alert("WhatsApp number must be a 10-digit number starting with 0.");
  //       return;
  //     }
  //   }
  // });
});
