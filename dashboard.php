<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Blog Dashboard</title>
  <!-- Include Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <!-- Include custom CSS -->
  <style>
    body {
      background-color:coral; /* Set background color */
    }
    .container {
      margin-top: 50px; /* Add margin to top */
    }
    .form-control {
      border-radius: 0; /* Remove border-radius */
      background-color:wheat;
    }
    .form-group{
      background-color:salmon ;
    }
    .btn-primary {
      border-radius: 0; /* Remove border-radius for primary buttons */
    }
    .card {
      border-radius: 0; /* Remove border-radius for cards */
    }
    footer{
        background-color: darkslategray;
        height: 50px;
        color:cornsilk;
        font-weight: bold;
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
    <div class="row mt-5">
        <div class="col-md-6">
          <!-- Blog post creation form -->
          <h2>Create New Post</h2>
          <?php
            session_start();
            include('db.php');

            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['username'])) {
                $title = $_POST['title'];
                $content = $_POST['content'];
                $tags = isset($_POST['tags']) ? $_POST['tags'] : null;
                $username = $_SESSION['username'];

                // Insert the post into the database
                $stmt = $conn->prepare("INSERT INTO blog_posts (title, content, tags, username) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("ssss", $title, $content, $tags, $username);
                $stmt->execute();
                header("Location: dashboard.php");
                exit;
            }

            $conn->close();
          ?>
          <form method="post" action="create_post.php">
            <div class="form-group">
              <label for="title">Title:</label>
              <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="form-group">
              <label for="content">Content:</label>
              <textarea class="form-control" id="content" name="content" rows="4" required></textarea>
            </div>
            <div class="form-group">
              <label for="tags">Tags (optional):</label>
              <input type="text" class="form-control" id="tags" name="tags">
            </div>
            <button type="submit" class="btn btn-primary">Create Post</button>
          </form>
        </div>
        <div class="col-md-6">
          <!-- Blog post display section -->
          <h2>View Posts</h2>
          <div class="card">
            <div class="card-body" style="font-family:'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;">
              <?php 
                include('db.php');
                // Fetch all blog posts from the database
                $stmt = $conn->prepare("SELECT * FROM blog_posts");
                $stmt->execute();
                $result = $stmt->get_result();
                
                // Display blog posts
                while ($row = $result->fetch_assoc()) {
                  echo "<h2>" . (isset($row['Title']) ? $row['Title'] : "Untitled") . "</h2>";
                  echo "<p>" . (isset($row['Content']) ? $row['Content'] : "") . "</p>";
                  echo "<p>Tags: " . (isset($row['Tags']) ? $row['Tags'] : "") . "</p>";
                  echo "<p>Author: " . (isset($row['Username']) ? $row['Username'] : "") . "</p>";
                  echo "<hr>";
                  echo "<p background-color: salmon;></p>";
                }
                
                $conn->close();
              ?>
            </div>
          </div>
        </div>
      </div>
      <div class="row mt-3">
        <div class="col-md-12">
          <a href="login.php" class="btn btn-primary"  style="background-color:deeppink;">Back to Login</a>
          <a href="register.php" class="btn btn-secondary" style="background-color:deeppink;">Back to Register</a>
        </div>
      </div>
    </div>
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
  
