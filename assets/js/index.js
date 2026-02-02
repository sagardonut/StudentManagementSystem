const floatingNav = document.getElementById("floatingNav");

if (floatingNav) {
    let lastScrollTop = 0;

    setTimeout(() => floatingNav.classList.add("visible"), 200);

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

    const currentPage = location.pathname.split("/").pop() || "index.php";
    document.querySelectorAll(".nav-item").forEach(item => {
        if (item.getAttribute("href") === currentPage) item.classList.add("active");
    });
}

// toast helpers (won’t crash if toast missing)
function showToast(message) {
    const toast = document.getElementById("toast");
    const msg = document.getElementById("toastMessage");
    if (!toast || !msg) return;
    msg.textContent = message;
    toast.classList.add("show");
}

function hideToast() {
    const toast = document.getElementById("toast");
    if (!toast) return;
    toast.classList.remove("show");
}
// ripple effect
document.querySelectorAll(".nav-item").forEach(item => {
    item.addEventListener("click", e => {
        const ripple = document.createElement("span");
        const rect = item.getBoundingClientRect();
        const size = Math.max(rect.width, rect.height);
        ripple.style.width = ripple.style.height = size + "px";
        ripple.style.left = e.clientX - rect.left - size / 2 + "px";
        ripple.style.top = e.clientY - rect.top - size / 2 + "px";
        ripple.className = "ripple";
        item.appendChild(ripple);
        setTimeout(() => ripple.remove(), 600);
    });
});