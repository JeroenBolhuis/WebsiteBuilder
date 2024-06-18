document.querySelectorAll('.sponsor-carousel').forEach(imageSlider => {
    const slideContainer = imageSlider.querySelector('.slide-container');
    const defaultSlides = slideContainer.querySelectorAll('.slide');
    let allSlides = defaultSlides;

    const prevBtn = imageSlider.querySelector('.prev-btn');
    const nextBtn = imageSlider.querySelector('.next-btn');
    const playPauseBtn = imageSlider.querySelector('.play-pause-btn');

    const sliderTime = 3000;
    let currentSlide;
    let intervalId;
    let isPlaying = false;

    let MAX_SLIDES_PER_ROW;
    let highestSlideIndex;
    let defaultHighestSlideIndex;

    function getMaxSlidesPerRow() {
        MAX_SLIDES_PER_ROW = parseInt(getComputedStyle(document.documentElement).getPropertyValue('--sponsor-slider-amount'));
        highestSlideIndex = allSlides.length - MAX_SLIDES_PER_ROW;
        defaultHighestSlideIndex = defaultSlides.length - MAX_SLIDES_PER_ROW;
    }

    function checkSlidable() {
        if (defaultHighestSlideIndex <= 0) {
            imageSlider.querySelector('.controls').style.display = 'none';
            showSlide(0);

            if (isPlaying) togglePlayPause();
        } else {
            imageSlider.querySelector('.controls').style.display = '';
            setActiveSlides();

            if (!isPlaying) togglePlayPause();
        }
    }

    function appendSlides() {
        const newSlides = [];
        defaultSlides.forEach(slide => {
            const newSlide = slide.cloneNode(true);
            newSlides.push(newSlide);
        });
        slideContainer.append(...newSlides);

        allSlides = [...allSlides, ...newSlides];

        getMaxSlidesPerRow();
    }

    function resetSlides() {
        slideContainer.innerHTML = '';
        slideContainer.append(...defaultSlides);
        
        allSlides = defaultSlides;
        highestSlideIndex = defaultHighestSlideIndex;
    }

    function showSlide(n) {
        currentSlide = n;

        if (n <= 0) {
            prevBtn.style.display = 'none';
            resetSlides();
        } else {
            prevBtn.style.display = '';
        }

        slideContainer.style.transform = `translateX(-${currentSlide * (100 / MAX_SLIDES_PER_ROW)}%)`;

        setActiveSlides();
    }

    function setActiveSlides() {
        allSlides.forEach((slide, index) => {
            if (index >= currentSlide && index < currentSlide + MAX_SLIDES_PER_ROW) {
                slide.setAttribute('tabindex', '0');
                slide.classList.remove('hidden');
            } else {
                slide.setAttribute('tabindex', '-1');
                slide.classList.add('hidden');
            }
        });
    }

    function nextSlide() {
        const nextSlideIndex = currentSlide + 1;

        if (nextSlideIndex > highestSlideIndex) {
            appendSlides();
        }

        showSlide(nextSlideIndex);

        resetInterval();
    }

    function prevSlide() {
        const prevSlideIndex = currentSlide - 1;
        if (prevSlideIndex < 0) {
            showSlide(highestSlideIndex);
        } else {
            showSlide(prevSlideIndex);
        }
        resetInterval();
    }

    function togglePlayPause() {
        if (isPlaying) {
            clearInterval(intervalId);
            playPauseBtn.querySelector('i').classList.remove('fa-pause');
            playPauseBtn.querySelector('i').classList.add('fa-play');
        } else {
            startInterval();
            playPauseBtn.querySelector('i').classList.remove('fa-play');
            playPauseBtn.querySelector('i').classList.add('fa-pause');
        }

        isPlaying = !isPlaying;
    }

    function startInterval() {
        intervalId = setInterval(nextSlide, sliderTime);
    }

    function resetInterval() {
        if (isPlaying) {
            clearInterval(intervalId);
            startInterval();
        }
    }

    prevBtn.addEventListener('click', prevSlide);
    playPauseBtn.addEventListener('click', togglePlayPause);
    nextBtn.addEventListener('click', nextSlide);

    getMaxSlidesPerRow();

    togglePlayPause();
    showSlide(0);

    checkSlidable();

    window.addEventListener('resize', () => {
        getMaxSlidesPerRow();
        checkSlidable();
    });
});