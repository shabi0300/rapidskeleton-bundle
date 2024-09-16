document.addEventListener('DOMContentLoaded', function () {
    $('.rs-slider').each(function () {
        $(this).slick({
            slidesToShow: parseInt($(this).attr('slides-mobile')),
            mobileFirst: true,
            infinite: true,
            centerMode: true,
            centerPadding: '50px',
            arrows: true,
            prevArrow: '.rs-prev-arrow',
            nextArrow: '.rs-next-arrow',
            responsive: [
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: parseInt($(this).attr('slides-tablet')),
                        centerPadding: '100px',
                    },
                },
                {
                    breakpoint: 992,
                    settings: {
                        slidesToShow: parseInt($(this).attr('slides-desktop')),
                        centerPadding: '150px',
                    },
                },
            ],
        });
    });
});
