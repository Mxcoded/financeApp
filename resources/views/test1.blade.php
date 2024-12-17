<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brickspoint Finance | File Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        body {
            background-color: #f4f7fc;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .hero-section {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(to right, #656666, #5f6254);
            color: white;
            text-align: center;
            padding: 20px;
        }
        .hero-title {
            font-size: 2.5rem;
            font-weight: bold;
        }
        .hero-subtitle {
            font-size: 1.25rem;
            margin-top: 10px;
        }
        .btn-primary {
            background-color: #915f22f0;
            border: none;
            padding: 10px 25px;
            font-size: 1.2rem;
            margin-top: 20px;
            transition: background-color 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #004494;
        }
        .features-section {
            padding: 60px 20px;
            background-color: white;
            text-align: center;
        }
        .feature {
            margin: 20px 0;
        }
        .feature h4 {
            font-weight: bold;
            color: #915f22f0;
        }
        footer {
            background-color: #333434;
            color: white;
            text-align: center;
            padding: 15px 0;
        }
    </style>
</head>
<body>
    <!-- Hero Section -->
    <section class="hero-section">
        <div>
            <h1 class="hero-title">Welcome to Brickspoint Finance Team System</h1>
            <p class="hero-subtitle">Efficient File Management and Collaboration for Accountants and Auditors</p>
            <a href="{{ route('login') }}" class="btn btn-primary">Log In</a>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section">
        <div class="container">
            <h2 class="mb-4">Key Features</h2>
            <div class="row">
                <div class="col-md-4 feature">
                    <h4>Secure File Uploads</h4>
                    <p>Upload and store financial documents securely.</p>
                </div>
                <div class="col-md-4 feature">
                    <h4>Team Collaboration</h4>
                    <p>Work seamlessly with your team and auditors.</p>
                </div>
                <div class="col-md-4 feature">
                    <h4>Audit Logs</h4>
                    <p>Track changes and maintain accountability.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        &copy; {{ date('Y') }} Brickspoint Boutique Aparthotel | Finance Management System
    </footer>

    <!-- Bootstrap Script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
