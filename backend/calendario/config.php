<?php

/**
 **
 **  BY iCODEART
 **
 **********************************************************************
 **                      REDES SOCIALES                            ****
 **********************************************************************
 **                                                                ****
 ** FACEBOOK: https://www.facebook.com/                            ****
 ** TWIITER: https://twitter.com/                                  ****
 ** YOUTUBE: https://www.youtube.com/c/                            ****
 ** GITHUB: https://github.com/icodeart                            ****
 ** TELEGRAM: https://telegram.me/                                 ****
 ** EMAIL: info@icorreo.com
 ** WHATSAPP: 942720461                                            ****
 **                                                                ****
 **********************************************************************
 **********************************************************************
 **/

// Datos de conexion a la base de datos
$servidor = 'localhost';
$usuario = 'root';
$pass = '';
$bd = 'panaderiaerp';

// Nos conectamos a la base de datos
$conexion = new mysqli($servidor, $usuario, $pass, $bd);

// Definimos que nuestros datos vengan en utf8
$conexion->set_charset('utf8');

// verificamos si hubo algun error y lo mostramos
if ($conexion->connect_errno) {
	echo "Error al conectar la base de datos {$conexion->connect_errno}";
}

// Url donde estara el proyecto, debe terminar con un "/" al final
$base_url = "http://localhost/FreskyPan2/backend/calendario/";
