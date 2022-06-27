// Toggle hamburger menu
const toggle = document.getElementById('toggleHamburger');
const dropdown = document.getElementById('dropdown');

toggle.addEventListener('click', () => {
    toggle.classList.toggle('active');
    dropdown.classList.toggle('active');
});

// background image display on page load
var background = document.body;
if (window.location.href === 'http://localhost/Final-Project/public/bigCard.php#football') {
    background.style.backgroundImage = "url('../assets/img/football.jpg')";
} else if (window.location.href === 'http://localhost/Final-Project/public/bigCard.php#basketball') {
    background.style.backgroundImage = "url('../assets/img/basketball.jpg')";
} else if (window.location.href === 'http://localhost/Final-Project/public/bigCard.php#tennis') {
    background.style.backgroundImage = "url('../assets/img/tennis.jpg')";
}

// Dynamic background image change while hovering between cards
const navScroll = document.querySelectorAll('.nav-scroll');
navScroll.forEach(item => {
    item.addEventListener('click', () => {
        var href = item.getAttribute('href');
        if (href == "#football") {
            background.style.backgroundImage = "url('../assets/img/football.jpg')";
        } else if (href == "#basketball") {
            background.style.backgroundImage = "url('../assets/img/basketball.jpg')";
        } else if (href == "#tennis") {
            background.style.backgroundImage = "url('../assets/img/tennis.jpg')";
        } else {
            throw new Error("Invalid href");
        }
    });
});

//court schedule
const scheduleDiv = document.querySelector(".court-schedule-title");
const scheduleContent = document.querySelector(".court-schedule-content");
const scheduleTitleToggle = document.querySelectorAll('.fa-caret-down');

scheduleDiv.addEventListener('click', () => {
    scheduleContent.classList.toggle('active');
    scheduleTitleToggle.forEach(item => {
        item.classList.toggle('active');
    });
});


const toggleFootballContent = document.getElementById('toggleContentF');
const contentFootball = document.getElementById('contentF');
const footballCard = document.getElementById('football');
toggleFootballContent.addEventListener('click', () => {
    toggleFootballContent.classList.toggle('active');
    contentFootball.classList.toggle('active');
    footballCard.classList.toggle('active');
})

const toggleBasketballContent = document.getElementById('toggleContentB');
const contentBasketball = document.getElementById('contentB');
const basketballCard = document.getElementById('basketball');
toggleBasketballContent.addEventListener('click', () => {
    toggleBasketballContent.classList.toggle('active');
    contentBasketball.classList.toggle('active');
    basketballCard.classList.toggle('active');
})

const toggleTennisContent = document.getElementById('toggleContentT');
const contentTennis = document.getElementById('contentT');
const tennisCard = document.getElementById('tennis');
toggleTennisContent.addEventListener('click', () => {
    toggleTennisContent.classList.toggle('active');
    contentTennis.classList.toggle('active');
    tennisCard.classList.toggle('active');
})


// Alert to cancel a reservation
function confirmDelete(resID) {
    Swal.fire({
        title: "Are you sure you want to delete this reservation?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Yes, delete it!"
        
    }).then((result) => {
        if (result.value) {
            window.location.href = `../modules/auth/delete.php?deleteid=${resID}`;
        }
    })
}

function adminConfirmDelete(resID) {
    Swal.fire({
        title: "Are you sure you want to delete this reservation?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Yes, delete it!"
        
    }).then((result) => {
        if (result.value) {
            window.location.href = `../modules/auth/adminDelete.php?deleteid=${resID}`;
        }
    })
}



