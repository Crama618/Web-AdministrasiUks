// Animasi tombol saat diklik
document.addEventListener("DOMContentLoaded", function () {
    let buttons = document.querySelectorAll("button, a");

    buttons.forEach(button => {
        button.addEventListener("click", function () {
            this.style.animation = "bounce 0.3s";
            setTimeout(() => {
                this.style.animation = "";
            }, 300);
        });
    });
});

// Keyframe animasi untuk efek klik
const styleSheet = document.styleSheets[0];
styleSheet.insertRule(`
@keyframes bounce {
    0% { transform: scale(1); }
    50% { transform: scale(1.2); }
    100% { transform: scale(1); }
}`, styleSheet.cssRules.length);

document.addEventListener("DOMContentLoaded", function () {
    let menuItems = document.querySelectorAll(".menu li a");

    menuItems.forEach(item => {
        item.addEventListener("click", function () {
            this.style.transform = "scale(1.2)";
            setTimeout(() => {
                this.style.transform = "scale(1)";
            }, 200);
        });
    });
});
