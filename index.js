var http;

http = createRequestObject();

post = '';
http.onreadystatechange = isUserLogged;
http.open("POST", "./index.php", true);
http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
http.send(post);
userLogged = -1;
username = '';

function isUserLogged() {
  if (http.readyState == 4)
  {
      if (http.status == 200) {
        if (http.responseText != '-1') {
            userLogged = 1;
            result = JSON.parse(http.responseText);
            username = result.username;
            id = result.id;
            console.log(username + " " + id);
        }
      }
    }
}

function createRequestObject()
{
    var http;
    if (window.XMLHttpRequest)
        http = new XMLHttpRequest();
    else if (window.ActiveXObject)
        http = new ActiveXObject("Microsoft.XMLHTTP");
    return http;
}
