<?php

	/*Pages*/
	Breadcrumbs::register('page', function($breadcrumbs, $page)
	{
	    $breadcrumbs->push($page->nombre, route('templates.pages', [ 'id' => $page->id]));
	});

	Breadcrumbs::register('page.banner.image', function($breadcrumbs, $image)
	{
		$breadcrumbs->parent('page', $image->getBanner()->getPage());
	    $breadcrumbs->push($image->name_image, route('template.pages.banner.image', [ 'id' => $image->id]));
	});


	/*Grids*/
	Breadcrumbs::register('grid', function($breadcrumbs, $page)
	{
	    $breadcrumbs->push($page->nombre, route('templates.grids', [ 'id' => $page->id]));
	});

	Breadcrumbs::register('grid.banner', function($breadcrumbs, $banner)
	{
		$breadcrumbs->parent('grid', $banner->getPage());
	    $breadcrumbs->push($banner->name_image, route('template.grids.banner', [ 'id' => $banner->id]));
	});

	Breadcrumbs::register('grid.banner.image', function($breadcrumbs, $image)
	{
		$breadcrumbs->parent('grid.banner', $image->getBanner());
	    $breadcrumbs->push($image->name_image, route('template.grids.banner.image', [ 'id' => $image->id]));
	});

?>