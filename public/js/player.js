// this file file won't be read by Babel so you should not use ES6

var player = videojs("video");

var viewLogged = false;

player.on("timeupdate", function() {
  var percentageVideoPlayed = Math.ceil(
    (player.currentTime() / player.duration()) * 100
  );
  if (percentageVideoPlayed > 10 && !viewLogged) {
    axios.put("/videos/" + window.CURRENT_VIDEO);

    viewLogged = true;
  }
});
