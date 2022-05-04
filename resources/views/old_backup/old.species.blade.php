<?php
$title = "Species view";
$active = "speciesView";

include "db_info.php";
include "header_top.php";
include "header_ie_comp.php";
include "header_robots_none.php";
include "header_bottom.php";
include $prefix."print_species.php";
include $prefix."print_tree_parts.php";

echo '<h1>TAP species view</h1>';

// print small overview tree on top of the page
echo 'This overview is organized as follows (layers are printed if there are any):<br />
      <table cellspacing="0" cellpadding="0" style="margin-top:5px;">
      <tr class="kingdom">
        <td>
            <img alt="1st level" style="display:block; margin-bottom:1px; margin-right:2px; padding-bottom:0px;" src="'.$prefix.'img/03.png" height="26px"></img>
        </td>
        <td>
            Kingdom/Super group
        </td>
      </tr>
      </table>
      <table cellspacing="0" cellpadding="0">
      <tr class="clade">
        <td>
            <img alt="2nd level" style="display:block; margin-bottom:1px; margin-right:2px; padding-bottom:0px;" src="'.$prefix.'img/empty.png" height="26px"></img>
        </td>
        <td>
            <img style="display:block; margin-bottom:1px; margin-right:2px; padding-bottom:0px;" src="'.$prefix.'img/03.png" height="26px"></img>
        </td>
        <td>
            Clade/Phylum
        </td>
      </tr>
      </table>
      <table cellspacing="0" cellpadding="0">
      <tr class="supergroup">
        <td>
            <img alt="3rd level" style="display:block; margin-bottom:1px; margin-right:2px; padding-bottom:0px;" src="'.$prefix.'img/empty.png" height="26px"></img>
        </td>
        <td>
            <img style="display:block; margin-bottom:1px; margin-right:2px; padding-bottom:0px;" src="'.$prefix.'img/empty.png" height="26px"></img>
        </td>
        <td>
            <img style="display:block; margin-bottom:1px; margin-right:2px; padding-bottom:0px;" src="'.$prefix.'img/03.png" height="26px"></img>
        </td>
        <td>
            Supergroup
        </td>
      </tr>
      </table>
      <table cellspacing="0" cellpadding="0">
      <tr class="order">
        <td>
            <img alt="4th level" style="display:block; margin-bottom:1px; margin-right:2px; padding-bottom:0px;" src="'.$prefix.'img/empty.png" height="26px"></img>
        </td>
        <td>
            <img style="display:block; margin-bottom:1px; margin-right:2px; padding-bottom:0px;" src="'.$prefix.'img/empty.png" height="26px"></img>
        </td>
        <td>
            <img style="display:block; margin-bottom:1px; margin-right:2px; padding-bottom:0px;" src="'.$prefix.'img/empty.png" height="26px"></img>
        </td>
        <td>
            <img style="display:block; margin-bottom:1px; margin-right:2px; padding-bottom:0px;" src="'.$prefix.'img/03.png" height="26px"></img>
        </td>
        <td>
            Order
        </td>
      </tr>
      </table>
      <table cellspacing="0" cellpadding="0">
      <tr class="family">
        <td>
            <img alt="5th level" style="display:block; margin-bottom:1px; margin-right:2px; padding-bottom:0px;" src="'.$prefix.'img/empty.png" height="26px"></img>
        </td>
        <td>
            <img style="display:block; margin-bottom:1px; margin-right:2px; padding-bottom:0px;" src="'.$prefix.'img/empty.png" height="26px"></img>
        </td>
        <td>
            <img style="display:block; margin-bottom:1px; margin-right:2px; padding-bottom:0px;" src="'.$prefix.'img/empty.png" height="26px"></img>
        </td>
        <td>
            <img style="display:block; margin-bottom:1px; margin-right:2px; padding-bottom:0px;" src="'.$prefix.'img/empty.png" height="26px"></img>
        </td>
        <td>
            <img style="display:block; margin-bottom:1px; margin-right:2px; padding-bottom:0px;" src="'.$prefix.'img/03.png" height="26px"></img>
        </td>
        <td>
            Family
        </td>
      </tr>
      </table>
      <table cellspacing="0" cellpadding="0">
      <tr>
        <td>
            <img alt="6th level with link" style="display:block; margin-bottom:1px; margin-right:2px; padding-bottom:0px;" src="'.$prefix.'img/empty.png" height="26px"></img>
        </td>
        <td>
            <img style="display:block; margin-bottom:1px; margin-right:2px; padding-bottom:0px;" src="'.$prefix.'img/empty.png" height="26px"></img>
        </td>
        <td>
            <img style="display:block; margin-bottom:1px; margin-right:2px; padding-bottom:0px;" src="'.$prefix.'img/empty.png" height="26px"></img>
        </td>
        <td>
            <img style="display:block; margin-bottom:1px; margin-right:2px; padding-bottom:0px;" src="'.$prefix.'img/empty.png" height="26px"></img>
        </td>
        <td>
            <img style="display:block; margin-bottom:1px; margin-right:2px; padding-bottom:0px;" src="'.$prefix.'img/empty.png" height="26px"></img>
        </td>
        <td>
            <img style="display:block; margin-bottom:1px; margin-right:2px; padding-bottom:0px;" src="'.$prefix.'img/03.png" height="26px"></img>
        </td>
        <td>
            <i>Species</i>
        </td>
      </tr>
      </table>
      <hr>';

