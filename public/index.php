<?php
require_once __DIR__ . "/../Config/Config.php";

// Simple router for friendly URLs
// Example friendly URLs: /users, /users/create, /users/delete/6
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Compute base path (path to this public folder) and remove it from URI
$scriptName = dirname($_SERVER['SCRIPT_NAME']);
$base = rtrim(str_replace('\\', '/', $scriptName), '/');
$path = trim(substr($uri, strlen($base)), '/');
if ($path === false) { $path = ''; }

// split path into segments
$segments = array_values(array_filter(explode('/', $path)));

// Basic routing dispatch
switch ($segments[0] ?? '') {
	case 'users':
		// /users or /users/...
		require_once __DIR__ . "/../app/Controllers/userController/UsuarioController.php";
		// Controller handles actions based on $segments
		// e.g. UsuarioController::handle($segments);
		// For now include a small dispatcher:
		if (isset($segments[1]) && $segments[1] === 'cadastro') {
			include __DIR__ . "/../app/Views/user/TemplateCadastroUsuario.php";
		} elseif (isset($segments[1]) && $segments[1] === 'listarUsuarios'){
            include __DIR__ . "/../app/Views/user/TemplateListarUsuarios.php";
        } elseif (isset($segments[1]) && $segments[1] === 'delete' && isset($segments[2])) {
			// redirect to controller via GET param
			header('Location: ' . ($_SERVER['SCRIPT_NAME'] ?? '') . '/users?delete=' . urlencode($segments[2]));
			exit;
		} else {
			include __DIR__ . "/../app/Views/user/TemplateCadastroUsuario.php";
		}
		break;

	case '':
	default:
		// Home — show cadastro
		include __DIR__ . "/../app/Views/user/TemplateCadastroUsuario.php";
		break;
}

?>
