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

function gestionClic()
{
    http = createRequestObject();
    var post = "email=" + document.getElementById('email').value
    post = post + "&username=" + document.getElementById('username').value
    post = post + "&password=" + document.getElementById('password').value
    post = post + "&confirmPassword=" + document.getElementById('confirmPassword').value

    http.onreadystatechange = handleAJAXReturn;
    http.open("POST", "./form.php", true);
    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    http.send(post);
}

function handleAJAXReturn()
{
    if (http.readyState == 4)
    {
        if (http.status == 200)
        {
          console.log(http.responseText);
          document.getElementById("errorSignupMsg").innerHTML = http.responseText;
          document.getElementById("errorSignupMsg").style.display = 'block';
        }
        else
        {
            alert('Pas glop pas glop');
        }
    }
}
