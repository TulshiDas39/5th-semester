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
  
  <div class = "header">
    <div class = "lHeader"></div>
      <div class = "rHeader">
        <button class="btn success " id = "techBtn">Teach &nbsp;&nbsp;&nbsp;|</button>
        <button class="btn success mybtn" id = "learnBtn">Learn</button>
    </div>
  </div>
  <div class = "content"> <p id = "welcomeText">Welcome to Assignment Management System</p> </div><br><br>

  <p id = "tFooter">You can create a group as a Instructor, you can join group as a student also</p>




  <div class="container">
      <!--<h2>Modal Login Example</h2>-->
      <!-- Trigger the modal with a button -->
    <!--  <button type="button" class="btn btn-default btn-lg" id="myBtn">Login</button>-->

      <!-- Modal -->
      <div class="modal fade" id="myModal" role="dialog">
          <div class="modal-dialog">

              <!-- Modal content-->
              <div class="modal-content">
                  <div class="modal-header" style="padding:35px 50px;">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4><span class="glyphicon glyphicon-lock"></span> Course Info</h4>
                  </div>
                  <div class="modal-body" style="padding:40px 50px;">
                      <form role="form">
                          <div class="form-group">
                              <label for="usrname"><span class="glyphicon glyphicon-user"></span> Course Name</label>
                              <input type="text" class="form-control" id="usrname" placeholder="Enter Course name">
                          </div>
                          <div class="form-group">
                              <label for="psw"><span class="glyphicon glyphicon-eye-open"></span> Semister</label>
                              <input type="text" class="form-control" id="psw" placeholder="Enter Semister">
                          </div>
                          <div class="checkbox">
                              <label><input type="checkbox" value="" checked>Remember me</label>
                          </div>
                          <button type="submit" class="btn btn-success btn-block"><span class="glyphicon glyphicon-off"></span> Submit</button>
                      </form>
                  </div>
                  <div class="modal-footer">
                      <button type="submit" class="btn btn-danger btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
                      <p>Not a member? <a href="#">Sign Up</a></p>
                      <p>Forgot <a href="#">Password?</a></p>
                  </div>
              </div>

          </div>
      </div>
  </div>

  <script>
      $(document).ready(function(){
          $("#techBtn").click(function(){
              $("#myModal").modal();
          });
      });
  </script>

</body>  
</html>  