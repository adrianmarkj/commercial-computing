<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Login</title>
            <meta name="viewport" content= "width=device-width, initial=scale=1.0">
            <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">
            <link rel="stylesheet" href="styles-login.css">
    </head>
    <body>
      <nav id="navBar" class="navbar-white">
        <a href="Index.html">
        <img src="images/logo.png" class="logo">
        </a>
        <ul class="nav-links">
            <li class="item"><a href="house.html" class="active" >About Us</a></li>
            <li class="item"><a href="listing.html"class="active">Search Page</a></li>
            <li class="item"><a href="#" class="active">Contact Us</a></li>
        </ul>
        <div class="animation start-home"></div>
        <a href="registerTourist.html" class="register-btn">Register Now</a>
        <i class="fa-solid fa-bars" onclick="togglebtn()"></i>
        <a href="login.html" class="login-btn">Login</a>
        <i class="fa-solid fa-bars" onclick="togglebtn()"></i>
    </nav>
      <div class="container">
      <form action="#" method="get"> 
      <div class="form-content"> 
            <div class="reset-form">
            <div class="title"><h1>Password Reset</h1></div>
                <div class="input-boxes">
                   <div class="input-box">
                    <i class="icon fas fa-envelope"></i>
                    <input type="email" name="email" id="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
                       title="Please enter a valid email in example@mail.com format" required>
                      <label for="email">Email</label>
                      
                </div>
                <br>
                   <div class="input box">
                     <input type="submit" value="Send Email">
                   </div>
                   <br>
               <div class="text">Return to <a href="login.html">Login</a></div>
               <br>
           
               </div>
        </div>
   
      </form>

</div>
</div>
                    
</body>
</html>