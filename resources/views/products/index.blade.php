@extends('layouts.app')

@section('content')

	<div class="products">
		<div class="categories">
			@foreach($categories as $category)
				<ul><li><a href="{{ route('tocategory', ['category' => $category->id]) }}">{{ $category->name }}</a></li></ul>
			@endforeach
		</div>
		@foreach($products as $product)
			<a class="product-row no-link" href="{{ route('products.show', $product) }}">
				<img src="{{ url($product->image ?? 'img/placeholder.jpg') }}" alt="{{ $product->title }}" class="rounded">
				<div class="product-body">
					<div>
						<h5 class="product-title"><span>{{ $product->title }}</span><em>&euro;{{ $product->price }}</em></h5>
						@unless(empty($product->description))
							<p>{{ $product->description }}</p>
						@endunless
					</div>
					<div class="sale">
					@if( $product->discount > 0)
						<p>
							<span class="important">Nu <b>{{ $product->discount }}%</b> korting</span> 
						</p>
						<p>
							Orginele prijs: {{ $product->getRawOriginal('price') }} 
							<!-- Orginele prijs: {{ $product->getOriginal('price') }} -->
						</p>
					@endif
					</div>
					<button class="btn btn-primary">Meer info &amp; bestellen</button>
				</div>
			</a>
		@endforeach
	</div>

@endsection