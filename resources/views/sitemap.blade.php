{{ '<?xml version="1.0" encoding="UTF-8"?>' }}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url><loc>{{ url('/') }}</loc><priority>1.0</priority></url>
    <url><loc>{{ route('products.index') }}</loc><priority>0.9</priority></url>
    <url><loc>{{ route('about') }}</loc><priority>0.7</priority></url>
    <url><loc>{{ route('contact') }}</loc><priority>0.7</priority></url>
    <url><loc>{{ route('search') }}</loc><priority>0.6</priority></url>
    @foreach($categories as $cat)
        <url><loc>{{ route('products.category', $cat->slug) }}</loc><priority>0.8</priority></url>
    @endforeach
    @foreach($products as $product)
        <url><loc>{{ route('products.show', $product->slug) }}</loc><priority>0.6</priority></url>
    @endforeach
</urlset>