<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brickspoint Finance Team | File Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        body {
            background-color: #f8f9fc;
            color: #343a40;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .hero-section {
            background-color: #007bff;
            color: #ffffff;
            padding: 40px 20px;
            text-align: center;
        }

        .upload-box {
            border: 2px dashed #007bff;
            border-radius: 10px;
            padding: 30px;
            text-align: center;
            color: #007bff;
            cursor: pointer;
            margin-bottom: 20px;
        }

        .nav-item a {
            color: #ffffff;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">Brickspoint Finance System</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a href="#" class="nav-link">Dashboard</a></li>
                    <li class="nav-item"><a href="#" class="nav-link">Uploads</a></li>
                    <li class="nav-item"><a href="#" class="nav-link">Audit Logs</a></li>
                    <li class="nav-item">
                        <a href="{{ route('logout') }}" class="nav-link">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="hero-section">
        <h1>Welcome to the Finance File Management System</h1>
        <p>Collaborate seamlessly between Accountants and Auditors</p>
    </div>

    <!-- Main Content -->
    <div class="container my-4">
        <div class="row">
            <!-- Dashboard Cards -->
            <div class="col-md-4 mb-4">
                <div class="card text-center p-3">
                    <h5>Uploaded Files</h5>
                    <h2>120</h2>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card text-center p-3">
                    <h5>Pending Reviews</h5>
                    <h2>8</h2>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card text-center p-3">
                    <h5>Team Members</h5>
                    <h2>5</h2>
                </div>
            </div>
        </div>

        <!-- Upload Section -->
        <div class="upload-box">
            <p>Drag & Drop files here to upload</p>
            <small>or click to browse</small>
        </div>

        <!-- Recent Collaborations -->
        <h4 class="mb-3">Recent Activities</h4>
        <div class="list-group">
            <a href="#" class="list-group-item list-group-item-action">
                <strong>John Doe</strong> uploaded <em>Finance_Report_Q3.pdf</em> 2 hours ago.
            </a>
            <a href="#" class="list-group-item list-group-item-action">
                <strong>Jane Smith</strong> commented on <em>Budget_2024.xlsx</em>: "Please review the calculations."
            </a>
            <a href="#" class="list-group-item list-group-item-action">
                <strong>Auditor Team</strong> completed the audit for <em>Revenue_Statements.pdf</em>.
            </a>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-primary text-white text-center p-3">
        &copy; {{ date('Y') }} Brickspoint Boutique Aparthotel Asokoro - Finance Team System
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
