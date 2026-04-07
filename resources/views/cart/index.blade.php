@extends('layouts.app')

@section('content')

<div class="cart-container">

    <h2 class="cart-title">🛒 Keranjang Saya</h2>

    @if($carts->count() > 0)

    <form action="{{ route('checkout') }}" method="GET">
        @csrf

        @foreach($carts as $cart)
        @php
            $subtotal = $cart->product->price * $cart->quantity;
        @endphp

        <div class="cart-item">

            <!-- Checkbox -->
            <input type="checkbox"
                   name="selected_items[]"
                   value="{{ $cart->id }}"
                   data-price="{{ $cart->product->price }}"
                   data-id="{{ $cart->id }}"
                   class="item-checkbox">

            <!-- Gambar Produk -->
            <div class="product-image">
                <img src="{{ asset('images/products/'.$cart->product->image) }}"
                     onerror="this.src='https://via.placeholder.com/80/fdf2f4/d8a7b1?text=No+Image'"
                     alt="{{ $cart->product->name }}">
            </div>

            <!-- Info Produk -->
            <div class="product-info">
                <strong>{{ $cart->product->name }}</strong>
                <span>Rp {{ number_format($cart->product->price) }}</span>
            </div>

            <!-- Qty -->
            <div class="qty-wrapper">
                <button type="button" onclick="changeQty('{{ $cart->id }}', -1)" class="qty-btn">−</button>

                <input type="number"
                       id="qty-{{ $cart->id }}"
                       value="{{ $cart->quantity }}"
                       readonly
                       class="qty-input">

                <button type="button" onclick="changeQty('{{ $cart->id }}', 1)" class="qty-btn">+</button>
            </div>

            <!-- Subtotal -->
            <div class="subtotal">
                Rp <span id="subtotal-{{ $cart->id }}">
                    {{ number_format($subtotal) }}
                </span>
            </div>

        </div>
        @endforeach

        <div class="cart-total">
            <h3>Total: Rp <span id="totalHarga">0</span></h3>

            <button type="submit" class="checkout-btn">
                Lanjutkan ke Checkout
            </button>
        </div>

    </form>

   @else
    <div style="text-align:center; padding: 40px 20px;">
        <p style="color: #aaa; margin-bottom: 20px;">Wah, keranjang belanjamu masih kosong nih...</p>

        <a href="{{ route('products.index') }}"
           style="display: inline-block; padding: 12px 30px; background: #d8a7b1; color: white; text-decoration: none; border-radius: 25px; font-weight: bold; box-shadow: 0 4px 15px rgba(216,167,177,0.3); transition: 0.3s;">
           🛍️ Belanja Sekarang
        </a>
    </div>
@endif


</div>

@endsection



@section('scripts')
<style>

/* CONTAINER */
.cart-container {
    font-family: 'Poppins', sans-serif;
    background: #fffafb;
    padding: 25px;
    border-radius: 20px;
}

/* TITLE */
.cart-title {
    text-align: center;
    color: #d8a7b1;
    margin-bottom: 25px;
}

/* ITEM */
.cart-item {
    display: flex;
    align-items: center;
    gap: 20px;
    background: white;
    padding: 15px;
    border-radius: 15px;
    margin-bottom: 15px;
    border: 1px solid #fce4ec;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    flex-wrap: wrap;
}

/* IMAGE */
.product-image {
    width: 80px;
    height: 80px;
    border-radius: 12px;
    overflow: hidden;
    background: #fdf2f4;
     flex: 0 0 80px;
}

.product-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* INFO */
.product-info {
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    flex: 1;
    min-width: 150px;
}

.product-info span {
    color: #b08968;
    font-weight: bold;
}

/* QTY */
.qty-wrapper {
    display: flex;
    align-items: center;
    background: #fdf2f4;
    border-radius: 25px;
    padding: 5px 10px;
    gap: 10px;
    flex: 0 0 auto;
}

.qty-btn {
    border: none;
    background: #d8a7b1;
    color: white;
    width: 28px;
    height: 28px;
    border-radius: 50%;
    cursor: pointer;
    font-weight: bold;
    transition: 0.3s;
}

.qty-btn:hover {
    background: #c48b9a;
    transform: scale(1.1);
}

.qty-input {
    width: 35px;
    text-align: center;
    border: none;
    background: transparent;
    font-weight: bold;
}

/* SUBTOTAL */
.subtotal {
    min-width: 120px;
    font-weight: bold;
    color: #d8a7b1;
    flex: 0 0 auto;
    text-align: right;
}

/* TOTAL */
.cart-total {
    margin-top: 20px;
    background: white;
    padding: 20px;
    border-radius: 15px;
}

.checkout-btn {
    width: 100%;
    padding: 12px;
    background: #d8a7b1;
    color: white;
    border: none;
    border-radius: 25px;
    cursor: pointer;
    font-weight: bold;
    transition: 0.3s;
}

.checkout-btn:hover {
    background: #c48b9a;
}
.cart-empty-btn:hover {
    background: #c48b9a;
    transform: translateY(-3px);
    box-shadow: 0 6px 20px rgba(216,167,177,0.4);
}

/* ================= RESPONSIVE ================= */

/* Tablet */
@media (max-width: 992px) {
    .cart-container {
        padding: 20px;
    }

    .cart-item {
        gap: 15px;
    }
}

/* HP */
@media (max-width: 768px) {

    .cart-item {
        flex-direction: column;
        align-items: stretch; /* 🔥 jangan flex-start */
    }

    .product-info {
        text-align: left;
    }

    .qty-wrapper {
        justify-content: center;
    }

    .subtotal {
        text-align: right;
        font-size: 16px;
        font-weight: bold;
    }
}

/* HP kecil */
@media (max-width: 480px) {

    .cart-title {
        font-size: 18px;
    }

    .product-info strong {
        font-size: 14px;
    }

    .product-info span {
        font-size: 13px;
    }

    .qty-btn {
        width: 25px;
        height: 25px;
    }

    .qty-input {
        width: 30px;
        font-size: 13px;
    }

    .subtotal {
        font-size: 14px;
    }
}

</style>

@section('scripts')
<script>

document.addEventListener("DOMContentLoaded", function() {

    const totalElement = document.getElementById('totalHarga');

    function hitungTotal() {
        let total = 0;

        document.querySelectorAll('.item-checkbox:checked').forEach(item => {
            const id = item.dataset.id;
            const price = parseInt(item.dataset.price);
            const qty = parseInt(document.getElementById('qty-' + id).value);
            total += price * qty;
        });

        if (totalElement) {
            totalElement.innerText = total.toLocaleString('id-ID');
        }
    }

    document.querySelectorAll('.item-checkbox').forEach(cb => {
        cb.addEventListener('change', hitungTotal);
    });

    window.changeQty = function(id, delta) {

        const qtyInput = document.getElementById('qty-' + id);
        const subtotalSpan = document.getElementById('subtotal-' + id);
        const checkbox = document.querySelector(`.item-checkbox[data-id="${id}"]`);
        const price = parseInt(checkbox.dataset.price);

        let newQty = parseInt(qtyInput.value) + delta;
        if (newQty < 1) return;

        qtyInput.value = newQty;
        subtotalSpan.innerText = (newQty * price).toLocaleString('id-ID');

        hitungTotal();

        fetch("{{ route('cart.update') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                id: id,
                quantity: newQty
            })
        });
    }

});

</script>
@endsection
