@extends('layouts.app')

@section('content')

<style>
body {
    background: linear-gradient(135deg, #fdfbfb, #ebedee);
    font-family: 'Poppins', sans-serif;
}

.history-container {
    max-width: 900px;
    margin: 50px auto;
    width: 100%;
    box-sizing: border-box;
    padding: 0 20px;
}

.history-title {
    text-align: center;
    margin-bottom: 40px;
    color: #555;
}

.order-card {
    background: #ffffffcc;
    backdrop-filter: blur(10px);
    border-radius: 20px;
    padding: 25px;
    margin-bottom: 25px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.05);
    transition: 0.3s ease;
}

.order-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 25px rgba(0,0,0,0.08);
}

.order-id {
    font-weight: 600;
    color: #444;
    margin-bottom: 10px;
}

.order-info {
    margin-bottom: 8px;
    color: #555;
}

.status-badge {
    display: inline-block;
    padding: 5px 14px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 600;
    background: #eecbff;
    color: #7d4b9f;
}

.product-list {
    margin-top: 15px;
    padding-left: 20px;
}

.product-list li {
    margin-bottom: 6px;
    color: #555;
}

.empty-box {
    background: #ffffffcc;
    backdrop-filter: blur(10px);
    padding: 20px;
    border-radius: 15px;
    text-align: center;
    color: #777;
    box-shadow: 0 8px 20px rgba(0,0,0,0.05);
}
.back-link {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: #777;
        }

        .back-link:hover {
            color: #a678b4;
        }

        /* ================= RESPONSIVE ================= */

/* Tablet */
@media (max-width: 992px) {
    .history-container {
        padding: 0 20px;
    }
}

/* HP */
@media (max-width: 768px) {

    .history-container {
        margin: 30px auto;
        padding: 0 15px;
    }

    .history-title {
        font-size: 20px;
        margin-bottom: 25px;
    }

    .order-card {
        padding: 18px;
        border-radius: 15px;
    }

    .order-id {
        font-size: 14px;
    }

    .order-info {
        font-size: 14px;
    }

    .status-badge {
        font-size: 12px;
        padding: 4px 10px;
    }

    .product-list {
        padding-left: 15px;
    }

    .product-list li {
        font-size: 13px;
    }

    .back-link {
        display: block;
        margin-bottom: 15px;
        font-size: 14px;
    }
}

/* HP kecil */
@media (max-width: 480px) {

    .history-title {
        font-size: 18px;
    }

    .order-card {
        padding: 15px;
    }

    .order-info {
        font-size: 13px;
    }

    .product-list li {
        font-size: 12px;
    }
}

.status-badge {
    background: #eecbff;
}

.status-badge:contains("success") {
    background: #d4edda;
    color: green;
}
</style>

<div class="history-container">

    <h2 class="history-title">✨ Riwayat Pesanan Saya ✨</h2>
    <a href="{{ route('products.index') }}" class="back-link">
                ← Kembali ke Produk
            </a>
    @if($orders->isEmpty())
        <div class="empty-box">
            Anda belum memiliki pesanan.
        </div>
    @else

        @foreach($orders as $order)
        <div class="order-card">

            <div class="order-id">
                Order ID: #{{ $order->id }}
            </div>

            <div class="order-info">
                <strong>Total:</strong>
                Rp {{ number_format($order->total_price) }}
            </div>

            <div class="order-info">
                <strong>Status:</strong>
                <span class="status-badge">
                    {{ $order->status }}
                </span>
            </div>

            <hr style="margin:15px 0; opacity:0.2;">

            <h5 style="color:#a678b4;">Detail Produk:</h5>

            @if($order->items->isEmpty())
                <p style="color:#888;">Tidak ada item.</p>
            @else
                <ul class="product-list">
                    @foreach($order->items as $item)
                        <li>
                            {{ $item->product->name ?? 'Produk dihapus' }}
                            ({{ $item->quantity }} x Rp {{ number_format($item->price) }})
                        </li>
                    @endforeach
                </ul>
            @endif

        </div>
        @endforeach

    @endif

</div>

@endsection
