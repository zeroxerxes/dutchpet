document.addEventListener("DOMContentLoaded", function () {
  const sliders = document.querySelectorAll(".image-slider");

  sliders.forEach(slider => {
    const images = slider.querySelectorAll(".slider-image");
    const prevBtn = slider.querySelector(".prev");
    const nextBtn = slider.querySelector(".next");
    let current = 0;

    function showImage(index) {
      images.forEach((img, i) => {
        img.style.display = i === index ? "block" : "none";
      });
    }

    function nextImage() {
      current = (current + 1) % images.length;
      showImage(current);
    }

    function prevImage() {
      current = (current - 1 + images.length) % images.length;
      showImage(current);
    }

    let interval = setInterval(nextImage, 3000);

    nextBtn.addEventListener("click", () => {
      nextImage();
      resetInterval();
    });

    prevBtn.addEventListener("click", () => {
      prevImage();
      resetInterval();
    });

    function resetInterval() {
      clearInterval(interval);
      interval = setInterval(nextImage, 3000);
    }

    showImage(current);
  });
});
