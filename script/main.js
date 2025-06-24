let accountClick = document.getElementById('accImg');
let menuToggle = document.querySelector('.menu');
let body = document.getElementById('body');

accountClick.onclick = (evenT) => {
  evenT.stopPropagation();
  menuToggle.classList.toggle('active');
};

body.onclick = () => {
  if (!menuToggle.contains(evenT.target) && menuToggle.classList.contains('active')) {
    menuToggle.classList.remove('active');
  }
};


let initSLider = () => {
  let productsList = document.querySelector(".slide-wrapper .products-list");
  let slideButtons = document.querySelectorAll(".slide-wrapper .slide-button");
  let sliderScrollbar = document.querySelector(".container .slider-scrollbar");
  let scrollbarThumb = sliderScrollbar.querySelector(".scrollbar-thumb");
  let maxScrollLeft = productsList.scrollWidth - productsList.clientWidth;


  scrollbarThumb.addEventListener("mousedown", (e) => {
    let startX = e.clientX;
    let thumbPosition = scrollbarThumb.offsetLeft;


    let handleMouseMove = (e) => {
      let deltaX = e.clientX - startX;
      let newThumbPosition = thumbPosition + deltaX;
      let maxThumbPosition = sliderScrollbar.getBoundingClientRect().width - scrollbarThumb.offsetWidth;
      let boundedPosition = Math.max(0, Math.min(maxThumbPosition, newThumbPosition));
      let scrollPosition = (boundedPosition / maxThumbPosition) * maxScrollLeft;

      scrollbarThumb.style.left = `${boundedPosition}px`;
      productsList.scrollLeft = scrollPosition;
    }

    let handleMouseUp = () => {
      document.removeEventListener("mousemove", handleMouseMove);
      document.removeEventListener("mouseup", handleMouseUp);
    }


    document.addEventListener("mousemove", handleMouseMove);
    document.addEventListener("mouseup", handleMouseUp);



  });






  slideButtons.forEach(button => {
    button.addEventListener("click", () => {
      let direction = button.id === "slidePrev" ? -1 : 1;
      let scrollAmout = productsList.clientWidth * direction;
      productsList.scrollBy({left: scrollAmout, behavior: "smooth"})
    })
  });


  let handleSlideButtons = () => {
    slideButtons[0].style.display = productsList.scrollLeft <= 0 ? "none" : "block";
    slideButtons[1].style.display = productsList.scrollLeft >= maxScrollLeft ? "none" : "block";
  };


  let updateScrollThumbPosition = () => {
    let scrollPosition = productsList.scrollLeft;
    let thumbPosition = (scrollPosition / maxScrollLeft) * (sliderScrollbar.clientWidth - scrollbarThumb.offsetWidth);
    scrollbarThumb.style.left = `${thumbPosition}px`;
  }

  productsList.addEventListener("scroll", () => {
    handleSlideButtons();
    updateScrollThumbPosition();
  })
}

window.addEventListener("load", initSLider);

















