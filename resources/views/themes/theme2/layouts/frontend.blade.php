<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Theme 2 - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f8ff;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .theme2-header {
            background-color: #2c3e50;
            color: white;
            padding: 20px;
        }
        .theme2-footer {
            background-color: #2c3e50;
            color: white;
            padding: 20px;
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <header class="theme2-header">
        <div class="container">
            <h1>Theme 2 Header</h1>
            <nav>
                <a href="{{ url('/') }}" class="text-white me-3">Home</a>
                <!-- Add more links as needed -->
            </nav>
        </div>
    </header>

    <main class="container my-5">
        @yield('content')
    </main>

    <footer class="theme2-footer">
        <div class="container">
            <p>&copy; {{ date('Y') }} Theme 2 Footer</p>
        </div>
    </footer>
</body>
</html>