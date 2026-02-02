const floatingNav = document.getElementById("floatingNav");
let lastScrollTop = 0;

// show nav after load
setTimeout(() => {
    floatingNav.classList.add("visible");
}, 500);

// hide on scroll down, show on scroll up
window.addEventListener("scroll", () => {
    const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

    if (scrollTop > lastScrollTop && scrollTop > 100) {
        floatingNav.classList.remove("visible");
        floatingNav.classList.add("hide-on-scroll");
    } else {
        floatingNav.classList.add("visible");
        floatingNav.classList.remove("hide-on-scroll");
    }

    lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
}, { passive: true });

// highlight active page
const currentPage = location.pathname.split("/").pop() || "index.php";
document.querySelectorAll(".nav-item").forEach(item => {
    if (item.getAttribute("href") === currentPage) {
        item.classList.add("active");
    }
});


// toast helpers
function showToast(message) {
    const toast = document.getElementById("toast");
    document.getElementById("toastMessage").textContent = message;
    toast.classList.add("show");
}

function hideToast() {
    document.getElementById("toast").classList.remove("show");
}
