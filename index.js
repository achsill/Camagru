var http;

http = createRequestObject();

post = '';
getInfo();
userLogged = -1;
username = '';
usersPics = [];
nbrPictures = 10;

window.onscroll = function(ev) {
  if ((window.innerHeight + window.scrollY) >= document.body.scrollHeight) {
    nbrPictures+= 10;
    getInfo();
    console.log("Bottom of page");
  }
};

function getInfo() {
  http.onreadystatechange = isUserLogged;
  http.open("POST", "./index.php", true);
  http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  http.send(post);
}

function printPictures() {
  var content = '';
  i = usersPics.length - 1;
  length = usersPics.length - 1;
  while (i > length - nbrPictures) {
    if (usersPics[i]) {
      content = content +'<div class="userPost">' + '<img  src="user_pictures/' + usersPics[i] + '" alt="">' + '<div class="interact"> <div class="containLikeBtn"> <img class="likeBtn" src="img/like.png" alt=""> </div> <div class="containComment"> <p>Show the comments</p> </div> </div> </div>';
    }
    i--;
  }
    document.getElementById('containPost').innerHTML =  content;
}

function isUserLogged() {
  if (http.readyState == 4)
  {
      if (http.status == 200) {
        result = JSON.parse(http.responseText);
        if (http.responseText != '-1') {
            userLogged = 1;
            username = result.username;
            id = result.id;
        }
        for (var file in result.files) {
          if (result.files[file] != '.' && result.files[file] != '..')
            usersPics.push(result.files[file]);
        }
        printPictures();
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

function displayTakePicture() {
  document.getElementById("takePictureModal").style.display = "flex";
}

function closeTakePicture() {
  document.getElementById("takePictureModal").style.display = "none";
  getInfo();
}
