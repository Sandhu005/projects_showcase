function randomNumber() {
  var num = Math.floor(Math.random() * 4);

  switch (num) {
    case 0:
      document.querySelector(".green").classList.add("pressed");
      setTimeout(function () {
        document.querySelector(".green").classList.remove("pressed");
      }, 100);
      var audio = new Audio("sounds/green.mp3");
      audio.play();
      break;

    case 1:
      document.querySelector(".red").classList.add("pressed");
      setTimeout(function () {
        document.querySelector(".red").classList.remove("pressed");
      }, 100);
      var audio = new Audio("sounds/red.mp3");
      audio.play();
      break;

    case 2:
      document.querySelector(".blue").classList.add("pressed");
      setTimeout(function () {
        document.querySelector(".blue").classList.remove("pressed");
      }, 100);
      var audio = new Audio("sounds/blue.mp3");
      audio.play();
      break;

    case 3:
      document.querySelector(".yellow").classList.add("pressed");
      setTimeout(function () {
        document.querySelector(".yellow").classList.remove("pressed");
      }, 100);
      var audio = new Audio("sounds/yellow.mp3");
      audio.play();
      break;
  }
}
