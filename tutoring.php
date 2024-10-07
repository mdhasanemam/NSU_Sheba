<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Tutor</title>
    <style>
      body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 20px;
      }

      h1 {
        text-align: center;
        color: #333;
      }

      form {
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        max-width: 600px;
        margin: 20px auto;
        padding: 20px;
      }

      label {
        font-weight: bold;
        margin-bottom: 10px;
        display: block;
      }

      textarea {
        width: 100%;
        border: 1px solid #ccc;
        border-radius: 4px;
        padding: 10px;
        resize: none;
        box-sizing: border-box;
        margin-bottom: 10px;
      }

      input[type="submit"] {
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 4px;
        padding: 10px;
        cursor: pointer;
        font-size: 16px;
        width: 100%;
        box-sizing: border-box;
        transition: background-color 0.3s;
      }

      input[type="submit"]:hover {
        background-color: #0056b3;
      }

      .message {
        margin-top: 20px;
        padding: 10px;
        border-radius: 4px;
        background-color: #e0ffe0;
        color: #333;
      }

      .error {
        background-color: #ffdddd;
      }
    </style>
  </head>
  <body>
    <h1>Become a Tutor Today!</h1>

    <?php
    // Check if there's a message in the query string
    if (isset($_GET['message'])) {
      $message = htmlspecialchars($_GET['message']);
      echo "<div class='message'>$message</div>";
    }
    if (isset($_GET['error'])) {
      $error = htmlspecialchars($_GET['error']);
      echo "<div class='message error'>$error</div>";
    }
    ?>

    <form action="tutor_insert.php" method="post">
      <label for="id">Tutor ID:</label>
      <input
        type="number"
        id="id"
        name="id"
        required
        placeholder="Enter your tutor ID"
      /><br /><br />
      <label for="topics">Interested Teaching Topics:</label>
      <textarea
        id="topics"
        name="topics"
        rows="5"
        placeholder="List the subjects or topics you want to teach"
      ></textarea>
      <input type="submit" value="Submit" />
    </form>
  </body>
</html>
