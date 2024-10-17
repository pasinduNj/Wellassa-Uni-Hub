let slideIndex = 0;
let slides;
let dots;
let slideContainer;
let dotContainer;

function initializeSlideshow() {
  slides = document.getElementsByClassName("mySlides");
  slideContainer = document.querySelector(".slideshow-container");
  dotContainer = document.querySelector(".dot-container");

  if (slides.length === 0) {
    console.error("No slides found");
    return;
  }

  // Create dots
  for (let i = 0; i < slides.length; i++) {
    let dot = document.createElement("span");
    dot.className = "dot";
    dot.onclick = function () {
      currentSlide(i + 1);
    };
    dotContainer.appendChild(dot);
  }

  dots = document.getElementsByClassName("dot");

  showSlides();
}

function showSlides() {
  for (let i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
  }
  slideIndex++;
  if (slideIndex > slides.length) {
    slideIndex = 1;
  }
  for (let i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex - 1].style.display = "block";
  dots[slideIndex - 1].className += " active";
  setTimeout(showSlides, 5000); // Change image every 5 seconds
}

function plusSlides(n) {
  showSlideN(slideIndex + n);
}

function currentSlide(n) {
  showSlideN(n);
}

function showSlideN(n) {
  if (n > slides.length) {
    slideIndex = 1;
  }
  if (n < 1) {
    slideIndex = slides.length;
  }
  for (let i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
  }
  for (let i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex - 1].style.display = "block";
  dots[slideIndex - 1].className += " active";
}

// Initialize the slideshow when the DOM is fully loaded
document.addEventListener("DOMContentLoaded", initializeSlideshow);
