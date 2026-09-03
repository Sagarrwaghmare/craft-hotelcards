<?php



function numhash($n) {

    // return $n;
    return (((0x0000FFFF & $n) << 16) + ((0xFFFF0000 & $n) >> 16));


}

// function numhash($n) {
//     return (((0x0000FFFF & $n) << 16) + ((0xFFFF0000 & $n) >> 16));
// }

// print_r(numhash($id));
// echo "<br>";
// print_r(numhash(numhash($id)));


// $this->load->library('encryption');
// $key = $this->encryption->create_key(16);
// print_r(bin2hex(($key)));
// $ciphertext = $this->encryption->encrypt($id);