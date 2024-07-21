/* Load more */
document.addEventListener("DOMContentLoaded", function() {
    var toggleButton = document.getElementById('toggle-btn');
    var hiddenTiles = document.querySelectorAll('#tiles-container .tile.hidden');
    var allTiles = document.querySelectorAll('#tiles-container .tile');
    var initiallyVisibleTilesCount = allTiles.length - hiddenTiles.length;

    toggleButton.addEventListener('click', function() {
        var currentlyHiddenTiles = document.querySelectorAll('#tiles-container .tile.hidden');

        if (currentlyHiddenTiles.length > 0) {
            currentlyHiddenTiles.forEach(function(tile) {
                tile.classList.remove('hidden');
            });
            toggleButton.textContent = 'Schowaj treści';
        } else {
            
            for (var i = initiallyVisibleTilesCount; i < allTiles.length; i++) {
                allTiles[i].classList.add('hidden');
            }
            toggleButton.textContent = 'Wczytaj więcej';
        }
    });
});
/* Load more END*/
/* Odliczanie/counter */
    let dataDocelowa1 = new Date("2024-06-12 15:00:00");
    let dataDocelowa2 = new Date("2024-06-01 10:00:00");
    let dataDocelowa3 = new Date("2024-06-15 12:00:00");
    let dataDocelowa4 = new Date("2024-06-13 17:30:00");

    function aktualizujOdliczanie(dataDocelowa, dniId, godzinyId, minutyId, sekundyId) {
        let teraz = new Date().getTime();
        let roznica = dataDocelowa - teraz;
        let dni = Math.floor(Math.abs(roznica) / (1000 * 60 * 60 * 24));
        let godziny = Math.floor((Math.abs(roznica) % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        let minuty = Math.floor((Math.abs(roznica) % (1000 * 60 * 60)) / (1000 * 60));
        let sekundy = Math.floor((Math.abs(roznica) % (1000 * 60)) / 1000);
    
        document.getElementById(dniId).innerHTML = dni;
        document.getElementById(godzinyId).innerHTML = godziny;
        document.getElementById(minutyId).innerHTML = minuty;
        document.getElementById(sekundyId).innerHTML = sekundy;
    }
    /**
    setInterval(() => {
        aktualizujOdliczanie(dataDocelowa1, "dni1-val", "godziny1-val", "minuty1-val", "sekundy1-val");
        aktualizujOdliczanie(dataDocelowa2, "dni2-val", "godziny2-val", "minuty2-val", "sekundy2-val");
        aktualizujOdliczanie(dataDocelowa3, "dni3-val", "godziny3-val", "minuty3-val", "sekundy3-val");
        aktualizujOdliczanie(dataDocelowa3, "dni4-val", "godziny4-val", "minuty4-val", "sekundy4-val");
    }, 1000);

/* Odliczanie/counter Homepage END */
/* Kalendarz */
moment.locale('pl');
    const events = {
        '2024-09-01': {
            image: 'images/jpg/img-jpg-07.jpg',
            title: 'Sesja rady gminy zarzecze',
            description: 'W najbliższy piątek odbędzie się kolejna sesja Rady Gminy Zarzecze, tematy które  zostaną poruszone: Przebudowa drogi Skarbowskiego, Nowi odbiorcy odpadów komunalnych.',
            date: '2024-09-01',
            hour: '14:00 - 18:00',
            location: 'Ratusz Miejski'
        },
        '2024-09-11': {
            image: 'images/jpg/img-jpg-06.jpg',
            title: 'Rozpoczęcie roku szkolnego',
            description: 'Quisque euismod lorem est, in convallis risus malesuada vitae. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae',
            date: '2024-09-01',
            hour: '7:00',
            location: 'Kościół'
        },
        '2024-09-15': {
            image: 'images/jpg/img-jpg-05.jpg',
            title: 'Zbiórka zużytych opon',
            description: 'Praesent luctus odio laoreet nunc vehicula ornare. In faucibus eu dui ac dictum. Proin vestibulum dui quis felis rhoncus, eget porttitor lacus consequat.',
            date: '2024-09-15',
            hour: '17:00 - 22:00',
            location: 'Remiza'
        },
        '2024-10-10': {
            image: 'images/jpg/img-jpg-08.jpg',
            title: 'Koncert zespołu "Baja Bongo"',
            description: 'Duis diam orci, mattis sit amet diam at, euismod fermentum eros. Nunc imperdiet laoreet nunc, ac venenatis sapien lacinia eu. Vestibulum iaculis ornare tortor.',
            date: '2024-10-10',
            hour: '21:30',
            location: 'Stadion Gminny'
        }
    };
    const getEarliestEvent = () => {
        let sortedDates = Object.keys(events).sort();
        return events[sortedDates[0]];
    };
    let currentMonth = moment(getEarliestEvent().date);
    let currentEventDate = getEarliestEvent().date;

    const drawCalendar = (month) => {
        let startOfMonth = month.startOf('month').day();
        let daysInMonth = month.daysInMonth();

        let daysArray = [];
        for (let i = 1; i <= daysInMonth; i++) {
            let eventDate = `${month.format('YYYY-MM')}-${String(i).padStart(2, '0')}`;
            let event = events[eventDate];
            let dayHtml = event ? `<button class="gz-activ-day" data-date="${eventDate}">${i}</button>` : `<span>${i}</span>`;
            daysArray.push(dayHtml);
        }

        let daysHtml = '';
        for (let i = 0; i < 42; i++) {
            if (i % 7 === 0) {
                if (i > 0) {
                    daysHtml += '</tr>';
                }
                daysHtml += '<tr>';
            }
            if (i >= startOfMonth && i < startOfMonth + daysInMonth) {
                daysHtml += `<td class="">${daysArray.shift()}</td>`;
            } else {
                daysHtml += '<td></td>';
            }
        }
        daysHtml += '</tr>';

        $('#currentMonth').text(month.format('MMMM YYYY'));
        $('#days').html(daysHtml);
    };

    const displayEventDetails = (event) => {
        if (!event) {
            $('#eventDetails').empty();
            return;
        }
        let html = `

            <img src="${event.image}" alt="${event.title}">

            <div class="gz-right-padding">
                <h2>${event.title}</h2>
                <p>${event.description}</p>
                <p class="gz-frame gz-mt-10"><span class="gz-bold">Data wydarzenia: </span>${event.date}</p>
                <p class="gz-frame"><span class="gz-bold">Godzina: </span>${event.hour}</p>
                <p class="gz-frame"><span class="gz-bold">Lokalizacja: </span>${event.location}</p>
            </div>
        `;
        $('#eventDetails').html(html);
    };

    $(document).on('click', '#prev', () => {
        currentMonth.add(-1, 'month');
        drawCalendar(currentMonth);
    });

    $(document).on('click', '#next', () => {
        currentMonth.add(1, 'month');
        drawCalendar(currentMonth);
    });

    $(document).on('click', '.gz-activ-day ', function() {
        let date = $(this).data('date');
        currentEventDate = date;
        displayEventDetails(events[date]);
    });

    drawCalendar(currentMonth);
    displayEventDetails(events[currentEventDate]);
/* Kalendarz END */
/* Filtrowanie aktualnosci*/
function filterAktualnosci(tag) {
    const items = document.querySelectorAll('.aktualnosci-item');
    items.forEach(item => {
        if (tag && !item.getAttribute('data-tags').includes(tag)) {
            item.classList.add('filtered');
        } else {
            item.classList.remove('filtered');
        }
    });
}
/* Galeria hover i filtrowanie*/
function filterGallery(tag) {
    const items = document.querySelectorAll('.gallery-item');
    items.forEach(item => {
        if (tag && !item.getAttribute('data-tags').includes(tag)) {
            item.classList.add('filtered');
        } else {
            item.classList.remove('filtered');
        }
    });
}
function loadMoreBoxes() {
    const hiddenBoxes = document.querySelectorAll('.hidden-box');
    hiddenBoxes.forEach(box => {
        box.classList.remove('hidden-box');
    });
}
/* Galeria hover i filtrowanie END */
function openVideoModal(videoSrc, isYouTube) {
    const videoPlayer = document.getElementById('videoPlayer');
    const videoPlayerIframe = document.getElementById('videoPlayerIframe');
    const videoModal = new bootstrap.Modal(document.getElementById('videoModal'));

    if (isYouTube) {
        videoPlayer.style.display = 'none';
        videoPlayerIframe.style.display = 'block';
        videoPlayerIframe.src = videoSrc;
    } else {
        videoPlayerIframe.style.display = 'none';
        videoPlayer.style.display = 'block';
        videoPlayer.src = videoSrc;
        videoPlayer.play();
    }

    videoModal.show();
    videoModal._element.addEventListener('hidden.bs.modal', () => {
        videoPlayer.src = '';
        videoPlayerIframe.src = '';
    });
}
/* Ustawienia Kontrastu */
document.addEventListener('DOMContentLoaded', function() {
    var contrastOption = localStorage.getItem('contrastOption');
    var fontSizeOption = localStorage.getItem('fontSizeOption');
    if (!contrastOption) {
        contrastOption = 'normal';
        localStorage.setItem('contrastOption', contrastOption);
    }
    if (!fontSizeOption) {
        fontSizeOption = 'normal';
        localStorage.setItem('fontSizeOption', fontSizeOption);
    }
    changeContrast(contrastOption);
    changeFontSize(fontSizeOption);
});
function changeContrast(option) {
    document.getElementById('contrastA').disabled = true;
    document.getElementById('contrastB').disabled = true;
    document.getElementById('contrastC').disabled = true;
    document.getElementById('normalStyle').disabled = false;
    if (option === 'A') {
        document.getElementById('contrastA').disabled = false;
    } else if (option === 'B') {
        document.getElementById('contrastB').disabled = false;
    } else if (option === 'C') {
        document.getElementById('contrastC').disabled = false;
    }
    if (option === 'normal') {
        localStorage.removeItem('contrastOption');
    } else {
        localStorage.setItem('contrastOption', option);
    }
    var buttons = document.querySelectorAll('.contrastButton');
    buttons.forEach(function(button) {
        button.classList.remove('active');
    });
    document.getElementById(option === 'normal' ? 'normalButton' : 'contrastButton' + option).classList.add('active');
}
function changeFontSize(option) {
    document.getElementById('fontSmall').disabled = true;
    document.getElementById('fontMedium').disabled = true;

    if (option === 'small') {
        document.getElementById('fontSmall').disabled = false;
    } else if (option === 'medium') {
        document.getElementById('fontMedium').disabled = false;
    } else if (option === 'large') {
        document.getElementById('fontLarge').disabled = false;
    }
    if (option === 'normal') {
        localStorage.removeItem('fontSizeOption');
    } else {
        localStorage.setItem('fontSizeOption', option);
    }
}
/* Ustawienia Kontrastu END */

// Karuzela 1
var carousel1 = document.querySelector("#carousel-gz-1");
var isMobileView1 = window.matchMedia("(max-width: 767px)").matches;
if (isMobileView1) {
    // Mobile
    $(carousel1).addClass("slide");
    var cardWidth1 = $(".carousel-item", carousel1).width();
    var scrollPosition1 = 0;

    $("#carousel-gz-1 .carousel-control-next").on("click", function () {
        var carouselWidth1 = $(".carousel-inner", carousel1)[0].scrollWidth;
        if (scrollPosition1 < carouselWidth1 - cardWidth1) {
            scrollPosition1 += cardWidth1;
            $("#carousel-gz-1 .carousel-inner").animate(
                { scrollLeft: scrollPosition1 },
                600
            );
        } else {
            scrollPosition1 = 0;
            $("#carousel-gz-1 .carousel-inner").animate(
                { scrollLeft: scrollPosition1 },
                600
            );
        }
    });

    $("#carousel-gz-1 .carousel-control-prev").on("click", function () {
        if (scrollPosition1 > 0) {
            scrollPosition1 -= cardWidth1;
            $("#carousel-gz-1 .carousel-inner").animate(
                { scrollLeft: scrollPosition1 },
                600
            );
        } else {
            var carouselWidth1 = $(".carousel-inner", carousel1)[0].scrollWidth;
            scrollPosition1 = carouselWidth1 - cardWidth1;
            $("#carousel-gz-1 .carousel-inner").animate(
                { scrollLeft: scrollPosition1 },
                600
            );
        }
    });
} else {
    // Desktop  
    var carouselWidth1 = $(".carousel-inner", carousel1)[0].scrollWidth;
    var cardWidth1 = $(".carousel-item", carousel1).width();
    var scrollPosition1 = 0;

    $("#carousel-gz-1 .carousel-control-next").on("click", function () {
        if (scrollPosition1 < carouselWidth1 - cardWidth1 * 2) {
            scrollPosition1 += cardWidth1 * 2;
            $("#carousel-gz-1 .carousel-inner").animate(
                { scrollLeft: scrollPosition1 },
                600
            );
        } else {
            scrollPosition1 = 0;
            $("#carousel-gz-1 .carousel-inner").animate(
                { scrollLeft: scrollPosition1 },
                600
            );
        }
    });

    $("#carousel-gz-1 .carousel-control-prev").on("click", function () {
        if (scrollPosition1 > 0) {
            scrollPosition1 -= cardWidth1 * 2;
            $("#carousel-gz-1 .carousel-inner").animate(
                { scrollLeft: scrollPosition1 },
                600
            );
        } else {
            scrollPosition1 = carouselWidth1 - cardWidth1 * 2;
            $("#carousel-gz-1 .carousel-inner").animate(
                { scrollLeft: scrollPosition1 },
                600
            );
        }
    });
}
// Karuzela 2
var carousel2 = document.querySelector("#carousel-gz-2");
var isMobileView2 = window.matchMedia("(max-width: 767px)").matches;
if (isMobileView2) {
    // Mobile
    $(carousel2).addClass("slide");
    var cardWidth2 = $(".carousel-item", carousel2).width();
    var scrollPosition2 = 0;

    $("#carousel-gz-2 .carousel-control-next").on("click", function () {
        var carouselWidth2 = $(".carousel-inner", carousel2)[0].scrollWidth;
        if (scrollPosition2 < carouselWidth2 - cardWidth2) {
            scrollPosition2 += cardWidth2;
            $("#carousel-gz-2 .carousel-inner").animate(
                { scrollLeft: scrollPosition2 },
                600
            );
        } else {
            scrollPosition2 = 0;
            $("#carousel-gz-2 .carousel-inner").animate(
                { scrollLeft: scrollPosition2 },
                600
            );
        }
    });

    $("#carousel-gz-2 .carousel-control-prev").on("click", function () {
        if (scrollPosition2 > 0) {
            scrollPosition2 -= cardWidth2;
            $("#carousel-gz-2 .carousel-inner").animate(
                { scrollLeft: scrollPosition2 },
                600
            );
        } else {
            var carouselWidth2 = $(".carousel-inner", carousel2)[0].scrollWidth;
            scrollPosition2 = carouselWidth2 - cardWidth2;
            $("#carousel-gz-2 .carousel-inner").animate(
                { scrollLeft: scrollPosition2 },
                600
            );
        }
    });
} else {
    // Desktop  
    var carouselWidth2 = $(".carousel-inner", carousel2)[0].scrollWidth;
    var cardWidth2 = $(".carousel-item", carousel2).width();
    var scrollPosition2 = 0;

    $("#carousel-gz-2 .carousel-control-next").on("click", function () {
        if (scrollPosition2 < carouselWidth2 - cardWidth2 * 4) {
            scrollPosition2 += cardWidth2 * 4;
            $("#carousel-gz-2 .carousel-inner").animate(
                { scrollLeft: scrollPosition2 },
                600
            );
        } else {
            scrollPosition2 = 0;
            $("#carousel-gz-2 .carousel-inner").animate(
                { scrollLeft: scrollPosition2 },
                600
            );
        }
    });

    $("#carousel-gz-2 .carousel-control-prev").on("click", function () {
        if (scrollPosition2 > 0) {
            scrollPosition2 -= cardWidth2 * 4;
            $("#carousel-gz-2 .carousel-inner").animate(
                { scrollLeft: scrollPosition2 },
                600
            );
        } else {
            scrollPosition2 = carouselWidth2 - cardWidth2 * 4;
            $("#carousel-gz-2 .carousel-inner").animate(
                { scrollLeft: scrollPosition2 },
                600
            );
        }
    });
}
// Karuzela 3
var carousel3 = document.querySelector("#carousel-gz-3");
var isMobileView3 = window.matchMedia("(max-width: 767px)").matches;
if (isMobileView3) {
    // Mobile
    $(carousel3).addClass("slide");
    var cardWidth3 = $(".carousel-item", carousel3).width();
    var scrollPosition3 = 0;

    $("#carousel-gz-3 .carousel-control-next").on("click", function () {
        var carouselWidth3 = $(".carousel-inner", carousel3)[0].scrollWidth;
        if (scrollPosition3 < carouselWidth3 - cardWidth3) {
            scrollPosition3 += cardWidth3;
            $("#carousel-gz-3 .carousel-inner").animate(
                { scrollLeft: scrollPosition3 },
                600
            );
        } else {
            scrollPosition3 = 0;
            $("#carousel-gz-3 .carousel-inner").animate(
                { scrollLeft: scrollPosition3 },
                600
            );
        }
    });

    $("#carousel-gz-3 .carousel-control-prev").on("click", function () {
        if (scrollPosition3 > 0) {
            scrollPosition3 -= cardWidth3;
            $("#carousel-gz-3 .carousel-inner").animate(
                { scrollLeft: scrollPosition3 },
                600
            );
        } else {
            var carouselWidth3 = $(".carousel-inner", carousel3)[0].scrollWidth;
            scrollPosition3 = carouselWidth3 - cardWidth3;
            $("#carousel-gz-3 .carousel-inner").animate(
                { scrollLeft: scrollPosition3 },
                600
            );
        }
    });
} else {
    // Desktop  
    var carouselWidth3 = $(".carousel-inner", carousel3)[0].scrollWidth;
    var cardWidth3 = $(".carousel-item", carousel3).width();
    var scrollPosition3 = 0;

    $("#carousel-gz-3 .carousel-control-next").on("click", function () {
        if (scrollPosition3 < carouselWidth3 - cardWidth3 * 4) {
            scrollPosition3 += cardWidth3 * 4;
            $("#carousel-gz-3 .carousel-inner").animate(
                { scrollLeft: scrollPosition3 },
                600
            );
        } else {
            scrollPosition3 = 0;
            $("#carousel-gz-3 .carousel-inner").animate(
                { scrollLeft: scrollPosition3 },
                600
            );
        }
    });

    $("#carousel-gz-3 .carousel-control-prev").on("click", function () {
        if (scrollPosition3 > 0) {
            scrollPosition3 -= cardWidth3 * 4;
            $("#carousel-gz-3 .carousel-inner").animate(
                { scrollLeft: scrollPosition3 },
                600
            );
        } else {
            scrollPosition3 = carouselWidth3 - cardWidth3 * 4;
            $("#carousel-gz-3 .carousel-inner").animate(
                { scrollLeft: scrollPosition3 },
                600
            );
        }
    });
}