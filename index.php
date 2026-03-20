<?php
// This file is part of Moodle - https://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Main file to view greetings
 *
 * @package     local_greetings
 * @copyright   2026 Mari Romero <marrmart@emeal.nttdata.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
// Carga el archivo de configuración principal de Moodle
require_once('../config.php');
// Incluye funciones auxiliares del plugin local "greetings"
require_once($CFG->dirroot . '/moodle-local_greetings/lib.php');
// Incluye el formulario definido para el plugin
require_once($CFG->dirroot . '/moodle-local_greetings/message_form.php');
// Obliga a que el usuario esté autenticado (si no, redirige al login)
require_login();
// Obtiene el contexto del sistema (nivel global en Moodle)
$context = \context_system::instance();
// Establece el contexto para la página actual
$PAGE->set_context($context);
// Define la URL de esta página (importante para navegación interna de Moodle)
$PAGE->set_url(new moodle_url('/moodle-local_greetings/index.php'));
// Define el tipo de diseño de la página (layout estándar)
$PAGE->set_pagelayout('standard');
// Define el título/encabezado de la página
$PAGE->set_heading('Greetings');
// Muestra el encabezado de la página (incluye cabecera, menú, etc.)
echo $OUTPUT->header();
// Comprueba si el usuario está logueado
if (isloggedin()) {
    // Comprueba si el usuario es "Oscar Ruesga Criado"
    if (fullname($USER) == 'Oscar Ruesga Criado') {
        // Mensaje personalizado para ese usuario
        $usergreeting = 'Greetings,Mari';
    } else {
        // Mensaje personalizado para cualquier otro usuario
        $usergreeting = 'Greetings, ' . fullname($USER);
    }
} else {
    // Mensaje para usuarios no autenticados
    $usergreeting = 'Greetings, user';
}
// Creamos un array con los datos que se pasarán a la plantilla Mustache
// (clave => valor)
$templatedata = ['usergreeting' => $usergreeting];
// 🔹 Carga del sistema de plantillas Mustache
require_once($CFG->libdir . '/mustache/src/Mustache/Autoloader.php');
// Registra el autoloader de Mustache
Mustache_Autoloader::register();
// Define el directorio donde están las plantillas
$loader = new Mustache_Loader_FilesystemLoader(
    $CFG->dirroot . '/moodle-local_greetings/templates'
);
// Crea una instancia del motor de plantillas Mustache
$mustache = new Mustache_Engine([
    'loader' => $loader,
]);
// Renderiza la plantilla "greeting_message.mustache"
// y le pasa los datos definidos en $templatedata
echo $mustache->render('greeting_message', $templatedata);
// Muestra el pie de página de Moodle
echo $OUTPUT->footer();
