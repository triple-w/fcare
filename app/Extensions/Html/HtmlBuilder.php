<?php

namespace App\Extensions\Html;

use Illuminate\Container\Container;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Routing\UrlGenerator;

class HtmlBuilder extends \Collective\Html\HtmlBuilder {

	protected $theme;

	public function __construct(UrlGenerator $url = null, Factory $view)
    {
        $this->theme = config('view.paths_theme')[0];
        parent::__construct($url, $view);
    }

	/**
     * Generate a link to a CSS file.
     *
     * @param string $url
     * @param array  $attributes
     * @param bool   $secure
     *
     * @return \Illuminate\Support\HtmlString
     */
    public function style($url, $attributes = [], $secure = null)
    {
    	$url = $this->theme . $url;
        return parent::style($url, $attributes = [], $secure);
    }

    public function styleLocal($url, $attributes = [], $secure = null)
    {
        return parent::style($url, $attributes = [], $secure);
    }

    /**
     * Generate a link to a JavaScript file.
     *
     * @param string $url
     * @param array  $attributes
     * @param bool   $secure
     *
     * @return \Illuminate\Support\HtmlString
     */
    public function script($url, $attributes = [], $secure = null)
    {
    	$url = $this->theme . $url;
        return parent::script($url, $attributes = [], $secure);
    }

    public function scriptLocal($url, $attributes = [], $secure = null) {
    	return parent::script($url, $attributes = [], $secure);	
    }

	public function link($url, $title = null, $attributes = array(), $secure = null, $escape = true) {
		$title = $this->attrsIcon($attributes) . ' ' . $title;
		$url = $this->url->to($url, array(), $secure);		
		if (is_null($title) || $title === false) $title = $url;
		$attributes = $this->attributes($attributes);

		return "<a href='{$url}' {$attributes}>{$title}</a>";
	}

	public function icon($name, $animated = '', $rotate = '') {
		!empty($animated) ? $animated = "fa-{$animated}" : '';
		!empty($rotate)	? $rotate = "fa-rotate-{$rotate}" : '';
		
		return "<i class='fa fa-{$name} {$animated} {$rotate}'></i>";
	}

	public function menuTitle($title, $options = array()) {
		return $this->attrsIcon($options) . ' ' . $title;
	}

	private function attrsIcon($options) {
		$icon = null;
		if (isset($options['icon'])) {
			$icon = $this->icon(
					isset($options['icon']['name']) ? $options['icon']['name'] : $options['icon'],
					isset($options['icon']['animated']) ? $options['icon']['animated'] : '',
					isset($options['icon']['rotate']) ? $options['icon']['rotate'] : ''
				);
			unset($options['icon']);
		}

		return $icon;
	}

	public function requireScripts($nameFiles = array()) {
		$asset = Container::getInstance()->make('url', [])->asset('webroot/js', []);
		$req = '<script>require([], function() {';
		foreach ($nameFiles as $name) {
			$file = "{$asset}/{$name}.js";
			$req .= "require(['{$file}']);";
		}
		$req .= '});</script>';

		return $req;
	}

	public function divGoogleMaps($render = false, $direccion = null, $latitud = null, $longitud = null) {
		$div = "";
		$div .= BootForm::text('direccion', 'Direccion', $direccion, [ 'id' => 'direccion', 'placeholder' => 'Direccion' ]);
		$div .= Button::primary('Buscar')->addAttributes([ 'id' => 'buscar-map' ]);
		$map = $render ? Mapper::render() : '';
        $div .= '<div class="form-group">
            <div class="col-md-12 mapa" id="mapa">' .
            $map
            . '</div>
        </div>
        <input type="hidden" name="latitud" value="' . $latitud . '" id="latitud" />
        <input type="hidden" name="longitud" value="' . $longitud . '" id="longitud" />';

        return $div;
	}	

}

?>