import "./elementor-pricing-table.scss";

jQuery(document).ready(function ($) {
  const $slider = $(".pricing-slider");
  const $slides = $(".pricing-slider .slides");
  const $bullets = $(".pricing-slider .bullet");
  let isDragging = false;
  let startX = 0;
  let currentTranslate = 0;
  let prevTranslate = 0;
  let currentIndex = 0;

  function setSliderPosition(translateX) {
    $slides.css("transform", `translateX(${translateX}px)`);
  }

  function goToSlide(index) {
    currentIndex = index;
    const offset = -index * $slider.width();
    setSliderPosition(offset);
    prevTranslate = offset;
    $bullets.removeClass("active");
    $bullets.eq(index).addClass("active");
  }

  $slider.on("mousedown touchstart", function (e) {
    isDragging = true;
    startX =
      e.type === "mousedown" ? e.pageX : e.originalEvent.touches[0].pageX;
    $slides.css("transition", "none"); // Disable smooth transition during drag
  });

  $(document).on("mousemove touchmove", function (e) {
    if (!isDragging) return;

    const currentX =
      e.type === "mousemove" ? e.pageX : e.originalEvent.touches[0].pageX;
    const deltaX = currentX - startX;
    currentTranslate = prevTranslate + deltaX;
    setSliderPosition(currentTranslate);
  });

  $(document).on("mouseup touchend", function () {
    if (!isDragging) return;

    isDragging = false;
    $slides.css("transition", "transform 0.5s ease-in-out"); // Re-enable smooth transition

    // Determine the slide based on drag distance
    const slideWidth = $slider.width();
    const draggedPercentage = currentTranslate / slideWidth;
    const newIndex = Math.round(-draggedPercentage);

    // Prevent out-of-bound indices
    if (newIndex < 0) {
      goToSlide(0);
    } else if (newIndex >= $bullets.length) {
      goToSlide($bullets.length - 1);
    } else {
      goToSlide(newIndex);
    }
  });

  // Optional: Allow manual bullet navigation
  $(".bullet").on("click", function () {
    const index = $(this).data("index");
    goToSlide(index);
  });
});
