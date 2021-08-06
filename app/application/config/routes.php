<?php
defined('BASEPATH') or exit('No direct script access allowed');

$route['default_controller'] = 'Pessoa';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['cadastro_pessoa']   =   'Pessoa/cadastro_pessoa';
$route['excluir_pessoa'] = 'Pessoa/excluir_pessoa';

$route['cadastro_conta']   =   'Conta';
$route['cadastro_conta_db'] = 'Conta/cadastro_conta';
$route['excluir_conta'] = 'Conta/excluir_conta';

$route['movimentacao']   =   'Movimentacao';

$route['ajax_contas/(:num)']   =   'Conta/ajax_contas/$1';
$route['ajax_extrato/(:num)']  =   'Movimentacao/ajax_extrato/$1';

$route['atualiza_saldo'] =  'Movimentacao/atualizaSaldo';
$route['verifica_saldo'] = 'Conta/verificaSaldo';
