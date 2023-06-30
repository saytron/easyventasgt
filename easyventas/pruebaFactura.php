<?php 
$mainstr = "SALVADOR,BERNAL,,MARIA,DEL CARMEN";
$replacestr = remove_sp_chr($mainstr);
function remove_sp_chr($str)
{
    $result = str_replace(array("#", ",", ";"), ' ', $str);
    echo  $result;
}
?>
<script>
   var str = "SALVADOR BERNAL MARIA DEL CARMEN";
let str2 = str.replace(/[^a-zA-Z 0-9.]+/g,' ');


alert(str2);
</script>