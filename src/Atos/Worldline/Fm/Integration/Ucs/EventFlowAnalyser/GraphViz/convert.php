<?php

$files = scandir('Attributes');

$com1=
"/**
 * The table below describes the attributes used by various Graphviz tools.
 * The table gives the name of the attribute, the graph components (node,
 * edge, etc.) which use the attribute and the type of the attribute
 * (strings representing legal values of that type). Where applicable, the table
 * also gives a default value for the attribute, a minimum allowed setting
 * for numeric attributes, and certain restrictions on the use of the attribute.
 */";


foreach ($files as $file) {
    $out = '';
    echo "converting $file\n";
    $in = file_get_contents("Attributes/$file");
    $out = $in;
    
    $out = str_replace("/**\n    * @var double\n    */\n    protected", "protected", $out);
    file_put_contents("tmp/$file", $out);
}

