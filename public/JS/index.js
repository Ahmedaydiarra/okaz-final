// Caroussel

// set the default active slide to the first one
let slideIndex = 1;
showSlide(slideIndex);

function plusSlides(n){
  clearInterval(myTimer);
  if (n < 0){
    showSlide(slideIndex -= 1);
  } else {
   showSlide(slideIndex += 1); 
  }
  if (n === -1){
    myTimer = setInterval(function(){plusSlides(n + 2)}, 4000);
  } else {
    myTimer = setInterval(function(){plusSlides(n + 1)}, 4000);
  }
}

function currentSlide(n){
  clearInterval(myTimer);
  myTimer = setInterval(function(){plusSlides(n + 1)}, 4000);
  showSlide(slideIndex = n);
}


function showSlide(n) {
  let i;
  const slides = document.getElementsByClassName("slide");
  const dots = document.getElementsByClassName('dot');

  if (n > slides.length) { slideIndex = 1 }
  if (n < 1) { slideIndex = slides.length }

  // hide all slides
  for (i = 0; i < slides.length; i++) {
    slides[i].classList.add('hidden');
  }

  // remove active status from all dots
  for (i = 0; i < dots.length; i++) {
    dots[i].classList.remove('bg-orange');
    dots[i].classList.add('bg-blue');
  }

  // show the active slide
  slides[slideIndex - 1].classList.remove('hidden');

  // highlight the active dot
  dots[slideIndex - 1].classList.remove('bg-blue');
  dots[slideIndex - 1].classList.add('bg-orange');
}

window.addEventListener("load",function() {
  showSlide(slideIndex);
  myTimer = setInterval(function(){plusSlides(1)}, 4000);
})
