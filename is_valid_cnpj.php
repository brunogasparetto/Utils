<?php

/**
 * Check if CNJP (Cadastro Nacional de Pessoa Jurídica) is valid
 */
function is_valid_cnpj(string $cnpj): bool
{
	$cnpj = mb_convert_encoding(mb_strtoupper($cnpj), 'ASCII');

	// Only valid characters
	$cnpj = preg_replace('/[^A-Z0-9]/', '', $cnpj);
	
	if (strlen($cnpj) != 14 OR preg_match('/(.)\1{13}/', $cnpj)) {
		return false;
	}
	
	$weights = array(6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2);
	
	$sum = 0;
	
	for ( $i = 1; $i < 13; ++$i ) {
		$sum += $weights[$i] * charValue($cnpj[$i - 1]);
	}
	
	$remainder = $sum % 11;
	$digit = $remainder < 2 ? 0 : 11 - $remainder;
	
	if (charValue($cnpj[12]) !== $digit) {
		return false;
	}

	$sum = 0;
	
	for ($i = 0; $i < 13; ++$i) {
		$sum += $weights[$i] * charValue($cnpj[$i]);
	}
	
	$remainder = $sum % 11;
	$digit = ($remainder) < 2 ? 0 : 11 - $remainder;
	
	return charValue($cnpj[13]) === $digit;
}

/**
 * Converts the char to int value
 * 
 * By SERPRO rule, get the char ASCII value and subtracts 48.
 */
function charValue(string $char): int
{
	return ord($char) - 48;
}
