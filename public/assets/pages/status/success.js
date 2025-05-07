let seconds = 60;
const countdownElement = document.getElementById("countdown");

const countdown = setInterval(() => {
    seconds--;
    countdownElement.innerHTML = `Bạn sẽ được chuyển về trang chủ sau <strong>${seconds}</strong> giây...`;

    if (seconds <= 0) {
        clearInterval(countdown);
        window.location.href = 'http://localhost/PHP_MVC/public/';
    }
}, 1000);