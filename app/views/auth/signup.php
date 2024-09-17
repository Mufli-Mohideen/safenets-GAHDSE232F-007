<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Department of Examinations - Student Signup</title>
    <link rel="stylesheet" href="/safenets/public/css/signup_styles.css" />
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  </head>
  <body>

<div class="wrapper">
  <img src="/safenets/public/images/logo.png" alt="Logo" style="display: block; margin: 0 auto; width: 150px; height: auto; margin-bottom: 5px;" />
  <div class="title">
  <div id="message" class="alert" style="display: none;"></div>
      Registration Form
  </div>
  <div class="form">
    <form id="studentSignupForm" action="/safenets/public/student/signup" method="POST" onsubmit="return validateForm()">
      <div class="inputfield">
        <label>Select Exam:</label>
        <div class="custom_select">
          <select id="exam" name="exam" onchange="updateIdLabel()" required>
            <option value="" disabled selected>Select an exam</option>
            <option value="1">Grade 5 Scholarship Examination</option>
            <option value="2">G.C.E (O/L) Examination</option>
            <option value="3">G.C.E (A/L) Examination</option>
          </select>
        </div>
      </div>

      <div class="inputfield">
        <label for="id" id="idLabel">NIC:</label>
        <input type="text" id="id" name="id" class="input" required />
      </div>

      <div class="inputfield">
        <label>Full Name:</label>
        <input type="text" name="fullName" class="input" required />
      </div>

      <div class="inputfield">
        <label>Email Address:</label>
        <input type="email" name="email" id="email" class="input" required />
      </div>

      <div class="inputfield">
        <div class="g-recaptcha" data-sitekey="6LdXF0YqAAAAAIdaG3FeBNV8sm1bZmfnzFfCuFye"></div>
      </div>

      <div class="inputfield">
        <input type="submit" value="Register" class="btn">
      </div>
    </form>
  </div>
</div>

<script src="/safenets/public/js/signup_script.js"></script>

</body>
</html>
