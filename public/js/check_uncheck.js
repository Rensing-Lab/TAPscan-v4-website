// check all checkboxes on the page
function check_all(prefix){
    var name = prefix + "check";
    var elem = document.getElementsByClassName(name);
    for(var i = 0; i < elem.length; i++){
        elem[i].checked = true;
    }
};

// uncheck all checkboxes
function uncheck_all(prefix) {
    var name = prefix + "check";
    var elem = document.getElementsByClassName(name);
    for(var i = 0; i < elem.length; i++){
        elem[i].checked = false;
    }
};

// check all checkboxes for proteins from genome
function check_genome(prefix) {
    var elem = document.getElementsByClassName("Genome");
    for(var i = 0; i < elem.length; i++){
        elem[i].checked = true;
    }
    var elem = document.getElementsByClassName("Transcriptome");
    for(var i = 0; i < elem.length; i++){
        elem[i].checked = false;
    }
    var elem = document.getElementsByClassName("cladebox");
    for(var i = 0; i < elem.length; i++){
        var elems = document.getElementsByClassName("c-" + elem[i].id);
        var checked = 0;
        for (var j = 0; j < elems.length; j++) {
            if (elems[j].checked) {
                checked++;
            }
        }
        if (checked == elems.length) {
            elem[i].checked = true;
        }
        else{
            elem[i].checked = false;
        }
    }
}

// check all checkboxes for proteins of a clade
function check_following(elemID) {
    var elem = document.getElementById(elemID);
    if (elem.checked){
        uncheck_boxes(elemID);
    }
    else{
        check_boxes(elemID);
    }
};

// check all boxes with class c-given ID
function check_boxes(elemID) {
    var elem = document.getElementsByClassName("c-" + elemID);
    for(var i = 0; i < elem.length; i++){
        if(typeof elem[i] !== "undefined"){
            elem[i].checked = true;
        }
    }
};

// uncheck all boxes with class c-given ID
function uncheck_boxes(elemID) {
    var elem = document.getElementsByClassName("c-" + elemID);
    for(var i = 0; i < elem.length; i++){
        if(typeof elem[i] !== "undefined"){
            elem[i].checked = false;
        }
    }
};

// if a box of a species is checked/unchecked, it is tested if the checkbox of the corresponding clade has to be checked (if all other species in the clade are checked too)
// or unchecked (if at least one species in a clade is not checked)
function test_boxes(className, boxID) {
    var clickedBoxStatusBeforeClick = document.getElementById(boxID).checked;
    var elem = document.getElementsByClassName('c-' + className);
    var allChecked = true;
    if (clickedBoxStatusBeforeClick == true) {
        allChecked = false;
    }
    for(var i = 0; i < elem.length; i++){
        if(typeof elem[i] !== "undefined"){
            if (elem[i].id != boxID){
                if (elem[i].checked != true) {
                    allChecked = false;
                }
            }
        }
    }
    if (allChecked) {
        var el = document.getElementById(className);
        el.checked = true;
    }
    else {
        var el = document.getElementById(className);
        el.checked = false;
    }
}