<?php
require_once 'variables.php'; // Include the variables file for API URLs
if(session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION['user'])) {
    ?>
<form action="login.php" method="post">
  <button type="submit">Logout</button>
  <input type="hidden" name="action" value="logout">
</form>
    <?php
    if (isset($_POST['action']) && $_POST['action'] === 'logout') {
        // Handle logout action
        session_unset();
        header('Location: login.php');
        exit;
    }
}
else {
?>
<form action="login.php" method="post" class="login-form">
  <input type="text" name="user" placeholder="Username" required>
  <input type="password" name="password" placeholder="Password" required>
  <button type="submit">Login</button>
  <input type="hidden" name="action" value="login">
</form>
<?php
// Handle login action
  if(isset($_POST['action']) && $_POST['action'] === 'login') {
    $user = $_POST['user'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!$user || !$password) {
        $error = 'User and password are required';
    } else {
      //cURL to api login
      $url = curl_init(authUrl);//api endpoint for authentication
      curl_setopt($url, CURLOPT_RETURNTRANSFER, true);// Return the response as a string
      curl_setopt($url, CURLOPT_POST, true);// Set the request method to POST
      curl_setopt($url, CURLOPT_POSTFIELDS, http_build_query([// Data to be sent in the POST request body
        'user' => $user, 
        'password' => $password
      ]));
      curl_setopt($url, CURLOPT_HTTPHEADER, [//headers for the request
          'Accept: application/json'
      ]);
      $response = curl_exec($url);// Execute the cURL request
      curl_close($url);// Close the cURL session
      if ($response === false) {
          $error = 'Failed to connect to the authentication service.';
          exit;
      }

      // Decode the JSON response
        $authResult = json_decode($response, true);
        echo json_encode($authResult); 
        if (isset($authResult['error'])) {
            $error = $authResult['error'];
        } else {
            $_SESSION['user'] = $authResult['user'];
            $_SESSION['role'] = $authResult['role'];
            $_SESSION['token'] = $authResult['apiKey'];
            header('Location: index.php');
        }
    }
  }
}
?>

