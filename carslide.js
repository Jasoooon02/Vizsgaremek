document.addEventListener("DOMContentLoaded", function () {
    const colorSelect = document.getElementById("color");
    const carSlides = document.querySelectorAll(".car-slide");

    
    colorSelect.addEventListener("change", function () {
        const selectedColor = colorSelect.value;

        
        carSlides.forEach(slide => slide.classList.remove("active"));

        
        const activeSlide = Array.from(carSlides).find(
            slide => slide.getAttribute("data-color") === selectedColor
        );
        
        if (activeSlide) {
            activeSlide.classList.add("active");
        }
    });
});
