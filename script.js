document.getElementById("loginBtn").addEventListener("click", function() {
    window.location.href = "loginform.html";  
});

document.getElementById("registerBtn").addEventListener("click", function() {
    window.location.href = "registerform.html";  
});

document.getElementById("language-select").addEventListener("change", function() {
    const lang = this.value;
    if(lang === "english") {
        alert("Gjuha u ndryshua në English!"); // ose mund të ridrejtohesh në versionin English
    } else if(lang === "shqip") {
        alert("Gjuha u ndryshua në Shqip!");
    }
});
