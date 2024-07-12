document.addEventListener("DOMContentLoaded", function() {
    const userTypeSelect = document.getElementById("userType");
    const serviceProviderFields = document.getElementById("serviceProviderFields");

    userTypeSelect.addEventListener("change", function() {
        if (userTypeSelect.value === "serviceProvider") {
            serviceProviderFields.style.display = "block";
        } else {
            serviceProviderFields.style.display = "none";
        }
    });

    const registerForm = document.getElementById("signupForm");
    registerForm.addEventListener("submit", function(event) {
        const firstName = document.getElementById("firstName").value.trim();
        const lastName = document.getElementById("lastName").value.trim();
        const email = document.getElementById("email").value.trim().replace(/\s+/g, '');
        const contactNumber = document.getElementById("contactNumber").value.trim().replace(/\s+/g, '');
        const password = document.getElementById("password").value;
        const confirmPassword = document.getElementById("confirmPassword").value;
        const userType = document.getElementById("userType").value;

        if (firstName === "" || lastName === "" || email === "" || contactNumber === "" || password === "" || confirmPassword === "") {
            event.preventDefault();
            alert("Please fill in all the required fields.");
            return;
        }

        if (!/^\S+@\S+\.\S+$/.test(email)) {
            event.preventDefault();
            alert("Invalid email format.");
            return;
        }

        if (!/^0\d{9}$/.test(contactNumber)) {
            event.preventDefault();
            alert("Contact number must be a 10-digit number starting with 0.");
            return;
        }

        if (password.length < 6 || /\s/.test(password)) {
            event.preventDefault();
            alert("Password must be at least 6 characters long and cannot contain white spaces.");
            return;
        }

        if (password !== confirmPassword) {
            event.preventDefault();
            alert("Passwords do not match.");
            return;
        }

        if (userType === "serviceProvider") {
            const businessName = document.getElementById("businessName").value.trim();
            const nicNumber = document.getElementById("nicNumber").value.trim().replace(/\s+/g, '');
            const whatsappNumber = document.getElementById("whatsappNumber").value.trim().replace(/\s+/g, '');
            const serviceAddress = document.getElementById("serviceAddress").value.trim();
            const serviceType = document.getElementById("serviceType").value;

            if (businessName === "" || nicNumber === "" || whatsappNumber === "" || serviceAddress === "" || serviceType === "") {
                event.preventDefault();
                alert("Please fill in all the service provider fields.");
                return;
            }

            if (!/^\d{9}$|^\d{12}$/.test(nicNumber)) {
                event.preventDefault();
                alert("NIC number must be either 9 or 12 digits long.");
                return;
            }

            if (!/^0\d{9}$/.test(whatsappNumber)) {
                event.preventDefault();
                alert("WhatsApp number must be a 10-digit number starting with 0.");
                return;
            }
        }
    });
});
