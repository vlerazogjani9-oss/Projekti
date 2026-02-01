// =======================
// SIDENAV
// =======================
function openNav() {
    var nav = document.getElementById("mySidenav");
    if (nav) nav.style.width = "250px";
}

function closeNav() {
    var nav = document.getElementById("mySidenav");
    if (nav) nav.style.width = "0";
}

// =======================
// BUTONAT LOGIN / REGISTER (fallback when no onclick on page)
// =======================
var loginBtn = document.getElementById("loginBtn");
if (loginBtn && !loginBtn.getAttribute("onclick")) {
    loginBtn.addEventListener("click", function() {
        window.location.href = "auth/loginform.php";
    });
}
var registerBtn = document.getElementById("registerBtn");
if (registerBtn && !registerBtn.getAttribute("onclick")) {
    registerBtn.addEventListener("click", function() {
        window.location.href = "auth/registerform.php";
    });
}

// Apliko buttons - redirect to login when not logged in (fallback)
var applyButtons = document.querySelectorAll(".apply-btn");
applyButtons.forEach(function(btn) {
    if (!btn.getAttribute("onclick")) {
        btn.addEventListener("click", function() {
            window.location.href = "auth/loginform.php";
        });
    }
});

// =======================
// CONTACT FORM - allow normal POST submit (no preventDefault)
// =======================
var contactForm = document.getElementById("contactForm");
if (contactForm) {
    contactForm.addEventListener("submit", function() {
        // Form submits normally to same page (POST); server shows success after redirect
    });
}

// =======================
// TABS (Home Page)
// =======================
function ndryshoTabin(el) {
    if (!el || !el.parentElement) return;
    var tabs = el.parentElement.querySelectorAll(".tab");
    tabs.forEach(function(tab) { tab.classList.remove("active"); });
    el.classList.add("active");
}

// =======================
// SEARCH BOX TABS (Kërko punë / Kërko kandidat)
// =======================
(function() {
    var searchBox = document.querySelector(".search-box");
    if (!searchBox) return;
    var tabs = searchBox.querySelectorAll(".tab[data-search]");
    var filtersJobs = searchBox.querySelector(".filters-jobs");
    var filtersCandidates = searchBox.querySelector(".filters-candidates");
    if (!tabs.length || !filtersJobs || !filtersCandidates) return;
    tabs.forEach(function(tab) {
        tab.addEventListener("click", function() {
            ndryshoTabin(this);
            var mode = this.getAttribute("data-search");
            if (mode === "candidates") {
                filtersJobs.style.display = "none";
                filtersCandidates.style.display = "";
            } else {
                filtersJobs.style.display = "";
                filtersCandidates.style.display = "none";
            }
        });
    });
})();
