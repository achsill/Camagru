var http; // Notre objet XMLHttpRequest

function createRequestObject()
{
    var http;
    if (window.XMLHttpRequest)
    { // Mozilla, Safari, IE7 ...
        http = new XMLHttpRequest();
    }
    else if (window.ActiveXObject)
    { // Internet Explorer 6
        http = new ActiveXObject("Microsoft.XMLHTTP");
    }
    return http;
}

function SignUpForm()
{
    http = createRequestObject();
    var post = "email=" + document.getElementById('email').value
    post = post + "&username=" + document.getElementById('username').value
    post = post + "&password=" + document.getElementById('password').value
    post = post + "&confirmPassword=" + document.getElementById('confirmPassword').value

    http.onreadystatechange = handleAJAXReturn;
    http.open("POST", "./signUpForm.php", true);
    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    http.send(post);
}

function handleAJAXReturn()
{
    if (http.readyState == 4)
    {
        if (http.status == 200)
        {
          if (http.responseText == "Your account has been created, check your email.") {
            document.getElementById("errorSignupMsg").style.display = 'none';
            document.getElementById("okSignupMsg").innerHTML = http.responseText;
            document.getElementById("okSignupMsg").style.display = 'block';
          }
          else {
            document.getElementById("okSignupMsg").style.display = 'none';
            document.getElementById("errorSignupMsg").innerHTML = http.responseText;
            document.getElementById("errorSignupMsg").style.display = 'block';
          }
        }
        else
        {
            alert('Error');
        }
    }
}

function signInReturn() {
  if (http.readyState == 4)
  {
      if (http.status == 200)
      {
        var result = http.responseText
        if (parseInt(result) == 1) {
          window.location.href = "index.html";
          document.getElementById("disconnectButton").style.display = "block";
        }
        else {
          if (parseInt(result) == -1)
            document.getElementById("errorSignupMsg2").innerHTML = "You're account need to be activated before loggin in";
          else
            document.getElementById("errorSignupMsg2").innerHTML = "Error while trying to log";
          document.getElementById("okSignupMsg2").style.display = 'none';
          document.getElementById("errorSignupMsg2").style.display = 'block';
        }
      }
      else {
      }
    }
}

function SignInForm()
{
    http = createRequestObject();
    var post = "email=" + document.getElementById('LoginEmail').value;
    post = post + "&password=" + document.getElementById('LoginPassword').value;

    http.onreadystatechange = signInReturn;
    http.open("POST", "./login.php", true);
    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    http.send(post);
}


function ToggleCard() {
  if (document.getElementById("signUpForm").style.display == 'none') {
    document.getElementById("signUpForm").style.display = 'block';
    document.getElementById("signInForm").style.display = 'none';
  }
  else {
    document.getElementById("signUpForm").style.display = 'none';
    document.getElementById("signInForm").style.display = 'block';
  }
}

function gestionClick() {
  location.href = "index.html";
}

function togglePasswordForget(x) {
  if (x == 1) {
    document.getElementById("signInForm").style.display = 'none';
    document.getElementById("passwordForgot").style.display = 'block';
  }
  else {
    document.getElementById("signInForm").style.display = 'block';
    document.getElementById("passwordForgot").style.display = 'none';
  }
}

function resetPassword() {
  http = createRequestObject();
  var post = "email=" + document.getElementById('ResetLoginEmail').value;
  http.onreadystatechange = resetPasswordReturn;
  http.open("POST", "./passwordForgot.php", true);
  http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  http.send(post);
}

function resetPasswordReturn() {
  if (http.readyState == 4)
  {
      if (http.status == 200)
      {
        document.getElementById("errorResetPwd").style.display = "block";
        document.getElementById("errorResetPwd").innerHTML = http.responseText;
        if (http.responseText == "This email adress does not exist")
          document.getElementById("errorResetPwd").style.color = "red";
        else if (http.responseText == "An email has been sent !")
          document.getElementById("errorResetPwd").style.color = "green";

      }
  }
}

function changePasswordReturn() {
  if (http.readyState == 4)
  {
      if (http.status == 200)
      {

      }
  }
}

function changePassword() {
  http = createRequestObject();
  var post = "email=" + document.getElementById('ResetLoginEmail').value;

  http.onreadystatechange = changePasswordReturn;
  http.open("POST", "./passwordForgot.php", true);
  http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  http.send(post);
}

function setNewPassword() {
  var url_string = window.location.href;
  var url = new URL(url_string);
  var log = url.searchParams.get("log");
  var cle = url.searchParams.get("cle");

  Rpassword = document.getElementById('resetPassword').value;
  RconfirmPassword = document.getElementById('resetConfirmPassword').value;
  http = createRequestObject();
  var post = "log=" + log;
  post = post + "&cle=" + cle;
  post = post + "&resetPassword=" + Rpassword;
  post = post + "&resetConfirmPassword=" + RconfirmPassword;


  http.onreadystatechange = setNewPasswordReturn;
  http.open("POST", "./newResetPassword.php", true);
  http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  http.send(post);
}

function setNewPasswordReturn() {
  if (http.readyState == 4)
  {
      if (http.status == 200)
      {
        if (http.responseText == "password changes") {
          location.href = "index.html";
        }
        else {
          document.getElementById("pwdError").style.display = "block";
          document.getElementById("pwdError").innerHTML = http.responseText;
        }
      }
  }
}
