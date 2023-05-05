<?php

/**
 * Check if CPF (Cadastro de Pessoa Física) is valid.
 *
 * @param string $cpf The CPF number.
 * @return bool
 */
function is_valid_cpf($cpf)
{
	// Only numbers
	$cpf = preg_replace('/\D/', '', $cpf);
	
	if ( strlen($cpf) != 11 OR preg_match('/(\d)\1{10}/', $cpf) ) {
		return false;
	}
	
	$sum = 0;
	$weight = 10;
	
	for ( $i = 0; $i < 9; ++$i, --$weight ) {
		$sum += $weight * (int) $cpf[$i];
	}
	
	$remainder = $sum % 11;
	$digit = $remainder < 2 ? 0 : 11 - $remainder;
	
	if ( $digit != $cpf[9] ) {
		return false;
	}
	
	$sum = 0;
	$weight = 11;
	
	for ( $i = 0; $i < 10; ++$i, --$weight ) {
		$sum += $weight * (int) $cpf[$i];
	}
	
	$remainder = $sum % 11;
	$digit = $remainder < 2 ? 0 : 11 - $remainder;
	
	return $digit == $cpf[10];
}
