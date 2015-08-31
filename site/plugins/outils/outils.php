<?php

/**
 * Outils Plugin
 * v 0.2
 */

// de Panel toolkit

if( !function_exists('purl')) {
	function purl($obj, $action = false) {
	  if(is_string($obj)) {
	    return '#/' . $obj;
	  } else if(is_a($obj, 'File')) {
	    if($obj->page()->isSite()) {
	      return '#/files/' . $action . '/' . urlencode($obj->filename());
	    } else {
	      return '#/files/' . $action . '/' . $obj->page()->id() . '/' . urlencode($obj->filename());
	    }
	  } else if(is_a($obj, 'Page')) {
	    return '#/pages/' . $action . '/' . $obj->id();
	  } else if(is_a($obj, 'User')) {
	    return '#/users/' . $action . '/' . $obj->username();
	  }
	}
}

// aller chercher l'URL sur le panel de la page en cours
// getPanelURL( $page, 'show');
function getPanelURL( $obj, $action = false) {
	$prefixUrl = site()->url() . "/panel/";
	$panelLink = $prefixUrl . purl( $obj, $action);
	return $panelLink;
}

// et en mode html tout prêt
// getPanelButton( $page, 'show');
function getPanelButton( $obj, $action = false) {
	if($user = site()->user() and $user->hasPanelAccess()){
		$pagePanelURL = getPanelURL( $obj, $action);
		ob_start();
?>
		<button class="linkToPanelPage" data-text="admin">
			<a href="<?php echo $pagePanelURL; ?>">
				éditer cette page
			</a>
		</button>
<?php
	$panelPageButton = ob_get_clean();
	return $panelPageButton;
	}else{
		return;
	}
}

// permet d'ajouter une url à la liste des liens (en tenant compte
// des paramètres d'url) visités durant la php_session()
// (appelé dans header.php)
function add_to_visited_links($url){

	$url = rtrim( $url, '/');
	$visited_links = s::get('visited_links');
	if(!$visited_links) $visited_links = array();

	array_push($visited_links, $url);

	s::set('visited_links', array_unique($visited_links));
}

// permet de tester si l'url d'une page a déjà été visitée
// durant la php_session()
// a utiliser avec le shortcut d'echo ternaire kirby
// e(boolean, $a, $b);
function is_visited($url){
	return (in_array(rtrim( $url, '/'), s::get('visited_links')));
}