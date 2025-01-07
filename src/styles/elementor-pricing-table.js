import "./elementor-pricing-table.scss";

jQuery(document).ready(function ($) {
  if (window.innerWidth > 768) return;

  const $slider = $(".pricing-slider");
  const $slides = $slider.find(".slides");
  const $bullets = $slider.find(".bullets");
  // const $slide = $slider.find('.slide');
  //   const totalSlides = $slide.length;
  const totalSlides = 3;

  let currentIndex = 0;

  const $bullet = $bullets.find(".bullet");

  function updateSlider(index) {
    const offset = -index * 100;
    $slides.css("transform", `translateX(${offset}%)`);
    $bullet.removeClass("active");
    $bullet.eq(index).addClass("active");
  }

  // Bullet click event
  $bullet.on("click", function () {
    currentIndex = $(this).data("index");
    updateSlider(currentIndex);
  });

  // Swipe functionality
  let startX;
  $slider.on("mousedown touchstart", function (e) {
    startX = e.pageX || e.originalEvent.touches[0].pageX;
  });

  $slider.on("mouseup touchend", function (e) {
    const endX = e.pageX || e.originalEvent.changedTouches[0].pageX;
    if (startX > endX + 50 && currentIndex < totalSlides - 1) {
      currentIndex++;
    } else if (startX < endX - 50 && currentIndex > 0) {
      currentIndex--;
    }
    updateSlider(currentIndex);
  });
});