# print a warning if using the internal version
if(isset($secret) && $secret == "e9!<tFx_y3aSkZ4XUYWh\MSFt"){
    echo '<b><span style="color:#ff2654">WARNING: </span>You are currently using the internal TAPscan version, so be aware that it contains unpublished information!</b><br></br>';
}

// add hide/show all "buttons"
echo '<span onclick="hide_all(\''.$prefix.'\')" class="clickable">hide all</span> | <span onclick="show_all(\''.$prefix.'\')" class="clickable"> show all</span><br></br>';

// start printing species table
echo '<table class="speciestable" cellspacing="0" cellpadding="0">';

if(isset($secret) && $secret == "e9!<tFx_y3aSkZ4XUYWh\MSFt"){
    // print data for all kingdoms for internal version
    $sql = "SELECT name, id, order_number, num_species_all as num_species FROM Kingdom WHERE 1";
}
else{
    // to change if more than Archeaplastida should be shown
    $sql = "SELECT name, id, order_number, num_species FROM Kingdom WHERE name = 'Archaeplastida'";
}

$i = 0;  // initialize kingdom counter
$res = $conn->query($sql);
$result = $res->fetchAll();
$len = count($result);  // set number of kingdoms
$start = "i";
$kingdoms = [];
foreach($result as $row){
    $kingdoms[$row['order_number']] = [$row['name'], $row['id'], $row['num_species']];
}
unset($row);
ksort($kingdoms, SORT_NUMERIC);  // sort kingdoms according to order number

// set short names needed later for class names
$kingd = "k";
$clad = "c";
$ord = "o";
$fam = "f";
$sgroup_n2 = "sg";

