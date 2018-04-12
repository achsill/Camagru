var http;

http = createRequestObject();

var post = '';
var userLogged = -1;
var username = '';
var usersPics = [];
var userId = 0;
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
  showMore = "";
  while (i > length - nbrPictures) {
    var com = '';
    if (usersPics[i]) {
      if (usersPics[i].com.length > 0) {
        k = 0;
        while (usersPics[i].com[k] && k < 6) {
          com = "<p><span class='username'>" + usersPics[i].com[k]["userName"] + ": </span>" + usersPics[i].com[k]["comment"] + "</p>" + com;
          k++;
        }
      }
      if (usersPics[i].com.length > 5)
        showMore = '<p id="toggleComments' + usersPics[i].id +'" onclick="showMoreContent(' + usersPics[i].id + ',' + i + ')" class="showMoreComments"> Afficher tous les commentaires (' + (usersPics[i].com.length - 5) + ')</p>'
      content = content +'<div class="userPost" id="picture_' + usersPics[i].id + '">' + '<img  src=' + usersPics[i].name + ' alt="">' + '<div class="interact"> <div class="containLikeBtn"> <img onclick="likedPicture(' + usersPics[i].id + ')"class="likeBtn" src="img/like.png" alt=""> <p class="nbrLikes">'+  usersPics[i].nbrLikes + '</p> </div> <div class="containComment"></div> </div> <div class="commentContain"> <textarea id="comment_pic' + usersPics[i].id + '" class="commentText"> </textarea> <img onclick="sendComment(' + usersPics[i].id + ')" class="iconSend" src="img/send_icon.png"> </div> <div class="commentsList" id="comments_' + usersPics[i].id +'" >' + com + '</div>' + showMore + '</div>';
    }
    showMore = "";
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
            console.log(result.id);
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
  var post = "pictureID=" + id;
  post = post + "&userID=" + userId;
  http.onreadystatechange = updateLikes;
  http.open("POST", "./likedPicture.php", true);
  http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  http.send(post);
}

function sendComment(id) {
  var com = document.getElementById("comment_pic" + id).value;
  var post = "commentText=" + com;
  post = post + "&pictureId=" + id;
  post = post + "&userId=" + userId;
  http.onreadystatechange = callPhpComment(id, com);
  http.open("POST", "./manageComment.php", true);
  http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  http.send(post);
}

function callPhpComment(id, com) {
  if (http.readyState == 4)
  {
      if (http.status == 200) {
        var content = document.getElementById('comments_' + id).innerHTML;
        com = "<p><span class='username'>" + username + ": </span>" + com + "</p>";
        content = com + content;
        document.getElementById('comments_' + id).innerHTML =  content;
      }
    }
}

function getComments(i, limit) {
  k = 0;
  com = "";
  while (usersPics[i].com[k] && k < limit) {
    com = "<p><span class='username'>" + usersPics[i].com[k]["userName"] + ": </span>" + usersPics[i].com[k]["comment"] + "</p>" + com;
    k++;
  }
  return com;
}

function showMoreContent(pictureId, id) {
  // k = 0;
  // com = "";
  // while (usersPics[id].com[k]) {
  //   com = "<p><span class='username'>" + usersPics[id].com[k]["userName"] + ": </span>" + usersPics[id].com[k]["comment"] + "</p>" + com;
  //   k++;
  // }
  var content = document.getElementById("toggleComments" + pictureId).innerHTML;
  console.log(content);
  if (content.includes("Afficher")) {
    com = getComments(id, usersPics[id].com.length + 1);
    document.getElementById("comments_" + pictureId).innerHTML = com;
    document.getElementById("toggleComments" + pictureId).innerHTML = 'Masquer les commentaires';

  }
  else {
    com = getComments(id, 5);
    document.getElementById("comments_" + pictureId).innerHTML = com;
    document.getElementById("toggleComments" + pictureId).innerHTML = 'Afficher tous les commentaires (' + (usersPics[id].com.length - 5) + ')';
  }




}
