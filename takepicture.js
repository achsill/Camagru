//Handle handleAJAX

var http; // Notre objet XMLHttpRequest
var listOfPictures = [];
var numberOfPictures = 0;
var limitPicture = 0;
var shift = 0;
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

function sendPicture(image)
{
    http = createRequestObject(image);
    var post = "image=" + image;

    http.onreadystatechange = handleAJAXReturn;
    http.open("POST", "./takepicture.php", true);
    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    http.send(post);
}

function handleAJAXReturn()
{
    if (http.readyState == 4)
    {
        if (http.status == 200)
        {
          listOfPictures.push('<img id="' + listOfPictures.length + '" class="finalPicture" src="' + http.responseText + '" alt="" onclick=selectPicture(' + listOfPictures.length + ')>');
          numberOfPictures = listOfPictures.length - 1;
          limitPicture = numberOfPictures - 5;
          refreshCarousel(numberOfPictures, limitPicture);
        }
        else
        {
            alert('Pas glop pas glop');
        }
    }
}

function selectPicture(id) {
  var img = document.getElementById(id);
  document.getElementById('imageShowed').src = img.src
  document.getElementById('imageShowed').style.display = 'block';
  document.getElementById('close').style.display = 'block';
}

function closeImage() {
  document.getElementById('imageShowed').style.display = 'none';
  document.getElementById('close').style.display = 'none';
}

function prevCarousel() {
  if (shift > 0)
    shift--;
  refreshCarousel(numberOfPictures - shift, limitPicture - shift);
}

function nextCarousel(la) {
  if (shift + 3 < numberOfPictures)
    shift++;
  refreshCarousel(numberOfPictures - shift, limitPicture - shift);
}

function refreshCarousel(i, max) {
  var showedPictures = '';
  while (i > max) {
    if (i == -1)
      break ;
    showedPictures = showedPictures + listOfPictures[i];
    i--;
  }
  var x =document.getElementById("carousel").innerHTML;
  document.getElementById('carousel').innerHTML =  showedPictures;
}

//Handle Camera

// Grab elements, create settings, etc.
var video = document.getElementById('video');

// Get access to the camera!
if(navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
    // Not adding `{ audio: true }` since we only want video now
    navigator.mediaDevices.getUserMedia({ video: true }).then(function(stream) {
      if (video) {
        video.src = window.URL.createObjectURL(stream);
        video.play();
      }
    });
}

// Elements for taking the snapshot
var canvas = document.getElementById('canvas');
var goku = document.getElementById('goku');
if (canvas) {
  var context = canvas.getContext('2d');
}

// Trigger photo take
document.getElementById("snap").addEventListener("click", function() {
	context.drawImage(video, 0, 0, 500, 375);
  var image = new Image();
  image.src = canvas.toDataURL("image/png");
  sendPicture(image.src);
});
