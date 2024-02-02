// function to view isoform table
function showIsoforms(){
    var inp = document.getElementsByClassName("submit");
    for(var i = 0; i < inp.length; i++){
        inp[i].style.display = "block";
        inp[i].style.textAlign = "right";
    }
    document.getElementById("isoformH").style.display = "block";
    document.getElementById("isoformP").style.display = "block";
    var elem = document.getElementsByClassName("isoTop");
    for(var i = 0; i < elem.length; i++){
        elem[i].style.display = "block";
        elem[i].style.textAlign = "right";
    }
    document.getElementById("isoformT").style.display = "inline-table";
    var top = document.getElementById("isoformH").offsetTop;
    window.scrollTo(0, top - 20); 
};

// function to expand table containing proteins -> shows protein sequence and domain positions
function expandTable(i, sequence, span, id, bId){
    var table = document.getElementById(id);
    var rowId = document.getElementById(i).rowIndex + 1;
    var row = table.insertRow(rowId);
    var cell = row.insertCell(0);
    cell.setAttribute("colspan", span);
    cell.setAttribute("style", "word-wrap: break-word; text-align:left; font-family: \"Courier New\", Courier, monospace;");
    sequence = sequence.replace(/quotes/g, '\'');
    cell.innerHTML = sequence;
    var button = document.getElementById(bId);
    button.innerHTML = '-';
    var script = button.getAttribute('onclick').replace("expand", "collapse");
    button.setAttribute( "onClick", script );
};

// function to hide what expandTable shows
function collapseTable(i, sequence, span, id, bId){
    var table = document.getElementById(id);
    var rowId = document.getElementById(i).rowIndex + 1;
    table.deleteRow(rowId);
    var button = document.getElementById(bId);
    button.innerHTML = '+';
    var script = button.getAttribute('onclick').replace("collapse", "expand");
    button.setAttribute( "onClick", script );
};

// show all protein sequences and domain positions
function show_all_sequences(table_id) {
    var buttons = document.getElementsByClassName("expander");
    for(var i = 0; i < buttons.length; i++){
        var click = buttons[i].getAttribute('onclick');
        var split_var = click.split(", '");
        var id = split_var[2].replace(/\'$/gm,'');
        if(id == table_id && click.indexOf("expand") != -1){  // perform onclick functions of buttons
            buttons[i].onclick.apply(buttons[i]);
        }
        else{
            console.log(id + " == " + table_id);
        }
    }
};

// collapse all protein sequences and domain positions
function hide_all_sequences(table_id) {
    var buttons = document.getElementsByClassName("expander");
    for(var i = 0; i < buttons.length; i++){
        var click = buttons[i].getAttribute('onclick');
        var split_var = click.split(", '");
        var id = split_var[2].replace(/\'$/gm,'');
        if(id == table_id && click.indexOf("collapse") != -1){  // perform onclick functions of buttons
            buttons[i].onclick.apply(buttons[i]);
        }
    }
}