<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
          display: flex;
          align-items: center;
          justify-content: center;
          min-height: 100vh;
          background-color: #f8f9fa;
        }
       .login-container {
          width: 350px;
            padding: 30px;
             background-color: #fff;
             border-radius: 10px;
           box-shadow: 0px 0px 15px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Admin Login</h2>
        <form id="loginForm" method="post" action="api/login.php">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
              <div id="login-error" class="mt-3 text-danger text-center" style="display: none;">
                Invalid credentials
               </div>
        </form>
    </div>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
 <script>
       document.getElementById('loginForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the form from submitting normally

         const email = document.getElementById('email').value;
         const password = document.getElementById('password').value;
        const formData = {
            email: email,
            password: password
        };
        fetch('api/login.php',{
             method: 'POST',
           headers: {
            'Content-Type': 'application/json',
            },
        body: JSON.stringify(formData)
     })
       .then(response => {
                if (!response.ok) {
                     throw new Error('Login failed');
                }
             return response.json();
         })
           .then(data => {
               if (data.success) {
                    window.location.href = "admin_dashboard.php"; // Redirect on successful login
              } else {
                 document.getElementById('login-error').style.display = 'block'; // Display error message
              }
        })
        .catch(error => {
               console.error('Error:', error);
                document.getElementById('login-error').style.display = 'block'; // Display error message
            });
      });
</script>
</body>
</html>