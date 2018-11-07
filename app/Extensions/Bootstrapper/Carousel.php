<?php

namespace App\Extensions\Bootstrapper;

use Bootstrapper\Attributes;

use Auth;

class Carousel extends \Bootstrapper\Carousel {


	/**
     * Renders the items of the carousel
     *
     * @return string
     */
    protected function renderItems()
    {

        $string = "<div class='carousel-inner'>";
        $count = 0;
        foreach ($this->contents as $item) {
            if ($count == $this->active) {
                $string .= "<div class='item active'>";
            } else {
                $string .= "<div class='item'>";
            }

            $string .= $this->createItem($item);

            if (isset($item['caption'])) {
                $string .= "<div class='carousel-caption'>{$item['caption']}</div>";
            }
            $string .= "</div>";
            $count++;
        }
        $string .= "</div>";

        return $string;
    }

    protected function createItem($item) {
    	$string = "";
    	if (isset($item['link'])) {
        	$attrs = [];
        	if (isset($item['link']['attrs'])) {
        		$attrs = $item['link']['attrs'];
        	}
        	$attributes = new Attributes(
	            $attrs
	        );

        	$string .= "<a href='{$item['link']['url']}' {$attributes}>";
        }

        $string .= "<img src='{$item['image']}' alt='{$item['alt']}'>";

        if (isset($item['link'])) {
        	$string .= '</a>';
        }

        return $string;
    }

}

?>