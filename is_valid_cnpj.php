<?php

/**
 * Check if CNJP (Cadastro Nacional de Pessoa Jurídica) is valid.
 *
 * @param string $cnpj The CNPJ number.
 * @return bool
 */
function is_valid_cnpj($cnpj)
{
	// Only numbers
	$cnpj = preg_replace('/\D/', '', $cnpj);
	
	if ( strlen($cnpj) != 14 OR preg_match('/(\d)\1{13}/', $cnpj) ) {
		return false;
	}
	
	$weights = array(6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2);
	
	$sum = 0;
	
	for ( $i = 1; $i < 13; ++$i ) {
		$sum += $weights[i] * (int) $cnpj[$i - 1];
	}
	
	$remainder = $sum % 11;
	$digit = ($remainder) < 2 ? 0 : 11 - $remainder;
	
	if ( $cnpj[12] != $digit ) {
		return false;
	}
	$sum = 0;
	
	for ( $i = 0; $i < 13; ++$i ) {
		$sum += $weights[$i] * (int) $cnpj[$i];
	}
	
	$remainder = $sum % 11;
	$digit = ($remainder) < 2 ? 0 : 11 - $remainder;
	
	return $cnpj[13] == $digit;
}