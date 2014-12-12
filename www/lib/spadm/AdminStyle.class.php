<?php

class spadm_AdminStyle {
	public function __construct($t) {
		if(!php_Boot::$skip_constructor) {
		$this->table = $t;
	}}
	public $isNull;
	public $value;
	public $isHeader;
	public $table;
	public function out($str, $params = null) {
		if($params !== null) {
			$_g = 0;
			$_g1 = Reflect::fields($params);
			while($_g < $_g1->length) {
				$x = $_g1[$_g];
				++$_g;
				$str = _hx_explode("@" . _hx_string_or_null($x), $str)->join(Reflect::field($params, $x));
				unset($x);
			}
		}
		php_Lib::println($str);
	}
	public function text($str, $title = null) {
		$str = StringTools::htmlEscape($str, null);
		if($title !== null) {
			$str = "<span title=\"" . _hx_string_or_null(StringTools::htmlEscape($title, null)) . "\">" . _hx_string_or_null($str) . "</span>";
		}
		$this->out($str, null);
	}
	public function begin($title) {
		$this->out("<html><head><title>@title</title>", _hx_anonymous(array("title" => $title)));
		if(spadm_AdminStyle::$CSS !== null) {
			$this->out(spadm_AdminStyle::$CSS, null);
		}
		$this->out("<meta http-equiv=\"Content-Type\" content=\"text/html;charset=UTF-8\"/>", null);
		$this->out("\x0D\x0A\x09\x09\x09<script lang=\"text/javascript\">\x0D\x0A\x09\x09\x09\x09function updateLink(name,url,value) {\x0D\x0A\x09\x09\x09\x09\x09document.getElementById(name+\"__goto\").href = (value == \"\")?\"#\":(\"@base\" + url + value);\x0D\x0A\x09\x09\x09\x09}\x0D\x0A\x09\x09\x09\x09function updateImage(name,url,value) {\x0D\x0A\x09\x09\x09\x09\x09updateLink(name,url,value);\x0D\x0A\x09\x09\x09\x09\x09document.getElementById(name+\"__img\").src = \"" . _hx_string_or_null($this->getFileURL("::f::")) . "\".split(\"::f::\").join(value);\x0D\x0A\x09\x09\x09\x09}\x0D\x0A\x09\x09\x09</script>\x0D\x0A\x09\x09", _hx_anonymous(array("base" => spadm_AdminStyle::$BASE_URL)));
		$this->out("</head><body>", null);
		$this->out("<h1>@title</h1><div class=\"main\">", _hx_anonymous(array("title" => $title)));
	}
	public function end() {
		$this->out("<div class=\"links\">", null);
		$this->out("<a href=\"/\">Exit</a> | <a href=\"@url\">Database</a>", _hx_anonymous(array("url" => spadm_AdminStyle::$BASE_URL)));
		if($this->table !== null) {
			$this->out("| <a href=\"@url@table/search\">Search</a>", _hx_anonymous(array("url" => spadm_AdminStyle::$BASE_URL, "table" => $this->table->className)));
		}
		if($this->table !== null) {
			$this->out("| <a href=\"@url@table/insert\">Insert</a>", _hx_anonymous(array("url" => spadm_AdminStyle::$BASE_URL, "table" => $this->table->className)));
		}
		$this->out("</div></div>", null);
		$this->out(spadm_AdminStyle::$HTML_BOTTOM, null);
		$this->out("</body></html>", null);
	}
	public function beginList() {
		$this->out("<ul>", null);
	}
	public function endList() {
		$this->out("</ul>", null);
	}
	public function beginItem() {
		$this->out("<li>", null);
	}
	public function endItem() {
		$this->out("</li>", null);
	}
	public function gotoURL($url) {
		php_Web::redirect(_hx_string_or_null(spadm_AdminStyle::$BASE_URL) . _hx_string_or_null($url));
	}
	public function link($url, $name) {
		$this->out("<a href=\"@url\">@name</a>", _hx_anonymous(array("url" => _hx_string_or_null(spadm_AdminStyle::$BASE_URL) . _hx_string_or_null($url), "name" => $name)));
	}
	public function linkConfirm($url, $name) {
		$this->out("<a href=\"@url\" onclick=\"return confirm('Please confirm this action')\">@name</a>", _hx_anonymous(array("url" => _hx_string_or_null(spadm_AdminStyle::$BASE_URL) . _hx_string_or_null($url), "name" => $name)));
	}
	public function beginForm($url, $file = null, $id = null) {
		$this->out("<form id=\"@id\" action=\"@url\" method=\"POST\"@enc>", _hx_anonymous(array("id" => $id, "url" => _hx_string_or_null(spadm_AdminStyle::$BASE_URL) . _hx_string_or_null($url), "enc" => (($file) ? " enctype=\"multipart/form-data\"" : ""))));
		$this->beginTable(null);
	}
	public function endForm() {
		$this->endTable();
		$this->out("</form>", null);
	}
	public function beginTable($css = null) {
		if($css !== null) {
			$this->out("<table class=\"@css\">", _hx_anonymous(array("css" => $css)));
		} else {
			$this->out("<table>", null);
		}
	}
	public function endTable() {
		$this->out("</table>", null);
	}
	public function beginLine($isHeader = null, $css = null) {
		$str = "<tr";
		if($css !== null) {
			$str .= " class=\"" . _hx_string_or_null($css) . "\"";
		}
		$str .= ">";
		if($isHeader) {
			$str .= "<th>";
		} else {
			$str .= "<td>";
		}
		$this->out($str, null);
		$this->isHeader = $isHeader;
	}
	public function nextRow($isHeader = null) {
		$this->out(_hx_string_or_null(((($this->isHeader) ? "</th>" : "</td>"))) . _hx_string_or_null(((($isHeader) ? "<th>" : "<td>"))), null);
		$this->isHeader = $isHeader;
	}
	public function endLine() {
		$this->out(_hx_string_or_null(((($this->isHeader) ? "</th>" : "</td>"))) . "</tr>", null);
	}
	public function addSubmit($name, $url = null, $confirm = null, $iname = null) {
		$this->beginLine(null, null);
		$this->nextRow(null);
		$this->out("<input type=\"submit\" class=\"button\" value=\"@name\"", _hx_anonymous(array("name" => $name)));
		if($iname !== null) {
			$this->out(" name=\"@name\"", _hx_anonymous(array("name" => $iname)));
		}
		if($url !== null) {
			$conf = null;
			if($confirm) {
				$conf = "if( confirm('Please confirm this action') )";
			} else {
				$conf = "";
			}
			$this->out(" onclick=\"@conf document.location = '@url'; return false\"", _hx_anonymous(array("conf" => $conf, "url" => _hx_string_or_null(spadm_AdminStyle::$BASE_URL) . _hx_string_or_null($url))));
		} else {
			if($confirm) {
				$this->out(" onclick=\"return confirm('Please confirm this action');\"", null);
			}
		}
		$this->out("/>", null);
		$this->endLine();
	}
	public function checkBox($name, $checked) {
		$this->out("<input name=\"@name\" type=\"checkbox\" class=\"dcheck\"", _hx_anonymous(array("name" => $name)));
		if($checked) {
			$this->out(" checked=\"1\"", null);
		}
		$this->out("/>", null);
	}
	public function input($name, $css, $options = null) {
		if($options === null) {
			$options = _hx_anonymous(array());
		}
		$this->beginLine(true, null);
		$this->out($name, null);
		$this->nextRow(null);
		if($this->isNull) {
			$this->checkBox(_hx_string_or_null($name) . "__data", $this->value !== null);
		}
		$this->out("<input name=\"@name\" class=\"@css\"", _hx_anonymous(array("name" => $name, "css" => $css)));
		if(_hx_field($options, "size") !== null) {
			$this->out(" maxlength=\"@size\"", $options);
		}
		if($options->isCheck) {
			$this->out(" type=\"checkbox\"", null);
		}
		if($this->value !== null) {
			if($options->isCheck) {
				if(Std::string($this->value) !== "false") {
					$this->out(" checked=\"1\"", null);
				}
			} else {
				$this->out(" value=\"@v\"", _hx_anonymous(array("v" => _hx_explode("\"", Std::string($this->value))->join("&quot;"))));
			}
		}
		$this->out("/>", null);
		$this->endLine();
	}
	public function getFileURL($v) {
		return "/file/" . _hx_string_or_null($v) . ".png";
	}
	public function inputText($name, $css, $noWrap = null) {
		$this->beginLine(true, null);
		$this->out($name, null);
		$this->nextRow(null);
		if($this->isNull) {
			$this->checkBox(_hx_string_or_null($name) . "__data", $this->value !== null);
		}
		$this->out("<textarea name=\"@name\" class=\"@css\"@noWrap>@value</textarea>", _hx_anonymous(array("noWrap" => (($noWrap) ? " wrap=\"off\"" : ""), "name" => $name, "css" => $css, "value" => (($this->value !== null) ? StringTools::htmlEscape($this->value, null) : ""))));
		$this->endLine();
	}
	public function inputField($name, $type, $isNull, $value) {
		$this->isNull = $isNull;
		$this->value = $value;
		switch($type->index) {
		case 0:case 2:case 4:{
			$this->infoField($name, (($value === null) ? "#ID" : $value));
		}break;
		case 1:{
			$this->input($name, "dint", _hx_anonymous(array("size" => 10)));
		}break;
		case 5:{
			$this->input($name, "dbigint", _hx_anonymous(array("size" => 20)));
		}break;
		case 3:{
			$this->input($name, "duint", _hx_anonymous(array("size" => 10)));
		}break;
		case 24:{
			$this->input($name, "dtint", _hx_anonymous(array("size" => 4)));
		}break;
		case 25:case 26:case 27:case 28:case 29:{
			$this->input($name, "dint", _hx_anonymous(array("size" => 10)));
		}break;
		case 7:case 6:{
			$this->input($name, "dfloat", _hx_anonymous(array("size" => 10)));
		}break;
		case 8:{
			$this->input($name, "dbool", _hx_anonymous(array("isCheck" => true)));
		}break;
		case 9:{
			$n = $type->params[0];
			$this->input($name, "dstring", _hx_anonymous(array("size" => $n)));
		}break;
		case 13:{
			$this->input($name, "dtinytext", null);
		}break;
		case 10:{
			if($value !== null) {
				try {
					$this->value = _hx_substr($value, 0, 10);
				}catch(Exception $__hx__e) {
					$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
					$e = $_ex_;
					{
						$this->value = "#INVALID";
					}
				}
			}
			$this->input($name, "ddate", _hx_anonymous(array("size" => 10)));
		}break;
		case 11:case 12:{
			if($value !== null) {
				try {
					$this->value = $value;
				}catch(Exception $__hx__e) {
					$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
					$e1 = $_ex_;
					{
						$this->value = "#INVALID";
					}
				}
			}
			$this->input($name, "ddatetime", _hx_anonymous(array("size" => 19)));
		}break;
		case 15:case 14:{
			$this->inputText($name, "dtext", null);
		}break;
		case 21:case 22:{
			$this->inputText($name, "dtext", true);
		}break;
		case 30:{
			$this->inputText($name, "dtext", true);
		}break;
		case 31:{
			$this->input($name, "dtint", _hx_anonymous(array("size" => 4)));
		}break;
		case 20:{
			$this->input($name, "denc", _hx_anonymous(array("size" => 6)));
		}break;
		case 23:{
			$fl = $type->params[0];
			{
				$this->beginLine(true, null);
				$this->out($name, null);
				$this->nextRow(null);
				if($isNull) {
					$this->checkBox(_hx_string_or_null($name) . "__data", $value !== null);
				}
				$vint = Std::parseInt($value);
				if($vint === null) {
					$vint = 0;
				}
				$pos = 0;
				{
					$_g1 = 0;
					$_g = $fl->length;
					while($_g1 < $_g) {
						$i = $_g1++;
						$this->out("<input name=\"@name\" class=\"@css\"", _hx_anonymous(array("name" => _hx_string_or_null($name) . "_" . _hx_string_or_null($fl[$i]), "css" => "dbool")));
						$this->out(" type=\"checkbox\"", null);
						if(($vint & 1 << $i) !== 0) {
							$this->out(" checked=\"1\"", null);
						}
						$this->out("/>", null);
						$this->out($fl[$i], null);
						unset($i);
					}
				}
				$this->endLine();
			}
		}break;
		case 18:case 16:case 17:case 19:case 33:case 32:{
			throw new HException("NotSupported");
		}break;
		}
	}
	public function binField($name, $isNull, $value, $url) {
		$this->beginLine(true, null);
		$this->out($name, null);
		$this->nextRow(null);
		if($isNull) {
			$this->checkBox(_hx_string_or_null($name) . "__data", $value !== null);
		}
		if($value !== null) {
			$this->text("[" . _hx_string_rec(strlen($value), "") . " bytes]", null);
		} else {
			if($url !== null) {
				$this->text("null", null);
			}
		}
		$this->out("<input type=\"file\" class=\"dfile\" name=\"@name\"/>", _hx_anonymous(array("name" => $name)));
		if($value !== null && $url !== null) {
			$this->link(call_user_func($url), "download");
		}
		$this->endLine();
	}
	public function infoField($name, $value) {
		$this->beginLine(true, null);
		$this->out($name, null);
		$this->nextRow(null);
		$this->out($value, null);
		$this->endLine();
	}
	public function choiceField($name, $values, $def, $link, $disabled = null, $isImage = null) {
		$this->beginLine(true, null);
		$this->out($name, null);
		$this->nextRow(null);
		$infos = _hx_anonymous(array("func" => (($isImage) ? "updateImage" : "updateLink"), "name" => $name, "link" => $link, "size" => (($values !== null && $values->length > 15) ? 10 : 1), "dis" => (($disabled) ? "disabled=\"yes\"" : ""), "def" => (($def === "null") ? "" : $def)));
		if($values === null) {
			$this->out("<input id=\"@name\" name=\"@name\" class=\"dint\" value=\"@def\" @dis onchange=\"@func('@name','@link',this.value)\"/>", $infos);
		} else {
			$this->out("<select id=\"@name\" name=\"@name\" class=\"dselect\" size=\"@size\" @dis onchange=\"@func('@name','@link',this.value)\">", $infos);
			$this->out("<option value=\"\">---- none -----</option>", null);
			if(null == $values) throw new HException('null iterable');
			$__hx__it = $values->iterator();
			while($__hx__it->hasNext()) {
				$v = $__hx__it->next();
				$this->out("<option value=\"@id\"@sel>@str</option>", _hx_anonymous(array("id" => $v->id, "str" => $v->str, "sel" => (($v->id === $def) ? " selected=\"yes\"" : ""))));
			}
			$this->out("</select>", null);
		}
		$this->out("<a id=\"@name__goto\" href=\"#\">goto</a>", _hx_anonymous(array("name" => $name)));
		if($isImage) {
			$this->out("<img class=\"dfile\" id=\"@name__img\" src=\"@file\"/>", _hx_anonymous(array("name" => $name, "file" => $this->getFileURL($def))));
		}
		$this->out("<script lang=\"text/javascript\">document.getElementById(\"@name\").onchange()</script>", _hx_anonymous(array("name" => $name)));
		$this->endLine();
	}
	public function errorField($message) {
		$this->beginLine(true, null);
		$this->nextRow(null);
		$this->error($message);
		$this->endLine();
	}
	public function error($message) {
		$this->out("<div class=\"derror\">@msg</div>", _hx_anonymous(array("msg" => $message)));
	}
	public function __call($m, $a) {
		if(isset($this->$m) && is_callable($this->$m))
			return call_user_func_array($this->$m, $a);
		else if(isset($this->__dynamics[$m]) && is_callable($this->__dynamics[$m]))
			return call_user_func_array($this->__dynamics[$m], $a);
		else if('toString' == $m)
			return $this->__toString();
		else
			throw new HException('Unable to call <'.$m.'>');
	}
	static $BASE_URL = "/db/";
	static $CSS;
	static $HTML_BOTTOM = "";
	function __toString() { return 'spadm.AdminStyle'; }
}
spadm_AdminStyle::$CSS = spadm_AdminStyle_0();
function spadm_AdminStyle_0() {
	{
		$file = null;
		if($file === null) {
			return null;
		} else {
			return "<style type=\"text/css\">" . _hx_string_or_null($file) . "</style>";
		}
		unset($file);
	}
}
