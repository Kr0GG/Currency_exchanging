<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login page</title>
    <!-- css -->
<link rel="import" href="styles.css">
</head>

<body>
<form action="log_proc.php" method="POST" class="container-fluid col-lg-9">
    <fieldset class="form-group">
        <a href="index.html" class="navbar-brand">Site for humans!</a> <br>
        <div><a href="reg.php">Needs to Register?</a></div>
        <label>
            <legend>Sign-in</legend>
            <input type='text' name='login' class="form-control"
                   id="exampleInputEmail1"
                   aria-describedby="emailHelp"
                   placeholder="Enter your e-mail"> <small id="emailHelp" class="form-text text-muted">We'll never share
                your email with anyone
                else.</small><br>

            <input type="password" name="password" class="form-control" id="exampleInputPassword"
                   placeholder="Enter your password"> <br>
            <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
            <br>
        </label>
    </fieldset>
</form>
</body>
</html>