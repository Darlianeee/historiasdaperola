<?php
// Ajuste HISTORIAS_URL caso a pasta tenha outro nome no htdocs.
define('APP', __DIR__);
define('URL', rtrim(getenv('HISTORIAS_URL') ?: 'http://localhost/historiasdaperola-main', '/'));
define('APP_NAME', 'Histórias na Pérola');
const APP_VERSAO = '1.1.0';
