@extends('layouts/products')
<h1>All Products</h1>
<p>Show all products...</p>

@if($next)
<a href="{{ $next }}" target="_blank">next 1</a>
@endif
<br>
@if($next)
<a href="{!! $next !!}" target="_blank">next 2</a>
@endif

@includes('includes/product-details', ['product' => '123', 'scary' => 'scary'])