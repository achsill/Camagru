var http;

http = createRequestObject();

var post = '';
var userLogged = -1;
var username = '';
var usersPics = [];
var userId;
var nbrPictures = 10;
getInfo();

window.onscroll = function(ev) {
  if ((window.innerHeight + window.scrollY) >= document.body.scrollHeight) {
    nbrPictures+= 10;
    getInfo();
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
    var com = '';
    if (usersPics[i]) {
      if (usersPics[i].com.length > 0) {
        console.log(usersPics[i].com[0].values);
        k = 0;
        while (usersPics[i].com[k]) {
          com = com + "<p>" + usersPics[i].com[k]["comment"] + "</p>";
          // console.log(usersPics[i].com[k]["comment"]);
          k++;
        }
      }
      content = content +'<div class="userPost" id="picture_' + usersPics[i].id + '">' + '<img  src=' + usersPics[i].name + ' alt="">' + '<div class="interact"> <div class="containLikeBtn"> <img onclick="likedPicture(' + usersPics[i].id + ')"class="likeBtn" src="img/like.png" alt=""> <p class="nbrLikes">'+  usersPics[i].nbrOfLike + '</p> </div> <div class="containComment"></div> </div> <div class="commentContain"> <textarea id="comment_pic' + usersPics[i].id + '" class="commentText"> </textarea> <img onclick="sendComment(' + usersPics[i].id + ')" class="iconSend" src="img/send_icon.png"> </div> <div class="commentsList" id="comments_' + usersPics[i].id +'" >' + com + '</div></div>';
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
        if (result.connected != '-1') {
            userLogged = 1;
            username = result.username;
            userId = result.id;
            document.getElementById("disconnectButton").style.display = "block";
            document.getElementById("subscribeButton").style.display = "none";
        }
        usersPics = JSON.parse(result.files);
        console.log(usersPics);
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

function updateLikes() {
  if (http.readyState == 4)
  {
      if (http.status == 200) {
        getInfo();
      }
    }
}

function likedPicture(id) {
  var post = "id=" + id;
  http.onreadystatechange = updateLikes;
  http.open("POST", "./likedPicture.php", true);
  http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  http.send(post);
}

function sendComment(id) {
  var com = document.getElementById("comment_pic" + id).value;
  var post = "commentText=" + com;
  post = post + "&userId=" + userId;
  post = post + "&pictureId=" + id;
  console.log(post);
  http.onreadystatechange = callPhpComment(id, com);
  http.open("POST", "./manageComment.php", true);
  http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  http.send(post);
}

function callPhpComment(id, com) {
  if (http.readyState == 4)
  {
      if (http.status == 200) {
        var sHeader = document.createTextNode(com);

        var spanHeader = document.createElement('p');
        spanHeader.appendChild(sHeader);
        var comList = document.getElementById("comments_" + id);
        comList.appendChild(spanHeader);
      }
    }
}
