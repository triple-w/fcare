

@foreach (App\Models\Menus::findAll() as $menu)
	
		<div class="col-md-11 col-md-offset-1 menu-user">
			{!! Panel::normal()->withBody(HTML::icon('folder') . ' ' . $menu->nombre) !!}
		</div>
		@foreach ($menu->getSections() as $section)
			<div class="col-md-10 col-md-offset-2 menu-user">
				{!! Panel::normal()->withBody(HTML::icon('folder') . ' ' . $section->nombre) !!}
			</div>
			@foreach ($section->getPages() as $page)
				<div class="col-md-9 col-md-offset-3 menu-user">
					{!! Panel::normal()->withBody(
						HTML::link(route('templates.pages', [ 'id' => $page->id ]), HTML::icon('file') . ' ' . $page->nombre)
					) !!}
				</div>
			@endforeach
			<hr >
			@foreach ($section->getGrids() as $grid)
				<div class="col-md-9 col-md-offset-3 menu-user">
					{!! Panel::normal()->withBody(
						HTML::link(route('templates.grids', [ 'id' => $grid->id ]), HTML::icon('file') . ' ' . $grid->nombre)
					) !!}
				</div>
			@endforeach
		@endforeach
	
@endforeach