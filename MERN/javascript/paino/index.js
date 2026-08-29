var painoKeys = document.querySelectorAll(".paino").length;

for (var i = 0; i < painoKeys; i++) {
  document.querySelectorAll(".paino")[i].addEventListener("click", function () {
    var painoKeyName = this.innerHTML;
    playSound(painoKeyName);
    buttonAnimation(painoKeyName);
  });
}

document.addEventListener("keypress", function (e) {
  playSound(e.key);
  buttonAnimation(e.key);
});

function playSound(keyName) {
  switch (keyName) {
    case "s":
      saudio = new Audio("sound/s.mp3");
      saudio.play();
      break;

    case "r":
      raudio = new Audio("sound/r.mp3");
      raudio.play();
      break;

    case "g":
      gaudio = new Audio("sound/g.mp3");
      gaudio.play();
      break;

    case "m":
      maudio = new Audio("sound/m.mp3");
      maudio.play();
      break;

    case "p":
      paudio = new Audio("sound/p.mp3");
      paudio.play();
      break;

    default:
      console.log(painoKeyName);
  }
}

function buttonAnimation(keyName) {
  var activeButton = document.querySelector("." + keyName);

  activeButton.classList.add("pressed");

  setTimeout(function () {
    activeButton.classList.remove("pressed");
  }, 100);
}
