require([
    'jquery',
    'domReady!'
], function ($) {
    var frontName;
    var displayGroup;

    frontName = document.querySelectorAll(".deco-menu-mobile li.has-child .front-name-outside");
    for(i = 0;i < frontName.length;i++) {
        frontName[i].onclick = function(){
            displayGroup = this.parentElement.nextElementSibling;
            if(displayGroup.style.display == "none" || displayGroup.style.display == "") {
                this.classList.add("open");
                displayGroup.style.display = "block";
            } else {
                this.classList.remove("open");
                displayGroup.style.display = "none";
            }
        };
    }
});