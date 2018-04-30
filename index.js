var http;

http = createRequestObject();

var post = '';
var userLogged = -1;
var username = '';
var usersPics = [];
var userId = 0;
var nbrPictures = 10;
var filter_selected = "";
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
  canDelete = "";
  while (i > length - nbrPictures) {
    canDelete = "";
    var com = '';
    if (usersPics[i]) {
      if (usersPics[i].com.length > 0) {
        k = 0;
        while (usersPics[i].com[k] && k < 6) {
          com = "<p><span class='username'>" + usersPics[i].com[k]["userName"] + ": </span>" + usersPics[i].com[k]["comment"] + "</p>" + com;
          k++;
        }
      }
      if (usersPics[i].canDelete == 1) {
        canDelete = '<img src="img/setProfile.png" class="trashPicture" onclick=setProfilePicture("' + usersPics[i].name +'")><img onclick=deletePicture(' + usersPics[i].id + ') class="trashPicture" src="img/trash.png">';
      }
      if (usersPics[i].com.length > 5)
        showMore = '<p id="toggleComments' + usersPics[i].id +'" onclick="showMoreContent(' + usersPics[i].id + ',' + i + ')" class="showMoreComments"> Afficher tous les commentaires (' + (usersPics[i].com.length - 5) + ')</p>'
      content = content +'<div class="userPost" id="picture_' + usersPics[i].id + '">' + "<p class='pictureUsername' >" + usersPics[i].username + "</p>" + canDelete + '<img  src=' + usersPics[i].name + ' alt="">' + '<div class="interact"> <div class="containLikeBtn"> <img onclick="likedPicture(' + usersPics[i].id + ')"class="likeBtn" src="img/like.png" alt=""> <p class="nbrLikes">'+  usersPics[i].nbrLikes + '</p> </div> <div class="containComment"></div> </div> <div class="commentContain"> <textarea id="comment_pic' + usersPics[i].id + '" class="commentText"> </textarea> <img onclick="sendComment(' + usersPics[i].id + ')" class="iconSend" src="img/send_icon.png"> </div> <div class="commentsList" id="comments_' + usersPics[i].id +'" >' + com + '</div>' + showMore + '</div>';

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
            userId = result.id;
            document.getElementById("profilPicture").style.display = "block";
            if (result.profilPicture == null)
              document.getElementById("profilPicture").src = "img/default_pp.png";
            else
              document.getElementById("profilPicture").src = result.profilPicture;
            document.getElementById("disconnectButton").style.display = "block";
            document.getElementById("subscribeButton").style.display = "none";
            document.getElementById("username").style.display = "block";
            document.getElementById("username").innerHTML = username;
            document.getElementById("takePhotoBtn").style.display = "block";
            document.getElementById("editAccount").style.display = "block";
        }
        else {

        }
        usersPics = JSON.parse(result.files);
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
  var content = document.getElementById("toggleComments" + pictureId).innerHTML;
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

function selectFilter(filterName) {
  if (filter_selected != filterName.id && filter_selected != "")
    document.getElementById(filter_selected).style.boxShadow = "none";
  filter_selected = filterName.id;
  filterName.style.boxShadow = "1px 1px 2px 0px #656565";
  document.getElementById("filterSelected").src = "filters_images/" + filterName.id.split("_")[0] + ".png";
}

function getUserInfo() {
  if (http.readyState == 4) {
    if (http.status == 200) {
      result = JSON.parse(http.responseText);
      document.getElementById("email").value = result.email;
      document.getElementById("accountUsername").value = result.username;
    }
  }
}

function displayEditAccount() {
  document.getElementById("editAccountModal").style.display = "block";
  var post = "username=" + username;
  http.onreadystatechange = getUserInfo;
  http.open("POST", "./getUserInfo.php", true);
  http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  http.send(post);
}

function userModified() {
  if (http.readyState == 4) {
    if (http.status == 200) {
      username = http.responseText.split("=")[1];
      if (!http.responseText.includes("username="))
        document.getElementById("errorEditAccount").innerHTML = http.responseText;
      getInfo();
    }
  }
}

function editAccount() {
  // document.getElementById("editAccountModal").style.display = "block";
  user = document.getElementById("accountUsername").value;
  email = document.getElementById("email").value;
  oldPassword = document.getElementById("oldPassword").value;
  newPassword = document.getElementById("newPassword").value;
  var post = "username=" + user;
  post = post + "&email=" + email;
  post = post + "&oldPassword=" + oldPassword;
  post = post + "&newPassword=" + newPassword;
  post = post + "&actualUsername=" + username;
  http.onreadystatechange = userModified;
  http.open("POST", "./modifyUserInfo.php", true);
  http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  http.send(post);
}

function closeEditModal() {
  document.getElementById("editAccountModal").style.display = "none";
}

function deletePicture(id) {
  var post = "pictureId=" + id;
  http.onreadystatechange = deletePictureResponse;
  http.open("POST", "./deletePicture.php", true);
  http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  http.send(post);
}

function deletePictureResponse() {
  if (http.readyState == 4) {
    if (http.status == 200) {
      getInfo();
    }
  }
}

function setProfilePicture(pictureName) {
  var post = "pictureName=" + pictureName;
  http.onreadystatechange = profilPictureResponse;
  http.open("POST", "./profilPicture.php", true);
  http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  http.send(post);
}

function profilPictureResponse() {
  if (http.readyState == 4) {
    if (http.status == 200) {
      document.getElementById("profilPicture").src = http.responseText;
    }
  }
}
