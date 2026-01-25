// =======================
// SIDENAV
// =======================
function openNav() {
    document.getElementById("mySidenav").style.width = "250px";
    // opsionale: shton blur në main
    // document.getElementById("main").style.filter = "blur(2px)";
}

function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
    // opsionale: hiq blur
    // document.getElementById("main").style.filter = "none";
}

// =======================
// BUTONAT LOGIN / REGISTER / APLIKO
// =======================
document.getElementById("loginBtn")?.addEventListener("click", function() {
    window.location.href = "loginform.html";
});

document.getElementById("registerBtn")?.addEventListener("click", function() {
    window.location.href = "registerform.html";
});

// Funksion për butonat "Apliko" në job cards
const applyButtons = document.querySelectorAll(".apply-btn");
applyButtons.forEach(btn => {
    btn.addEventListener("click", function() {
        window.location.href = "loginform.html";
    });
});

// =======================
// SEARCH BOX FUNCTION
// =======================
function kontrolloSearch() {
    const pozicioni = document.getElementById("pozicioni").value.trim();
    const kategoria = document.getElementById("kategoria")?.value;
    const lokacioni = document.querySelector('.search-box input[placeholder*="Lokacioni"]').value.trim();
    const mesazhi = document.getElementById("mesazhi");

    let errors = [];

    if (!pozicioni) errors.push("Ju lutem shkruani pozicionin e punës.");
    if (!kategoria) errors.push("Ju lutem zgjidhni një kategori.");
    if (!lokacioni) errors.push("Ju lutem shkruani lokacionin.");

    if (errors.length > 0) {
        mesazhi.textContent = errors.join(" ");
        mesazhi.style.display = "block";
    } else {
        mesazhi.textContent = "";
        mesazhi.style.display = "none";
        // redirect ose alert (vetëm shembull)
        alert("Kërkimi u krye me sukses!");
    }
}

// =======================
// CONTACT FORM
// =======================
const contactForm = document.getElementById("contactForm");
if (contactForm) {
    contactForm.addEventListener("submit", function(e) {
        e.preventDefault();
        // opsionale: mund të dërgosh të dhënat me AJAX këtu
        const successDiv = document.getElementById("success");
        successDiv.style.display = "block";
        // pas disa sekondash fsheh mesazhin
        setTimeout(() => {
            successDiv.style.display = "none";
            contactForm.reset();
        }, 3000);
    });
}

// =======================
// TABS FUNCTION (Home Page)
// =======================
function ndryshoTabin(el) {
    const tabs = el.parentElement.querySelectorAll(".tab");
    tabs.forEach(tab => tab.classList.remove("active"));
    el.classList.add("active");

    // opsionale: mund të ndryshosh përmbajtjen bazuar në tab
    console.log("Tab aktive:", el.textContent);
}

// =======================
// APLIKO BUTTONS - SCROLL
// =======================
const applyButton = document.querySelectorAll(".apply-btn");
applyButtons.forEach(btn => {
    btn.addEventListener("click", function() {
        const jobsSection = document.querySelector(".jobs-wrap");
        if (jobsSection) {
            // Scroll tek seksioni
            jobsSection.scrollIntoView({ behavior: "smooth" });
        }
    });
});
