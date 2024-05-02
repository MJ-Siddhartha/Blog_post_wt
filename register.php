<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Registration</title>
  <!-- Include Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <!-- Include custom CSS -->
  <style>
    body {
      background-color:wheat; /* Set background color */
    }
    .container {
      margin-top: 50px; /* Add margin to top */
    }
    .form-control {
      border-radius: 0; /* Remove border-radius */
    }
    .btn-primary {
      border-radius: 0; /* Remove border-radius for primary buttons */
    }
    footer {
      position: fixed;
      left: 0;
      bottom: 0;
      width: 100%;
      background-color: darkcyan;
      color: lavender;
      padding: 0px;
      text-align: center;
    }
  </style>
</head>
<body>
    <header>
      <nav class="navbar navbar-expand-lg navbar-light" style="background-color:crimson;">
        <a class="navbar-brand" href="#" style="color: Cornsilk; font-weight:bold;">Blog App</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link" href="login.php" style="color:cyan; font-weight:bold;">Login</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="register.php" style="color:cyan; font-weight:bold;">Register</a>
            </li>
          </ul>
        </div>
      </nav>
    </header>
  <div class="container">
    <h2>User Registration</h2>
    <form method="post" action="register.php">
      <div class="form-group">
        <label for="username">Username:</label>
        <input type="text" class="form-control" id="username" name="username" required>
      </div>
      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" class="form-control" id="password" name="password" required>
      </div>
      <button type="submit" class="btn btn-primary">Register</button>
    </form>
  </div>
  <?php
    // register.php

    include('db.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $username = $_POST['username'];
      $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

      $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
      $stmt->bind_param("ss", $username, $password);

      if ($stmt->execute()) {
        echo "User registered successfully";
        header("Location: login.php");
        exit;
      } else {
        echo "Error: " . $stmt->error;
      }

      $stmt->close();
    }

    $conn->close();

  ?>

  <footer>
    <div class="container">
      <p>&copy; 2024 Blog App. All rights reserved.</p>
    </div>
  </footer>
  <!-- Include Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
