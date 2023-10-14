@extends('layouts.app')

@section('content')

	<ul class="flex_container">
        <li><a href="{{ route('shop') }}">Alle items</a></li>
		@foreach($categories as $category)
			<li><a href="{{ route('shop.indexSorted', $category) }}">{{ $category->name }}</a></li>
		@endforeach
	</ul>

    <div class="products">
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
							<span class="important">Nu <b>{{ $product->discount }}%</b> korting</span> <!-- Orginele prijs: {{ $product->getOriginal('price') }} -->
						</p>
					@endif
					</div>
					<button class="btn btn-primary">Meer info &amp; bestellen</button>
				</div>
			</a>
		@endforeach
	</div>
@endsection