@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
  <h1 class="text-2xl font-semibold mb-6">Produk</h1>
  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
    @forelse($products as $product)
      <div class="border rounded-lg p-4 shadow-sm">
        @if($product->image)
          <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}" class="w-full h-40 object-cover mb-3 rounded">
        @else
          <div class="w-full h-40 bg-gray-100 mb-3 rounded flex items-center justify-center text-gray-400">No Image</div>
        @endif
        <h2 class="font-medium text-lg">{{ $product->name }}</h2>
        <p class="text-sm text-gray-600 mt-2">{{ Str::limit($product->description, 80) }}</p>
        <div class="mt-4 flex items-center justify-between">
          <div class="text-lg font-bold">Rp {{ number_format($product->price,0,',','.') }}</div>
          <a href="{{ route('products.show', $product) }}" class="text-sm underline">Detail</a>
        </div>
      </div>
    @empty
      <p>Tidak ada produk.</p>
    @endforelse
  </div>

  <div class="mt-6">
    {{ $products->links() }}
  </div>
</div>
@endsection
