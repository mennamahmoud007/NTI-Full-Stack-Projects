// for navbar scrolled 
window.addEventListener("scroll", function () {

    const navbar = document.getElementById("navbar");

    if(window.scrollY > 500){
        navbar.classList.add("scrolled");
    }
    else{
        navbar.classList.remove("scrolled");
    }
});
/*another approach [not best practice]
window.addEventListener("scroll", function () {
    const navbar = document.getElementById("navbar");
    if (window.scrollY > 500) {
        navbar.style.backgroundColor = "#0a192f";
        navbar.style.boxShadow = "0 4px 15px rgba(0,0,0,.25)";
        navbar.style.transition = ".4s";
    } else {
        navbar.style.backgroundColor = "transparent";
        navbar.style.boxShadow = "none";
    }
});
*/

