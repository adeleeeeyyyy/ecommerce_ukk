@extends('layouts.app')

@section('content')

<div class="checkout-container">

    <h2 class="checkout-title">Data Pengiriman 🚚</h2>

    <form action="{{ route('checkout.process') }}" method="GET">
        @csrf

        <input type="hidden" name="final_total" value="{{ $total }}">

        {{-- RINGKASAN --}}
        <div class="order-summary">
            <label class="section-label">Ringkasan Pesanan</label>

            <div class="order-box">
                @foreach($carts as $index => $cart)

                <input type="hidden" name="items[{{ $index }}][product_id]" value="{{ $cart->product_id }}">
                <input type="hidden" name="items[{{ $index }}][qty]" value="{{ $cart->quantity }}">
                <input type="hidden" name="items[{{ $index }}][price]" value="{{ $cart->product->price }}">

                <div class="order-item">

                    <img src="{{ asset('images/products/'.$cart->product->image) }}">

                    <div class="info">
                        <div class="name">{{ $cart->product->name }}</div>
                        <div class="qty">
                            {{ $cart->quantity }} x Rp {{ number_format($cart->product->price) }}
                        </div>
                    </div>

                    <div class="price">
                        Rp {{ number_format($cart->product->price * $cart->quantity) }}
                    </div>

                </div>
                @endforeach
            </div>
        </div>

        {{-- NAMA --}}
        <div class="form-group">
            <label>Nama Lengkap</label>
            <input type="text" name="nama" required minlength="3" placeholder="Masukkan nama penerima">
        </div>

        {{-- NO HP --}}
        <div class="form-group">
            <label>Nomor HP / WhatsApp</label>
            <input type="tel" name="no_hp" required placeholder="08xxxxxxxxxx">
        </div>

        {{-- ALAMAT --}}
        <div class="form-group">
            <label>Alamat Pengiriman</label>
            <textarea name="alamat" rows="4" required placeholder="Alamat lengkap..."></textarea>
        </div>

        {{-- TOTAL --}}
        <div class="total-box">
            <span>Total Pembayaran:</span>
            <strong>Rp {{ number_format($total) }}</strong>
        </div>

        <button type="submit" class="checkout-btn">
            Konfirmasi Pesanan
        </button>

    </form>
</div>


@endsection

<style>
.checkout-container {
    font-family: 'Poppins', sans-serif;
    background: #fffafb;
    padding: 30px;
    border-radius: 20px;
    width: 100%;
    max-width: 900px; /* 🔥 diperlebar */
    margin: 40px auto;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
}

/* TITLE */
.checkout-title {
    text-align: center;
    color: #d8a7b1;
    margin-bottom: 25px;
}

/* LABEL */
.section-label {
    display: block;
    margin-bottom: 10px;
    font-weight: bold;
    color: #b08968;
}

/* ORDER BOX */
.order-box {
    background: white;
    border-radius: 15px;
    border: 1px solid #fce4ec;
    overflow: hidden;
}

/* ITEM */
.order-item {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 12px;
    border-bottom: 1px solid #fce4ec;
    flex-wrap: wrap; /* 🔥 biar tidak ngecil */
}

/* IMAGE */
.order-item img {
    width: 60px;
    height: 60px;
    border-radius: 10px;
    object-fit: cover;
    flex: 0 0 60px;
}

/* INFO */
.info {
    flex: 1;
    min-width: 150px;
}

.name {
    font-weight: 500;
}

.qty {
    font-size: 13px;
    color: #888;
}

/* PRICE */
.price {
    font-weight: bold;
    color: #d8a7b1;
    flex: 0 0 auto;
}

/* FORM */
.form-group {
    margin-top: 15px;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
    color: #b08968;
}

.form-group input,
.form-group textarea {
    width: 100%;
    padding: 12px;
    border-radius: 10px;
    border: 1px solid #fce4ec;
    outline: none;
}

/* TOTAL */
.total-box {
    margin-top: 20px;
    padding: 15px;
    background: #fdf2f4;
    border-radius: 10px;
    display: flex;
    justify-content: space-between;

}

/* BUTTON */
.checkout-btn {
    margin-top: 20px;
    width: 100%;
    padding: 15px;
    border-radius: 30px;
    border: none;
    background: #d8a7b1;
    color: white;
    font-weight: bold;
    cursor: pointer;
}

/* ================= MOBILE ================= */
@media (max-width: 768px) {

    .checkout-container {
        padding: 20px;
        margin: 20px;
    }



    .order-item {
        flex-direction: column;
        align-items: flex-start;
    }

    .price {
        width: 100%;
        text-align: right;
    }
}
</style>
