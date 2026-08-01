<?php
    session_start();
    $errors =[ 
        'login' => $_SESSION['login_error'] ?? '',
        'register' => $_SESSION['register_error'] ?? ''
    ];

    $activeForm = $_SESSION['active_form'] ?? 'login';

    session_unset();

    function showError($error) {
        return !empty ($error) ? "<p class='error'>$error</p>" : '';

    }

    function isActiveForm($formName, $activeForm) {
        return $activeForm === $formName ? 'active' : '';
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
    <link rel="stylesheet" href="design.css">
</head>
<body>
    
   <div class="container">
        <div class ="form-box <?= isActiveForm('login', $activeForm) ?>" id="login"> 
                <form action="login-register.php" method="post" >
                    <h2>Login</h2>
                    <?php echo showError($errors['login']); ?>
                    <label>Email address</label>
                    <input type="text" name="Email" placeholder="Email Address"> 
                    <label>Password</label>
                    <input type="text" name="Password" placeholder="Password"> 
                    <p>Don't have an account? <a href="#register" onclick="toggleForm('register'); return false;">Register</a></p>
                    <button type="submit" name="login">Login</button>
                </form>
        </div>
        
        <div class ="form-box <?= isActiveForm('register', $activeForm) ?> "id ="register"> 
                <form action="login-register.php" method="post" >
                    <h2>Register</h2>
                    <?php echo showError($errors['register']); ?>
                    <label>Email address</label>
                    <input type="text" name="Email" placeholder="Email Address"> 
                    <label>Password</label>
                    <input type="text" name="Password" placeholder="Password"> 
                    <label>Confirm password</label>
                    <input type="text" name="Confirm-Password" placeholder="Confirm Password"> 
                    <p>Already have an account? <a href="#login" onclick="toggleForm('login'); return false;">Login</a></p>
                    <button type="submit" name="register">Register</button>
                </form>
        </div>
    </div>

</body>

    <script>
        function toggleForm(formId) {
            document.querySelectorAll('.form-box').forEach(form => {form.classList.remove('active');});
            document.getElementById(formId).classList.add('active');
        }
     </script>
</html>