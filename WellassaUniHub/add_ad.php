<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css" />
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cardo" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cinzel" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="assets/css/styles.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <!-- Add these new library imports -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }

        .form-container {
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .form-label {
            font-weight: 600;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .form-group {
            padding-left: 10px;
            padding-right: 10px;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">Admin Dashboard</a>
            <a class="btn btn-primary shadow" role="button" href="./php/logout.php"
                style="height: 35px;padding: 3px 10px;margin: 10px -10px 10px 30px;width: 78px;border-radius: 59px;">Logout</a>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="form-container p-4">
                    <h2 class="text-center mb-4">Add New Advertisement</h2>
                    <?php
                    if (isset($_GET['S'])) {
                        if ($_GET['S'] == 1) {
                            echo '<div class="alert alert-success" role="alert">Advertisement Added Successfully</div>';
                        } else {
                            echo '<div class="alert alert-danger" role="alert">Error Occured Try Again</div>';
                        }
                    }
                    ?>
                    <form action="./php/process_ad.php" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        <div class="form-group">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="image" class="form-label">Upload Image</label>
                            <input type="file" class="form-control-file" id="image" name="image" accept="image/*" required>
                        </div>
                        <div class="form-group">
                            <label for="until_date" class="form-label">Until Date</label>
                            <input type="date" class="form-control" id="until_date" name="until_date" required>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary" style="width: 96%;">Add Advertisement</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <h2 class="text-center mb-4">Registered Users</h2>

                <table class="table table-bordered" id="userTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Contact Number</th>
                            <th>User Type</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="userTableBody">
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <h2 class="text-center mb-4">Payment Details</h2>
                <button class="btn btn-success mb-2" onclick="downloadTableAsPDF('paymentTable')">Download as PDF</button>
                <table class="table table-bordered" id="paymentTable">
                    <thead>
                        <tr>
                            <th>Payment ID</th>
                            <th>User ID</th>

                            <th>Amount</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="paymentTableBody">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <h2 class="text-center mb-4">Product Details</h2>
                <button class="btn btn-success mb-2" onclick="downloadTableAsPDF('productTable')">Download as PDF</button>
                <table class="table table-bordered" id="productTable">
                    <thead>
                        <tr>
                            <th>Product ID</th>
                            <th>Product Name</th>
                            <th>Provider ID</th>
                            <th>Price</th>
                            <th>Availeble Quanty</th>

                        </tr>
                    </thead>
                    <tbody id="productTableBody">
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetch('./php/fetch_users.php')
                .then(response => response.json())
                .then(data => {
                    const userTableBody = document.getElementById('userTableBody');
                    data.forEach(user => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${user.user_id}</td>
                            <td>${user.first_name}</td>
                            <td>${user.last_name}</td>
                            <td>${user.email}</td>
                            <td>${user.contact_number}</td>
                            <td>${user.user_type}</td>
                            <td>${user.status}</td>
                            <td>
                                ${user.status === 'active' ? `<button class="btn btn-danger btn-sm" style="width: 90%;" onclick="disableUser('${user.user_id}')">Disable</button>` : `<button class="btn btn-success btn-sm" onclick="enableUser('${user.user_id}')">Enable</button>`}
                            </td>
                        `;
                        userTableBody.appendChild(row);
                    });
                })
                .catch(error => console.error('Error fetching user data:', error));
        });

        // Fetch payment details
        fetch('./php/fetch_payments.php')
            .then(response => response.json())
            .then(data => {
                const paymentTableBody = document.getElementById('paymentTableBody');
                data.forEach(payment => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                            <td>${payment.payment_id}</td>
                            <td>${payment.customer_id}</td>
                            <td>${payment.price}</td>
                            <td>${payment.date_time}</td>
                            <td>${payment.status}</td>
                        `;
                    paymentTableBody.appendChild(row);
                });
            })
            .catch(error => console.error('Error fetching payment data:', error));

        // Fetch product details
        fetch('./php/fetch_products.php')
            .then(response => response.json())
            .then(data => {
                const productTableBody = document.getElementById('productTableBody');
                data.forEach(product => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                            <td>${product.product_id}</td>
                            <td>${product.name}</td>
                            <td>${product.provider_id}</td>
                            <td>${product.price}</td>
                            <td>${product.quantity}</td>
                        `;
                    productTableBody.appendChild(row);
                });
            })
            .catch(error => console.error('Error fetching product data:', error));



        function downloadTableAsPDF(tableId) {
            // Get the specific table
            const table = document.getElementById(tableId);

            // Create a clone of the table to modify for PDF
            const clonedTable = table.cloneNode(true);

            // Apply some styling to the cloned table for better PDF output
            clonedTable.style.width = '100%';
            clonedTable.style.borderCollapse = 'collapse';
            clonedTable.style.margin = '0';
            clonedTable.style.fontSize = '12px';

            // Create a temporary container
            const temp = document.createElement('div');
            temp.style.position = 'absolute';
            temp.style.left = '-10000px';
            temp.style.top = '-10000px';
            temp.appendChild(clonedTable);
            document.body.appendChild(temp);

            // Use html2canvas to convert the table to an image
            html2canvas(clonedTable, {
                scale: 2, // Increase quality
                logging: false,
                useCORS: true
            }).then(canvas => {
                // Remove temporary element
                document.body.removeChild(temp);

                // Convert canvas to image
                const imgData = canvas.toDataURL('image/jpeg', 1.0);

                // Initialize PDF
                const {
                    jsPDF
                } = window.jspdf;
                const pdf = new jsPDF('p', 'mm', 'a4');

                // Calculate dimensions
                const imgProps = pdf.getImageProperties(imgData);
                const pdfWidth = pdf.internal.pageSize.getWidth();
                const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;

                // Add image to PDF
                pdf.addImage(imgData, 'JPEG', 0, 0, pdfWidth, pdfHeight);

                // Download PDF
                pdf.save('$ {tableId}.pdf');
            }).catch(error => {
                console.error('Error generating PDF:', error);
                alert('Error generating PDF. Please try again.');
            });
        }

        function disableUser(userId) {
            if (confirm('Are you sure you want to disable this user?')) {
                fetch('./php/disable_user.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: `user_id=${userId}`
                    })
                    .then(response => response.text())
                    .then(data => {
                        alert(data);
                        location.reload();
                    })
                    .catch(error => console.error('Error disabling user:', error));
            }
        }

        function enableUser(userId) {
            if (confirm('Are you sure you want to enable this user?')) {
                fetch('./php/enable_user.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: `user_id=${userId}`
                    })
                    .then(response => response.text())
                    .then(data => {
                        alert(data);
                        location.reload();
                    })
                    .catch(error => console.error('Error enabling user:', error));
            }
        }
    </script>
</body>

</html>