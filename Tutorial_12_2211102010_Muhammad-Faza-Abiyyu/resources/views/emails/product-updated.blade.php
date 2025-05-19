<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Produk Diperbarui</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        h1 {
            color: #007bff;
        }
        .product-info {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .price {
            font-weight: bold;
            color: #dc3545;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Produk Diperbarui</h1>
        
        <p>Halo Admin,</p>
        
        <p>Produk berikut telah diperbarui di sistem manajemen produk:</p>
        
        <div class="product-info">
            <h2>{{ $product->nama }}</h2>
            <p><strong>Harga:</strong> <span class="price">Rp{{ number_format($product->harga, 0, ',', '.') }}</span></p>
            
            @if($product->deskripsi)
                <p><strong>Deskripsi:</strong> {{ $product->deskripsi }}</p>
            @endif
        </div>
        
        <p>Anda dapat melihat produk yang diperbarui di panel admin.</p>
        
        <p>Terima kasih,<br>
        Sistem Manajemen Produk</p>
    </div>
</body>
</html>