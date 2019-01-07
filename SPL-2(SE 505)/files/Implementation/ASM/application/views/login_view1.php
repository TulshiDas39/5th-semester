<!DOCTYPE html>  
<html>  
<head>  
    <title>Login Page</title>  
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href = "<?php echo base_url()?>assets/style.css">
</head>  
<body>  
  
  <div class = "header" <!--style="height: 40px; width:100% " -->> hello</div>
  <div class = "content" <!--style="height: 40px; width:100% " -->> hello</div>

    <?php echo isset($error) ? $error : ''; ?>  
    <form method="post" action="<?php echo site_url('Login/process'); ?>">  
        <table cellpadding="2" cellspacing="2">  
            <tr>  
                <td><th>Username:</th></td>  
                <td><input type="text" name="user"></td>  
            </tr>
            <tr>  
                <td><th>Password:</th></td>  
                <td><input type="password" name="pass"></td>  
            </tr>  
  
            <tr>  
                <td> </td>  
                <td><input type="submit" value="Login"></td>  
            </tr>  
        </table>  
    </form>  
</body>  
</html>  