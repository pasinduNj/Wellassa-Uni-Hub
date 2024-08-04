<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Feedback and Rating</title>

    <title>Feedback</title>
    <style>
      body {
        font-family: Arial, sans-serif;
        background-color: #f0f0f0;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
      }

      .feedback-container {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        max-width: 500px;
        width: 100%;
        box-sizing: border-box;
      }

      .feedback-container h2 {
        text-align: center;
        margin-bottom: 20px;
      }

      .feedback-container label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
      }

      .stars {
        display: flex;
        flex-direction: row-reverse;
        justify-content: center;
      }

      .stars input {
        display: none;
      }

      .stars label {
        font-size: 30px;
        color: #ccc;
        cursor: pointer;
        transition: color 0.2s;
      }

      .stars label:hover,
      .stars label:hover ~ label,
      .stars input:checked ~ label {
        color: #ffcc00;
      }

      textarea {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 16px;
        resize: vertical;
      }

      button {
        background-color: #4caf50;
        color: white;
        border: none;
        padding: 12px 20px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        border-radius: 4px;
        cursor: pointer;
        width: 100%;
      }

      button:hover {
        background-color: #45a049;
      }
    </style>
  </head>
  <body>
    <div class="feedback-container">
      <h2>Feedback</h2>
      <form id="feedbackForm" action="php/submit_feedback.php" method="POST">
        <label for="rating">Rating:</label>
        <div class="stars">
          <input type="radio" name="rating" value="5" id="5" /><label for="5"
            >★</label
          >
          <input type="radio" name="rating" value="4" id="4" /><label for="4"
            >★</label
          >
          <input type="radio" name="rating" value="3" id="3" /><label for="3"
            >★</label
          >
          <input type="radio" name="rating" value="2" id="2" /><label for="2"
            >★</label
          >
          <input type="radio" name="rating" value="1" id="1" /><label for="1"
            >★</label
          >
        </div>
        <label for="feedback">Feedback:</label>
        <textarea id="feedback" name="feedback" required></textarea>
        <button type="submit">Submit</button>
      </form>
    </div>
    <script>
      document
        .getElementById("feedbackForm")
        .addEventListener("submit", function (event) {
          event.preventDefault(); // Prevent the form from submitting normally

          var form = event.target;
          var rating = form.querySelector('input[name="rating"]:checked');
          var feedback = form.querySelector("#feedback").value;

          if (!rating) {
            alert("Please select a rating.");
            return;
          }

          if (!feedback.trim()) {
            alert("Please provide your feedback.");
            return;
          }

          var formData = new FormData(form);

          fetch("submit_feedback.php", {
            method: "POST",
            body: formData,
          })
            .then((response) => response.text())
            .then((data) => {
              alert("Feedback submitted successfully!");
              form.reset(); // Reset the form
            })
            .catch((error) => {
              console.error("Error:", error);
              alert("An error occurred while submitting your feedback.");
            });
        });
    </script>
  </body>
</html>
