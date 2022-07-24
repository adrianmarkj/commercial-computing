function checkPassword(){
    let password = document.getElementById("pwd").value;
    let confirmPassword = document.getElementById("cpwd").value;
    console.log(password,confirmPassword);
    let message = document.getElementById("message");

    if(password.length !=0){
        if(password == confirmPassword){
            message.textContent = "Passwords Match"
        }
        else{
            message.textContent = "Passwords don't match";
        }
    }
}