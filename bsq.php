<?php

function main($arg){
  $result = [];
  $strtab = open($arg[1]);
  $tab = string_to_array($strtab);
  $size = intval(get_size($tab));
  line_to_array($tab);
  $result = bsq($tab, $size);
  response($tab, $result);
}

function open($file){
  $handle = fopen($file, "r");
  return fread($handle, filesize($file));
}

function string_to_array($string){
  $array = explode("\n", $string);
  return $array;
}

function line_to_array(&$array){
  foreach ($array as &$value) {
    $value = str_split($value);
  }
}

function get_size(&$array){
  $var=$array[0];
  array_shift($array);
  return $var;
}

function bsq($tab, $size){
  $result = [];
  $bsqr_size = 1;
  foreach ($tab as $y => $line) {
    $tab_x = count($line);
    $tab_y = $size;
    foreach ($line as $x => $value) {
      if($value == "o"){
        continue;
      }
      for ($sq_size=$bsqr_size; ($sq_size + $y) < $tab_y && ($sq_size + $x) < $tab_x; $sq_size++) {
        for ($sq_y=0; $sq_y <= $sq_size; $sq_y++) {
          for ($sq_x=0; $sq_x <= $sq_size; $sq_x++) {
            if ($tab[$y+$sq_y][$x+$sq_x]!=".") {
              if ($bsqr_size < $sq_size) {
                $bsqr_size = $sq_size;
                $bsqr_x = $x;
                $bsqr_y = $y;
                $result = [$bsqr_size, $bsqr_x, $bsqr_y];
              }
              break 3;
            }
          }
        }
      }
    }
  }
  return $result;
}

function response($tab, $result){
  foreach ($tab as $y => $line) {
    foreach ($line as $x => $value) {
      if ($result[1] <= $x && $x < $result[0]+$result[1] && $result[2] <= $y && $y < $result[0]+$result[2]){
        echo "x ";
      }
      else{
        echo $value." ";
      }
    }
    echo "\n";
  }
}
main($argv);

?>