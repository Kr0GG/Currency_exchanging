<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>BootstrapREG</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- css -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- optional theme 1st is  https://bootswatch.com/slate/ -->
    <link href="https://stackpath.bootstrapcdn.com/bootswatch/4.3.1/superhero/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-LS4/wo5Z/8SLpOLHs0IbuPAGOWTx30XSoZJ8o7WKH0UJhRpjXXTpODOjfVnNjeHu" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"
          integrity="sha384-rHyoN1liRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPpp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <!-- js INCLUDES?? -->
</head>
<body>
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <a href="index.html" class="navbar-brand">Site for humans!</a> <br>
        </div>
        <a href="login.php">Needs to Log in?</a>
        <!--      <img class="mb-4" src="https://www.williamdscott.com/media/ToTheTrade-Left-Registration.png" alt="" width="72" height="72"> -->
    </div>
    <form class="container-fluid col-lg-9" method="post" action="reg_proc.php">
        <fieldset class="form-group">
            <legend>Registration</legend>

            <div class="form-group">
                <label for="exampleInputEmail1"><label>Email for example - kroxxx@gmail.com</label>
                </label><input name=email type="email" class="form-control"
                               id="exampleInputEmail1"
                               aria-describedby="emailHelp"
                               placeholder="Enter email">
                <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone
                    else.</small>

                <label for="exampleInputPassword">Password</label>
                <input name="password" type="password" class="form-control" id="exampleInputPassword"
                       placeholder="Password">
                <input class="form-control" id="exampleInputPassword" name="confirm" type="password"
                       placeholder="Confirm Password">

                <label for="exampleSelect1">Ages</label>
                <select class="form-control" id="exampleSelect1">
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                </select>
            </div>
            <div class="form-group">
                <label for="exampleTextarea">Extra text, why we should see you with us:</label>
                <textarea class="form-control" id="exampleTextarea" rows="3"></textarea>
            </div>
            <div class="form-group">
                <label for="exampleInputFile">Your avatar4ik</label>
                <input type="file" class="form-control-file" id="exampleInputFile" aria-describedby="fileHelp">
                <small id="fileHelp" class="form-text text-muted">This is some placeholder block-level help text for the
                    above input. It's a bit lighter and easily wraps to a new line.</small>

                <div class="form-check disabled">
                </div>
            </div>

            <legend>Mark something, please...</legend>
            <div class="form-check">
                <label class="form-check-label">
                    <input class="form-check-input" type="checkbox" value="sendspam" checked="">
                    Please, send me spam :)<br>
                    <input class="form-check-input" type="checkbox" value="remember-me">I agrees with rules of the site.
                </label>
                <button class="btn btn-lg btn-primary btn-block" type="submit">Register</button>
            </div>
        </fieldset>
    </form>
</nav>
</body>
