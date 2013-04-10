<?php
/**
 * Altera para maiúscula a primeira letra de cada palavra, 
 * mantendo os adjuntos minúsculos e números romanos em maiúsculo
 *
 * @param string $string
 * @return string
 */
private function name_capitalize($string) {
    $string = mb_convert_case(trim($string), MB_CASE_TITLE);

    // para o caso do À que não é reconhecido facilmente \x{00C0}
    $string = preg_replace_callback(
        '/\s(e|\x{00C0}|da|das|de|di|do|dos)[\s,]/iu',
        create_function('$matches','return mb_strtolower($matches[0]);'),
        $string
    );

    $string = preg_replace_callback(
        '/\b([IVXLCDM]+)\b/iu', create_function('$matches','return mb_strtoupper($matches[0]);'),
        $string
    );

    return $string;
}
