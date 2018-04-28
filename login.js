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
