const slidesData = {
    slider1: [
        "/assets/image/main/01pyixtjzfd0eibvn3d99o3832.jpg",
        "/assets/image/main/banner-2.jpeg",
        "/assets/image/main/OIP (1).jpg",
        "/assets/image/main/frasco-de-spray-de-perfume-no-banner-do-ceu-nublado_33099-2220.avif",
    ],
    slider2: [
        "/assets/image/category/1bdca5d0dd3ce9c02ee514d9039b07bc.jpg",
        "/assets/image/category/2d1728b12060798c1236ddc0da830393.jpg",
        "/assets/image/category/d47b82ec6b0ad4b045d7de38bf0e9c9b.jpg",
        "/assets/image/category/0077c108e69ea8461cd43f9c40005ceb.jpg",
        "/assets/image/category/34547b7a64a3b8f95b2bd7cdf9f234e4.jpg",
    ],
};

const currentIndexes = {
    slider1: 0,
    slider2: 0,
};

function startSlide(sliderId) {
    const img = document.querySelector(`#${sliderId} .slide-image`);
    img.setAttribute('src', slidesData[sliderId][currentIndexes[sliderId]]);
    autoSlide(sliderId);
}

function nextSlide(sliderId) {
    currentIndexes[sliderId]++;
    if (currentIndexes[sliderId] >= slidesData[sliderId].length) {
        currentIndexes[sliderId] = 0; // Quay lại đầu
    }
    updateSlide(sliderId);
}

function prevSlide(sliderId) {
    currentIndexes[sliderId]--;
    if (currentIndexes[sliderId] < 0) {
        currentIndexes[sliderId] = slidesData[sliderId].length - 1;
    }
    updateSlide(sliderId);
}

function updateSlide(sliderId) {
    const img = document.querySelector(`#${sliderId} .slide-image`);
    img.setAttribute('src', slidesData[sliderId][currentIndexes[sliderId]]);
}

let autoIntervals = {};

function autoSlide(sliderId) {
    clearInterval(autoIntervals[sliderId]);
    autoIntervals[sliderId] = setInterval(() => nextSlide(sliderId), 2000);
}

window.onload = () => {
    startSlide('slider1');
    startSlide('slider2');
};


// ------------------chuyển flash---------------------------
document.addEventListener("DOMContentLoaded", function() {
    function initializeSlider(sliderSelector, buttonLeftSelector, buttonRightSelector) {
        const slider = document.querySelector(sliderSelector);
        
        function scrollRight() {
            slider.scrollBy({
                left: 400,
                behavior: 'smooth'
            });
        }

        function scrollLeft() {
            slider.scrollBy({
                left: -400,
                behavior: 'smooth'
            });
        }

        // Thêm sự kiện click 
        document.querySelector(buttonLeftSelector).addEventListener("click", scrollLeft);
        document.querySelector(buttonRightSelector).addEventListener("click", scrollRight);

        // Xử lý kéo chuột
        let isDown = false;
        let startX;
        let scrollLeftPosition;

        slider.addEventListener("mousedown", (e) => {
            isDown = true;
            startX = e.pageX - slider.offsetLeft;
            scrollLeftPosition = slider.scrollLeft;
        });

        slider.addEventListener("mouseleave", () => {
            isDown = false;
        });

        slider.addEventListener("mouseup", () => {
            isDown = false;
        });

        slider.addEventListener("mousemove", (e) => {
            if (!isDown) return;
            e.preventDefault();
            const x = e.pageX - slider.offsetLeft;
            const walk = (x - startX) * 2; 
            slider.scrollLeft = scrollLeftPosition - walk;
        });
    }

    // Khởi tạo cho Flash Deals
    initializeSlider('.flash_box', '.flash .btn-left', '.flash .btn-right');

    // Khởi tạo cho Categories
    initializeSlider('.slider_box_right', '.box_category_right .btn-left', '.box_category_right .btn-right');
});

