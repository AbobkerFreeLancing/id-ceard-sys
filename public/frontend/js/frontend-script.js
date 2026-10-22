document.addEventListener('DOMContentLoaded', function () {
    // Public Channel
    window.Echo.channel('DriversNearby').listen('.RideRequested', (e) => {
        console.log(e);
        // console.log(e.pickup); // { lat, lng, address }
        alert('New ride request received! Ref: ' + e.ref_number);
    });

    // Private Channel Call
    window.Echo.private('Rider.1').listen('.DriverAccepted', (e) => {
        alert('New ride request received! Ref:');
    });
});

// const swiper = new Swiper(".categorySwiper", {
//     slidesPerView: 1,
//     spaceBetween: 20,
//     navigation: {
//         nextEl: ".swiper-button-next",
//         prevEl: ".swiper-button-prev",
//     },
//     breakpoints: {
//         640: {
//             slidesPerView: 2,
//         },
//         768: {
//             slidesPerView: 3,
//         },
//         1024: {
//             slidesPerView: 4,
//         },
//     },
// });
