<?php

/**
 * formatPrice
 *
 * @param  mixed $str
 * @return void
 */
function formatPrice($str) {
  return 'Rp. ' . number_format($str, '0', '', '.');
}

function delete_comma($str) {
  return str_replace(',', '', $str);
}