foreach($kingdoms as $row){
    $i++;  // increase kingdom counter
    print_kingdom($conn, $row, $kingd, $i, $len, $prefix);  // print kingdom
    //print clades
    // get clade data
    $sql = "SELECT name, id, order_number, num_species, num_species_all FROM Clade WHERE kingdom_id = '$row[1]'";
    $res = $conn->query($sql);
    $result = $res->fetchAll();
    // save clase data
    $clades = [];
    foreach($result as $rowC){
        $clades[$rowC['order_number']] = [$rowC['name'], $rowC['id'], $rowC['num_species'], $rowC['num_species_all']];
    }
    unset($rowC);
    ksort($clades, SORT_NUMERIC);  // sort clades according to order number
    $j = 0;
    $clade_len = count($clades);
    foreach($clades as $key => $value){
        $j++;  // increase clade counter
        // get supergroup information
        $sql = "SELECT name, id, order_number, num_species, num_species_all FROM Supergroup2 WHERE clade_id = '$value[1]'";
        $res = $conn->query($sql);
        $result = $res->fetchAll();
        // save supergorup information
        $sgroup2 = [];
        foreach($result as $rowSg){
            $sgroup2[$rowSg['order_number']] = [$rowSg['name'], $rowSg['id'], $rowSg['num_species'], $rowSg['num_species_all']];
        }
        unset($rowSg);
        ksort($sgroup2, SORT_NUMERIC);  // sort supergroups according to order number
        $sgroup2Len = count($sgroup2);
        if($value[3] == 1){  // if the clase contains only one species at all
            // immediately print clade with whole tree
            if(isset($secret) && $secret == "e9!<tFx_y3aSkZ4XUYWh\MSFt"){
                print_clade_single($value, $kingd, $i, $len, $clad, $j, $sgroup2[array_keys($sgroup2)[0]], $conn, $clade_len, $value[2], $prefix, True);
            }
            else{
                print_clade_single($value, $kingd, $i, $len, $clad, $j, $sgroup2[array_keys($sgroup2)[0]], $conn, $clade_len, $value[2], $prefix, False);
            }
        }
        else{  // if clade contains more than one species
            // print clade
            if(isset($secret) && $secret == "e9!<tFx_y3aSkZ4XUYWh\MSFt"){
                print_clade($value, $kingd, $i, $len, $clad, $j, $clade_len, $prefix, True);
            }
            else{
                print_clade($value, $kingd, $i, $len, $clad, $j, $clade_len, $prefix, False);
            }
            // print 3rd level
            $k = 0;  // initialize supergorup counter
            $contains_placeholder = False;  // tells if supergroup list contains supergroup which is a placeholder
            $any_supergroup = False;  // tells if supergroup list contains minimum 1 supergroup which is not placeholder
            // set $any_supergroup and $contains_placeholder
            foreach($sgroup2 as $skey => $svalue){
                if(False !== strpos($svalue[0], 'XX')){
                    $contains_placeholder = True;
                }
                else{
                    $any_supergroup = True;
                }
            }
            unset($svalue);
            // for each supergroup
            foreach($sgroup2 as $skey => $svalue){
                $k++;  // increase supergroup counter
                if(false === strpos($svalue[0], 'XX')){  // if name of supergroup2 is no placeholder -> print supergroup2
                    if($svalue[3] == 1){  // if supergroup contains only one species
                        if(isset($secret) && $secret == "e9!<tFx_y3aSkZ4XUYWh\MSFt"){
                            print_supergroup2_single($clad, $i, $j, $kingd, $conn, $svalue, $k, $sgroup2Len, $clade_len, $len, $svalue[2], $prefix, True);
                        }
                        else{
                            print_supergroup2_single($clad, $i, $j, $kingd, $conn, $svalue, $k, $sgroup2Len, $clade_len, $len, $svalue[2], $prefix, False);
                        }
                    }
                    else{  // if supergroup contains more than one species
                        if(isset($secret) && $secret == "e9!<tFx_y3aSkZ4XUYWh\MSFt"){
                            print_supergroup2($svalue, $kingd, $i, $len, $clad, $j, $clade_len, $sgroup_n2, $k, $sgroup2Len, $prefix, True);
                        }
                        else{
                            print_supergroup2($svalue, $kingd, $i, $len, $clad, $j, $clade_len, $sgroup_n2, $k, $sgroup2Len, $prefix, False);
                        }
                        $orderData = get_order_data($conn, $svalue[1]);
                        $order_len = count($orderData);
                        $l = 0;  // initialize order counter
                        $any_order = False;  // tells if there is any order in the list which is no placeholder
                        foreach($orderData as $order_ordNum => $orderValue){
                            if(false === strpos($orderValue[0], 'XX')){
                                $any_order = True;
                            }
                        }
                        foreach($orderData as $order_ordNum => $orderValue){
                            $l++;  // increase order counter
                            if(false === strpos($orderValue[0], 'XX')){  // if order name is no placeholder
                                // print order under sgroup2
                                if($orderValue[3] == 1){  // if order contains only one species
                                    $table_string = '<table class="speciestable hidden '.$sgroup_n2.'-'.$i.'-'.$j.'-'.$k.
                                                        ' hide-'.$kingd.'-'.$i.
                                                        ' hide-'.$clad.'-'.$i.'-'.$j.
                                                        ' hide-'.$sgroup_n2.'-'.$i.'-'.$j.'-'.$k.
                                                        '" cellspacing="0" cellpadding="0" style="display:none;">';
                                    if(isset($secret) && $secret == "e9!<tFx_y3aSkZ4XUYWh\MSFt"){
                                        print_order_single($orderValue, $conn, $sgroup_n2, $i, $j, $k, $kingd, $clad, $len, $clade_len, $sgroup2Len,
                                                           $l, $order_len, $table_string, False, $orderValue[2], $any_supergroup, $prefix, True);
                                    }
                                    else{
                                        print_order_single($orderValue, $conn, $sgroup_n2, $i, $j, $k, $kingd, $clad, $len, $clade_len, $sgroup2Len,
                                                           $l, $order_len, $table_string, False, $orderValue[2], $any_supergroup, $prefix, False);
                                    }
                                }
                                else{
                                    if(isset($secret) && $secret == "e9!<tFx_y3aSkZ4XUYWh\MSFt"){
                                        print_order(1, $orderValue, $kingd, $i, $len, $clad, $j, $clade_len, $sgroup_n2, $k, $sgroup2Len,
                                                    $ord, $l, $order_len, $contains_placeholder, $any_supergroup, $prefix, True);
                                    }
                                    else{
                                        print_order(1, $orderValue, $kingd, $i, $len, $clad, $j, $clade_len, $sgroup_n2, $k, $sgroup2Len,
                                                    $ord, $l, $order_len, $contains_placeholder, $any_supergroup, $prefix, False);
                                    }
                                    $familyData = get_family_data($conn, $orderValue[1]);
                                    $family_len = count($familyData);
                                    $m = 0;  // initialize family counter
                                    foreach($familyData as $family_ordNum => $familyValue){
                                        $m++;  // increase family counter
                                        if(false === strpos($familyValue[0], 'XX')){
                                            $speciesData = get_species_data($conn, $familyValue[1]);
                                            $species_len = count($speciesData);
                                            if($familyValue[3] == 1){
                                                $tree_string = '<table class="speciestable hidden '.$ord.'-'.$i.'-'.$j.'-'.$k.'-'.$l.
                                                                ' hide-'.$kingd.'-'.$i.
                                                                ' hide-'.$clad.'-'.$i.'-'.$j.
                                                                ' hide-'.$sgroup_n2.'-'.$i.'-'.$j.'-'.$k.
                                                                ' hide-'.$ord.'-'.$i.'-'.$j.'-'.$k.'-'.$l.
                                                                '" cellspacing="0" cellpadding="0" style="display:none;">';
                                                if(isset($secret) && $secret == "e9!<tFx_y3aSkZ4XUYWh\MSFt"){
                                                    print_fam_and_spec_immediately($familyValue, $speciesData[array_keys($speciesData)[0]], $ord, $i, $j,
                                                                                   $k, $l, $kingd, $clad, $sgroup_n2, $len, $clade_len, $m, $family_len,
                                                                                   $sgroup2Len, $order_len, $tree_string, False, $familyValue[2], $any_supergroup,
                                                                                   $any_order, $prefix, True);
                                                }
                                                else{
                                                    print_fam_and_spec_immediately($familyValue, $speciesData[array_keys($speciesData)[0]], $ord, $i, $j,
                                                                                   $k, $l, $kingd, $clad, $sgroup_n2, $len, $clade_len, $m, $family_len,
                                                                                   $sgroup2Len, $order_len, $tree_string, False, $familyValue[2], $any_supergroup,
                                                                                   $any_order, $prefix, False);
                                                }
                                            }
                                            else{
                                                if(isset($secret) && $secret == "e9!<tFx_y3aSkZ4XUYWh\MSFt"){
                                                    print_family(3, $familyValue, $kingd, $i, $len, $clad, $j, $clade_len, $sgroup_n2, $k, $sgroup2Len,
                                                                 $ord, $l, $order_len, $fam, $m, $family_len, $contains_placeholder, $any_supergroup, $prefix, True);
                                                }
                                                else{
                                                    print_family(3, $familyValue, $kingd, $i, $len, $clad, $j, $clade_len, $sgroup_n2, $k, $sgroup2Len,
                                                                 $ord, $l, $order_len, $fam, $m, $family_len, $contains_placeholder, $any_supergroup, $prefix, False);
                                                }
                                                $n = 0;  // initialize species counter
                                                foreach($speciesData as $spec_OrdNum => $specResults){
                                                    $n++;  // increase species counter
                                                    if(isset($secret) && $secret == "e9!<tFx_y3aSkZ4XUYWh\MSFt"){
                                                        print_species_table(7, 7, $specResults, $kingd, $i, $len, $clad, $j, $clade_len, $sgroup_n2, $k, $sgroup2Len, $ord, $l, $order_len,
                                                                            $fam, $m, $family_len, $n, $species_len, $contains_placeholder, $any_supergroup, $prefix, True);
                                                    }
                                                    else{
                                                        print_species_table(7, 7, $specResults, $kingd, $i, $len, $clad, $j, $clade_len, $sgroup_n2, $k, $sgroup2Len, $ord, $l, $order_len,
                                                                            $fam, $m, $family_len, $n, $species_len, $contains_placeholder, $any_supergroup, $prefix, False);
                                                    }
                                                }
                                                unset($specResults);
                                            }
                                        }
                                        else{
                                            $speciesData = get_species_data($conn, $familyValue[1]);
                                            $species_len = count($speciesData);
                                            $n = 0;  // initialize species counter
                                            foreach($speciesData as $spec_OrdNum => $specResults){
                                                $n++;  // increase species counter
                                                if(isset($secret) && $secret == "e9!<tFx_y3aSkZ4XUYWh\MSFt"){
                                                    print_species_table(6, 6, $specResults, $kingd, $i, $len, $clad, $j, $clade_len, $sgroup_n2, $k, $sgroup2Len, $ord, $l, $order_len, $fam, $m,
                                                                        $family_len, $n, $species_len, $contains_placeholder, $any_supergroup, $prefix, True);
                                                }
                                                else{
                                                    print_species_table(6, 6, $specResults, $kingd, $i, $len, $clad, $j, $clade_len, $sgroup_n2, $k, $sgroup2Len, $ord, $l, $order_len, $fam, $m,
                                                                        $family_len, $n, $species_len, $contains_placeholder, $any_supergroup, $prefix, False);
                                                }
                                            }
                                            unset($specResults);
                                        }
                                    }
                                    unset($familyValue);
                                }
                            }
                            else{
                                $familyData = get_family_data($conn, $orderValue[1]);
                                $family_len = count($familyData);
                                $m = 0;  //  initialize family counter
                                foreach($familyData as $family_ordNum => $familyValue){
                                    $m++;  // increase family counter
                                    if(false === strpos($familyValue[0], 'XX')){
                                        $speciesData = get_species_data($conn, $familyValue[1]);
                                        $species_len = count($speciesData);
                                        if($familyValue[3] == 1){
                                            $tree_string = '<table class="speciestable hidden '.$sgroup_n2.'-'.$i.'-'.$j.'-'.$k.
                                                           ' hide-'.$kingd.'-'.$i.
                                                           ' hide-'.$clad.'-'.$i.'-'.$j.
                                                           ' hide-'.$sgroup_n2.'-'.$i.'-'.$j.'-'.$k.
                                                           '" cellspacing="0" cellpadding="0" style="display:none;">';
                                            if(isset($secret) && $secret == "e9!<tFx_y3aSkZ4XUYWh\MSFt"){
                                                print_fam_and_spec_immediately($familyValue, $speciesData[array_keys($speciesData)[0]], $ord, $i, $j,
                                                                                   $k, $l, $kingd, $clad, $sgroup_n2, $len, $clade_len, $m, $family_len,
                                                                                   $sgroup2Len, $order_len, $tree_string, True, $familyValue[2], $any_supergroup,
                                                                                   $any_order, $prefix, True);
                                            }
                                            else{
                                                print_fam_and_spec_immediately($familyValue, $speciesData[array_keys($speciesData)[0]], $ord, $i, $j,
                                                                                   $k, $l, $kingd, $clad, $sgroup_n2, $len, $clade_len, $m, $family_len,
                                                                                   $sgroup2Len, $order_len, $tree_string, True, $familyValue[2], $any_supergroup,
                                                                                   $any_order, $prefix, False);
                                            }
                                        }
                                        else{
                                            if(isset($secret) && $secret == "e9!<tFx_y3aSkZ4XUYWh\MSFt"){
                                                print_family(2, $familyValue, $kingd, $i, $len, $clad, $j, $clade_len, $sgroup_n2, $k, $sgroup2Len, $ord,
                                                             $l, $order_len, $fam, $m, $family_len, $contains_placeholder, $any_supergroup, $prefix, True);
                                            }
                                            else{
                                                print_family(2, $familyValue, $kingd, $i, $len, $clad, $j, $clade_len, $sgroup_n2, $k, $sgroup2Len, $ord,
                                                             $l, $order_len, $fam, $m, $family_len, $contains_placeholder, $any_supergroup, $prefix, False);
                                            }
                                            $n = 0;  // initialize species counter
                                            foreach($speciesData as $spec_OrdNum => $specResults){
                                                $n++;  // increase species counter
                                                if(isset($secret) && $secret == "e9!<tFx_y3aSkZ4XUYWh\MSFt"){
                                                    print_species_table(5, 5, $specResults, $kingd, $i, $len, $clad, $j, $clade_len, $sgroup_n2, $k, $sgroup2Len, $ord, $l, $order_len, $fam, $m,
                                                                        $family_len, $n, $species_len, $contains_placeholder, $any_supergroup, $prefix, True);
                                                }
                                                else{
                                                    print_species_table(5, 5, $specResults, $kingd, $i, $len, $clad, $j, $clade_len, $sgroup_n2, $k, $sgroup2Len, $ord, $l, $order_len, $fam, $m,
                                                                        $family_len, $n, $species_len, $contains_placeholder, $any_supergroup, $prefix, False);
                                                }
                                            }
                                            unset($specResults);
                                        }
                                    }
                                    else{
                                        $speciesData = get_species_data($conn, $familyValue[1]);
                                        $species_len = count($speciesData);
                                        $n = 0;  // initialize species counter
                                        foreach($speciesData as $spec_OrdNum => $specResults){
                                            $n++;  // increase species counter
                                            if(isset($secret) && $secret == "e9!<tFx_y3aSkZ4XUYWh\MSFt"){
                                                print_species_table(4, 4, $specResults, $kingd, $i, $len, $clad, $j, $clade_len, $sgroup_n2, $k, $sgroup2Len, $ord, $l, $order_len, $fam, $m, $family_len,
                                                                    $n, $species_len, $contains_placeholder, $any_supergroup, $prefix, True);
                                            }
                                            else{
                                                print_species_table(4, 4, $specResults, $kingd, $i, $len, $clad, $j, $clade_len, $sgroup_n2, $k, $sgroup2Len, $ord, $l, $order_len, $fam, $m, $family_len,
                                                                    $n, $species_len, $contains_placeholder, $any_supergroup, $prefix, False);
                                            }
                                        }
                                        unset($specResults);
                                    }
                                }
                                unset($familyValue);
                            }
                        }
                        unset($orderValue);
                    }
                }
                else{  // if there is no supergroup2
                    $orderData = get_order_data($conn, $svalue[1]);
                    $order_len = count($orderData);
                    $l = 0;  // initialize order counter
                    $any_order = False;  // variable to tell if there is any order in the list which is no placeholder
                    foreach($orderData as $order_ordNum => $orderValue){
                        if(false === strpos($orderValue[0], 'XX')){
                            $any_order = True;
                        }
                    }
                    foreach($orderData as $order_ordNum => $orderValue){
                        $l++;  // increase order counter
                        if(false === strpos($orderValue[0], 'XX')){
                            // print order parallel to sgroup2
                            if($orderValue[3] == 1){  // if there is only one species in the order
                                $table_string = '<table class="speciestable hidden '.$clad.'-'.$i.'-'.$j.
                                                ' hide-'.$kingd.'-'.$i.
                                                ' hide-'.$clad.'-'.$i.'-'.$j.
                                                '" cellspacing="0" cellpadding="0" style="display:none;">';
                                if(isset($secret) && $secret == "e9!<tFx_y3aSkZ4XUYWh\MSFt"){
                                    print_order_single($orderValue, $conn, $sgroup_n2, $i, $j, $k, $kingd, $clad, $len, $clade_len, $sgroup2Len,
                                                       $l, $order_len, $table_string, True, $orderValue[2], $any_supergroup, $prefix, True);
                                }
                                else{
                                    print_order_single($orderValue, $conn, $sgroup_n2, $i, $j, $k, $kingd, $clad, $len, $clade_len, $sgroup2Len,
                                                       $l, $order_len, $table_string, True, $orderValue[2], $any_supergroup, $prefix, False);
                                }
                            }
                            else{
                                if(isset($secret) && $secret == "e9!<tFx_y3aSkZ4XUYWh\MSFt"){
                                    print_order(0, $orderValue, $kingd, $i, $len, $clad, $j, $clade_len, $sgroup_n2, $k, $sgroup2Len, $ord,
                                                $l, $order_len, $contains_placeholder, $any_supergroup, $prefix, True);
                                }
                                else{
                                    print_order(0, $orderValue, $kingd, $i, $len, $clad, $j, $clade_len, $sgroup_n2, $k, $sgroup2Len, $ord,
                                                $l, $order_len, $contains_placeholder, $any_supergroup, $prefix, False);
                                }
                                $familyData = get_family_data($conn, $orderValue[1]);
                                $family_len = count($familyData);
                                $m = 0;  // initialize family counter
                                foreach($familyData as $family_ordNum => $familyValue){
                                    $m++;  // increase family counter
                                    $speciesData = get_species_data($conn, $familyValue[1]);
                                    if(false === strpos($familyValue[0], 'XX')){
                                        if($familyValue[3] == 1){
                                            $tree_string = '<table class="speciestable hidden '.$ord.'-'.$i.'-'.$j.'-'.$k.'-'.$l.
                                                            ' hide-'.$kingd.'-'.$i.
                                                            ' hide-'.$clad.'-'.$i.'-'.$j.
                                                            ' hide-'.$ord.'-'.$i.'-'.$j.'-'.$k.'-'.$l.
                                                            '" cellspacing="0" cellpadding="0" style="display:none;">';
                                            if(isset($secret) && $secret == "e9!<tFx_y3aSkZ4XUYWh\MSFt"){
                                                print_fam_and_spec_immediately($familyValue, $speciesData[array_keys($speciesData)[0]], $ord, $i, $j,
                                                                                   $k, $l, $kingd, $clad, $sgroup_n2, $len, $clade_len, $m, $family_len,
                                                                                   $sgroup2Len, $order_len, $tree_string, True, $familyValue[2], $any_supergroup,
                                                                                   $any_order, $prefix, True);
                                            }
                                            else{
                                                print_fam_and_spec_immediately($familyValue, $speciesData[array_keys($speciesData)[0]], $ord, $i, $j,
                                                                                   $k, $l, $kingd, $clad, $sgroup_n2, $len, $clade_len, $m, $family_len,
                                                                                   $sgroup2Len, $order_len, $tree_string, True, $familyValue[2], $any_supergroup,
                                                                                   $any_order, $prefix, False);
                                            }
                                        }
                                        else{
                                            if(isset($secret) && $secret == "e9!<tFx_y3aSkZ4XUYWh\MSFt"){
                                                print_family(1, $familyValue, $kingd, $i, $len, $clad, $j, $clade_len, $sgroup_n2, $k, $sgroup2Len, $ord,
                                                             $l, $order_len, $fam, $m, $family_len, $contains_placeholder, $any_supergroup, $prefix, True);
                                            }
                                            else{
                                                print_family(1, $familyValue, $kingd, $i, $len, $clad, $j, $clade_len, $sgroup_n2, $k, $sgroup2Len, $ord,
                                                             $l, $order_len, $fam, $m, $family_len, $contains_placeholder, $any_supergroup, $prefix, False);
                                            }
                                            $species_len = count($speciesData);
                                            $n = 0;  // initialize species counter
                                            foreach($speciesData as $spec_OrdNum => $specResults){
                                                $n++;  // increase species counter
                                                if(isset($secret) && $secret == "e9!<tFx_y3aSkZ4XUYWh\MSFt"){
                                                    print_species_table(3, 3, $specResults, $kingd, $i, $len, $clad, $j, $clade_len, $sgroup_n2, $k,
                                                                        $sgroup2Len, $ord, $l, $order_len, $fam, $m, $family_len, $n, $species_len,
                                                                        $contains_placeholder, $any_supergroup, $prefix, True);
                                                }
                                                else{
                                                    print_species_table(3, 3, $specResults, $kingd, $i, $len, $clad, $j, $clade_len, $sgroup_n2, $k,
                                                                        $sgroup2Len, $ord, $l, $order_len, $fam, $m, $family_len, $n, $species_len,
                                                                        $contains_placeholder, $any_supergroup, $prefix, False);
                                                }
                                            }
                                            unset($specResults);
                                        }
                                    }
                                    else{
                                        $speciesData = get_species_data($conn, $familyValue[1]);
                                        $species_len = count($speciesData);
                                        $n = 0;  // initialize species counter
                                        foreach($speciesData as $spec_OrdNum => $specResults){
                                            $n++;  // increase species counter
                                            if(isset($secret) && $secret == "e9!<tFx_y3aSkZ4XUYWh\MSFt"){
                                                print_species_table(2, 2, $specResults, $kingd, $i, $len, $clad, $j, $clade_len, $sgroup_n2, $k, $sgroup2Len,
                                                                    $ord, $l, $order_len, $fam, $m, $family_len, $n, $species_len, $contains_placeholder,
                                                                    $any_supergroup, $prefix, True);
                                            }
                                            else{
                                                print_species_table(2, 2, $specResults, $kingd, $i, $len, $clad, $j, $clade_len, $sgroup_n2, $k, $sgroup2Len,
                                                                    $ord, $l, $order_len, $fam, $m, $family_len, $n, $species_len, $contains_placeholder,
                                                                    $any_supergroup, $prefix, False);
                                            }
                                        }
                                        unset($specResults);
                                    }
                                }
                                unset($familyValue);
                            }
                        }
                        else{  // if there is no order
                            $familyData = get_family_data($conn, $orderValue[1]);
                            $family_len = count($familyData);
                            $m = 0;  // initialize family counter
                            foreach($familyData as $family_ordNum => $familyValue){
                                $m++;  // increase family counter
                                if(false === strpos($familyValue[0], 'XX')){
                                    $speciesData = get_species_data($conn, $familyValue[1]);
                                    if($familyValue[3] == 1){
                                        $tree_string = '<table class="speciestable hidden '.$clad.'-'.$i.'-'.$j.
                                                        ' hide-'.$kingd.'-'.$i.
                                                        ' hide-'.$clad.'-'.$i.'-'.$j.
                                                        '" cellspacing="0" cellpadding="0" style="display:none;">';
                                        if(isset($secret) && $secret == "e9!<tFx_y3aSkZ4XUYWh\MSFt"){
                                            print_fam_and_spec_immediately($familyValue, $speciesData[array_keys($speciesData)[0]], $ord, $i, $j,
                                                                                   $k, $l, $kingd, $clad, $sgroup_n2, $len, $clade_len, $m, $family_len,
                                                                                   $sgroup2Len, $order_len, $tree_string, True, $familyValue[2], $any_supergroup,
                                                                                   $any_order, $prefix, True);
                                        }
                                        else{
                                            print_fam_and_spec_immediately($familyValue, $speciesData[array_keys($speciesData)[0]], $ord, $i, $j,
                                                                                   $k, $l, $kingd, $clad, $sgroup_n2, $len, $clade_len, $m, $family_len,
                                                                                   $sgroup2Len, $order_len, $tree_string, True, $familyValue[2], $any_supergroup,
                                                                                   $any_order, $prefix, False);
                                        }
                                    }
                                    else{
                                        if(isset($secret) && $secret == "e9!<tFx_y3aSkZ4XUYWh\MSFt"){
                                            print_family(0, $familyValue, $kingd, $i, $len, $clad, $j, $clade_len, $sgroup_n2, $k, $sgroup2Len, $ord,
                                                         $l, $order_len, $fam, $m, $family_len, $contains_placeholder, $any_supergroup, $prefix, True);
                                        }
                                        else{
                                            print_family(0, $familyValue, $kingd, $i, $len, $clad, $j, $clade_len, $sgroup_n2, $k, $sgroup2Len, $ord,
                                                         $l, $order_len, $fam, $m, $family_len, $contains_placeholder, $any_supergroup, $prefix, False);
                                        }
                                        $species_len = count($speciesData);
                                        $n = 0;  // initialize species counter
                                        foreach($speciesData as $spec_OrdNum => $specResults){
                                            $n++;  // increase species counter
                                            if(isset($secret) && $secret == "e9!<tFx_y3aSkZ4XUYWh\MSFt"){
                                                print_species_table(1, 1, $specResults, $kingd, $i, $len, $clad, $j, $clade_len, $sgroup_n2, $k, $sgroup2Len,
                                                                    $ord, $l, $order_len, $fam, $m, $family_len, $n, $species_len, $contains_placeholder,
                                                                    $any_supergroup, $prefix, True);
                                            }
                                            else{
                                                print_species_table(1, 1, $specResults, $kingd, $i, $len, $clad, $j, $clade_len, $sgroup_n2, $k, $sgroup2Len,
                                                                    $ord, $l, $order_len, $fam, $m, $family_len, $n, $species_len, $contains_placeholder,
                                                                    $any_supergroup, $prefix, False);
                                            }
                                        }
                                        unset($specResults);
                                    }
                                }
                                else{
                                    $speciesData = get_species_data($conn, $familyValue[1]);
                                    $species_len = count($speciesData);
                                    $n = 0;  // initialize species counter
                                    foreach($speciesData as $spec_OrdNum => $specResults){
                                        $n++;  // increase species counter
                                        if(isset($secret) && $secret == "e9!<tFx_y3aSkZ4XUYWh\MSFt"){
                                            print_species_table(0, 0, $specResults, $kingd, $i, $len, $clad, $j, $clade_len, $sgroup_n2, $k, $sgroup2Len, $ord,
                                                                $l, $order_len, $fam, $m, $family_len, $n, $species_len, $contains_placeholder, $any_supergroup, $prefix, True);
                                        }
                                        else{
                                            print_species_table(0, 0, $specResults, $kingd, $i, $len, $clad, $j, $clade_len, $sgroup_n2, $k, $sgroup2Len, $ord,
                                                                $l, $order_len, $fam, $m, $family_len, $n, $species_len, $contains_placeholder, $any_supergroup, $prefix, False);
                                        }
                                    }
                                    unset($specResults);
                                }
                            }
                            unset($familyValue);
                        }
                    }
                    unset($orderValue);
                }
            }
            unset($svalue);
        }
    }
    unset($value);
}
unset($row);

echo      '</table>';
echo '<script src="'.$prefix.'js/expand_tree.js"></script>';
include $prefix."logging.php";
include $prefix."footer.php";
?>
