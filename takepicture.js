//Handle handleAJAX

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
          console.log(http.responseText);
          document.getElementById('matof').src = http.responseText;

        }
        else
        {
            alert('Pas glop pas glop');
        }
    }
}


//Handle Camera

// Grab elements, create settings, etc.
var video = document.getElementById('video');

// Get access to the camera!
if(navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
    // Not adding `{ audio: true }` since we only want video now
    navigator.mediaDevices.getUserMedia({ video: true }).then(function(stream) {
        video.src = window.URL.createObjectURL(stream);
        video.play();
    });
}

// Elements for taking the snapshot
var canvas = document.getElementById('canvas');
var goku = document.getElementById('goku');
var context = canvas.getContext('2d');

// Trigger photo take
document.getElementById("snap").addEventListener("click", function() {
	context.drawImage(video, 0, 0, 460, 350);
  var image = new Image();
  image.src = canvas.toDataURL("image/png");
  sendPicture(image.src);
});
