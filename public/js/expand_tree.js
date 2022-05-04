// completely expand tree
function show_all(prefix) {
    // set functionality of all hidden elemens to block
    var elem = document.getElementsByClassName("hidden");
    for(var i = 0; i < elem.length; i++){
        elem[i].style.display = "block";
    }
    
    // images of internal 036 images can stay as they are, only the plus sign has to be replace by minus and the function has to be changed
    elem = document.getElementsByClassName("i_036");
    for(i = 0; i < elem.length; i++){
        elem[i].src = elem[i].src.replace("plus", "minus");
        var scri = elem[i].getAttribute('onclick').replace("minus", "plus");
        elem[i].setAttribute("onClick", scri);
    }
    
    // the same holds for last images
    elem = document.getElementsByClassName("last");
    for(i = 0; i < elem.length; i++){
        elem[i].src = elem[i].src.replace("plus", "minus");
        var scrip = elem[i].getAttribute('onclick').replace("minus", "plus");
        elem[i].setAttribute("onClick", scrip);
    }
    
    // the very last images has to be changed to 06 instead of 03
    var last = document.getElementsByClassName("ll");
    for(i = 0; i < last.length; i++){
        last[i].src = prefix + "img/06.png";
    }
}

// hide all branches of tree and show only kingdoms
function hide_all(prefix) {
    // set the visibility for all hideable elements to none
    var elem = document.getElementsByClassName("hidden");
    for(var i = 0; i < elem.length; i++){
        elem[i].style.display = "none";
    }
    
    // change all minus to plus signs and change the function of the images
    elem = document.getElementsByClassName("i_036");
    for(i = 0; i < elem.length; i++){
        elem[i].src = elem[i].src.replace("minus", "plus");
        var scri = elem[i].getAttribute('onclick').replace("plus", "minus");
        elem[i].setAttribute("onClick", scri);
    }
    
    // change all minus to plus signs and change the function of the images
    elem = document.getElementsByClassName("last");
    for(i = 0; i < elem.length; i++){
        elem[i].src = elem[i].src.replace("minus", "plus");
        var scrip = elem[i].getAttribute('onclick').replace("plus", "minus");
        elem[i].setAttribute("onClick", scrip);
    }
    
    // very last images has to be changed from 06 to 03
    var last = document.getElementsByClassName("ll");
    for(i = 0; i < last.length; i++){
        last[i].src = prefix + "img/03.png";
    }
}


// function for expanding a subtree
function to_minus(id, prefix) {
    /*
     *parameters:
     *id = id of clicked image
     *prefix = image location (added for internal version)
    */
    var elem = document.getElementById(id);
    
    // change pictures of directly following images
    if (elem.src.indexOf("plus_036") != -1) {
        elem.src = prefix + "img/minus_036.png";
    }
    if(elem.src.indexOf("plus_03") != -1){
        elem.src = prefix + "img/minus_03.png";
    }
    var lastImg = document.getElementById("last-" + id);
    if (lastImg && elem.getAttribute('class').indexOf("last") != -1) {
        lastImg.src = prefix + "img/06.png";
    }
    var otherLastImg = document.getElementById("llast-" + id);
    if (otherLastImg && elem.getAttribute('class').indexOf("last") != -1) {
        otherLastImg.src = prefix + "img/06.png";
    }
    otherLastImg = document.getElementById("lllast-" + id);
    if (otherLastImg && elem.getAttribute('class').indexOf("last") != -1) {
        otherLastImg.src = prefix + "img/06.png";
    }
    var scri = elem.getAttribute('onclick').replace("minus", "plus");
    elem.setAttribute("onClick", scri);
    show_table(id);
}

// function for collapsing a subtree
function to_plus(id, prefix){
    /*
     *parameters:
     *id = id of clicked image
     *prefix = image location (added for internal version)
    */
    var elem = document.getElementById(id);
    // change picture of itself
    // if id is id of last element use other picture
    if (elem.getAttribute('class').indexOf("last") != -1) {
        elem.src = prefix + "img/plus_03.png";
    }
    else if (elem.src.indexOf("minus_036") != -1) {
        elem.src = prefix + "img/plus_036.png";
    }
    
    // change pictures of directly following images
    var lastImg = document.getElementById("last-" + id);
    if (lastImg && elem.getAttribute('class').indexOf("last") != -1) {
        lastImg.src = prefix + "img/03.png";
    }
    
    var otherLastImg = document.getElementById("llast-" + id);
    if (otherLastImg && elem.getAttribute('class').indexOf("last") != -1) {
        otherLastImg.src = prefix + "img/03.png";
    }
    otherLastImg = document.getElementById("lllast-" + id);
    if (otherLastImg && elem.getAttribute('class').indexOf("last") != -1) {
        otherLastImg.src = prefix + "img/03.png";
    }
    
    // change script from minus to plus (itself)
    var scri = elem.getAttribute('onclick').replace("plus", "minus");
    elem.setAttribute("onClick", scri);
    hide_table(id);
    
    var imgs = document.getElementsByClassName("last-" + id);
    for(var i = 0; i < imgs.length; i++){
        imgs[i].src = prefix + "img/03.png";
    }
    
    // hide following tables
    var hides = document.getElementsByClassName("hide-" + id);
    for (var j = 0; j < hides.length; j++) {
        hides[j].style.display = "none";
    }
    
    // change last minuses to pluses
    var images = document.getElementsByClassName("last img" + id);
    for(i = 0; i < images.length; i++){
        images[i].src= prefix + "img/plus_03.png";
        scri = images[i].getAttribute('onclick').replace("plus", "minus");
        images[i].setAttribute("onClick", scri);
    }
    // change successive minuses to pluses
    images = document.getElementsByClassName("i_036 img" + id);
    for(i = 0; i < images.length; i++){
        images[i].src= prefix + "img/plus_036.png";
        scri = images[i].getAttribute('onclick').replace("plus", "minus");
        images[i].setAttribute("onClick", scri);
    }
    
    // if a kingdom is collapsed change all last 06 pictures to 03 belonging to that kingdom
    var spl = id.split("-");
    if (spl.length == 2 || spl.length == 3) {
        var last = document.getElementsByClassName("ll-" + id);
        for(i = 0; i < last.length; i++){
            last[i].src = prefix + "img/03.png";
        }
    }
}


// hide complete table
function hide_table(classname) {
    var elem = document.getElementsByClassName(classname);
    for(var i = 0; i < elem.length; i++){
        elem[i].style.display = "none";
    }
}

// show complete table
function show_table(classname) {
    var elem = document.getElementsByClassName(classname);
    for(var i = 0; i < elem.length; i++){
        elem[i].style.display = "block";
    }
}