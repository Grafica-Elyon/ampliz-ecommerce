<?php

namespace MisterPrint\Support;

class View
{
	private $name;
	private $data;
	private $is_admin;

	public function __construct($name, $data, $is_admin = false)
	{
		$this->name = $name;
		$this->data = $data;
		$this->is_admin = $is_admin;
	}

	public function getTemplatePath()
	{

		if($this->is_admin) {
			return $this->getAdminPath($this->name);
		} else {
			return $this->getPath($this->name);
		}
	}

	public function __toString()
	{
		return $this->get();
	}

	public function get( $minified = true )
	{
		ob_start();
		include $this->getTemplatePath();
		$html = ob_get_contents();
		ob_end_clean();

		if ( $minified ) {
			//remove redundant (white-space) characters
			$replace = array(
				//remove tabs before and after HTML tags
				'/\>[^\S ]+/s'   => '> ',
				'/[^\S ]+\</s'   => ' <',
				//shorten multiple whitespace sequences; keep new-line characters because they matter in JS!!!
				'/([\t ])+/s'  => ' ',
				//remove leading and trailing spaces
				'/^([\t ])+/m' => '',
				'/([\t ])+$/m' => '',
				// remove JS line comments (simple only); do NOT remove lines containing URL (e.g. 'src="http://server.com/"')!!!
				'~//[a-zA-Z0-9 ]+$~m' => '',
				//remove empty lines (sequence of line-end and white-space characters)
				'/[\r\n]+([\t ]?[\r\n]+)+/s'  => "\n",
				//remove empty lines (between HTML tags); cannot remove just any line-end characters because in inline JS they can matter!
				'/\>[\r\n\t ]+\</s'    => '> <',
				//remove "empty" lines containing only JS's block end character; join with next line (e.g. "}\n}\n</script>" --> "}}</script>"
				'/}[\r\n\t ]+/s'  => '}',
				'/}[\r\n\t ]+,[\r\n\t ]+/s'  => '},',
				//remove new-line after JS's function or condition start; join with next line
				'/\)[\r\n\t ]?{[\r\n\t ]+/s'  => '){',
				'/,[\r\n\t ]?{[\r\n\t ]+/s'  => ',{',
				//remove new-line after JS's line end (only most obvious and safe cases)
				'/\),[\r\n\t ]+/s'  => '),',
				//remove quotes from HTML attributes that does not contain spaces; keep quotes around URLs!
				'~([\r\n\t ])?([a-zA-Z0-9]+)="([a-zA-Z0-9_/\\-]+)"([\r\n\t ])?/?~s' => '$1$2=$3$4', //$1 and $4 insert first white-space character found before/after attribute
			);
			$html = preg_replace(array_keys($replace), array_values($replace), $html);
		}

		return $html;
	}

	public static function getPath($filename)
	{
		return config('plugin', 'path') . 'front/partials/' . $filename . '.php';
	}

	public static function getAdminPath($filename)
	{
		return config('plugin', 'path') . 'admin/partials/' . $filename . '.php';
	}
}
