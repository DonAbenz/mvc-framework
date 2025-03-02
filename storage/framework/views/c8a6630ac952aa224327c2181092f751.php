<?php $this->extends('layouts/products'); ?>
<h1>All Products</h1>
<p>Show all products...</p>

<?php if($next): ?>
<a href="<?php print $this->escape( $next ); ?>" target="_blank">next 1</a>
<?php endif; ?>
<br>
<?php if($next): ?>
<a href="<?php print  $next ; ?>" target="_blank">next 2</a>
<?php endif; ?>

<?php $this->includes('includes/product-details', ['product' => '123', 'scary' => 'scary']); ?>