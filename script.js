document.getElementById("loginBtn").addEventListener("click", function() {
    window.location.href = "loginform.html";  
});

document.getElementById("registerBtn").addEventListener("click", function() {
    window.location.href = "registerform.html";  
});




function openNav() {
    document.getElementById("mySidenav").style.width = "250px";
    document.getElementById("main").style.marginRight = "250px";
  }
  
  function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
    document.getElementById("main").style.marginRight= "0";
  }


  function ndryshoTabin(elementi) {
    let tabs = document.getElementsByClassName("tab");

    for (let i = 0; i < tabs.length; i++) {
        tabs[i].classList.remove("active");
    }

    elementi.classList.add("active");
}

document.getElementById("searchBtn").addEventListener("click", function () {

    let pozicioni = document.getElementById("pozicioni").value.trim();
    let kategoria = document.getElementById("kategoria").value;
    let lokacioni = document.getElementById("lokacioni").value.trim();
    let mesazhi = document.getElementById("mesazhi");

    if (pozicioni === "" || kategoria === "" || lokacioni === "") {
        mesazhi.style.display = "block";
        mesazhi.textContent = "Ju lutem plotësoni të gjitha fushat para kërkimit.";
    } else {
        mesazhi.style.display = "none";
        alert("Kërkimi u krye me sukses ✅"); // test
    }
});



const aboutBox = document.querySelector(".about-wrapper");

window.addEventListener("load", () => {
    aboutBox.style.opacity = "0";
     aboutBox.style.opacity = "translativ(40px)";

     setTimeout(() => {
        aboutBox.style.transition = "0.8s ease";
        aboutBox.style.opacity = "1";
        aboutBox.style.transform = "translate(0)";
     }, 200);

});


