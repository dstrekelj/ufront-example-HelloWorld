<?php

interface thx_translation_ITranslation {
	function singular($id, $domain = null);
	function plural($ids, $idp, $quantifier, $domain = null);
	//;
}
