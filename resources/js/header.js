// When the user scrolls the page, execute myFunction
window.onscroll = function () { headerControl() };

function headerControl() {
    var winScroll = document.body.scrollTop || document.documentElement.scrollTop;
    var height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
    var scrolled = (winScroll / height) * 100;
    document.getElementById("scrollBar").style.width = scrolled + "%";

    var header = document.getElementById("stickyHeader");
    var sticky = header.offsetTop;
    if (window.pageYOffset > sticky) {
        header.classList.add("stickyheader");
    } else {
        header.classList.remove("stickyheader");
    }
}

