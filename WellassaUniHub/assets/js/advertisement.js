let slideIndex = 0;
let slides = document.getElementsByClassName("mySlides");
let slideContainer = document.querySelector(".slideshow-container");
let timeoutId;

function setupSlides() {
  // Position all slides to the right initially
  for (let i = 0; i < slides.length; i++) {
    slides[i].style.left = "100%";
  }
  // Position the first slide in view
  slides[0].style.left = "0";
}

function showNextSlide() {
  let currentSlide = slides[slideIndex];
  slideIndex = (slideIndex + 1) % slides.length;
  let nextSlide = slides[slideIndex];

  // Position the next slide to the right
  nextSlide.style.left = "100%";

  // Trigger reflow
  nextSlide.offsetHeight;

  // Start the transition
  currentSlide.style.left = "-100%";
  nextSlide.style.left = "0";

  // Set timeout for the next slide
  timeoutId = setTimeout(showNextSlide, 5000);
}

function plusSlides(n) {
  clearTimeout(timeoutId);
  slideIndex = (slideIndex + n + slides.length) % slides.length;
  showNextSlide();
}

// Initialize and start the slideshow
setupSlides();
timeoutId = setTimeout(showNextSlide, 5000);
