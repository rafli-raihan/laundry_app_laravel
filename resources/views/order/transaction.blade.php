<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laundromartinee | Point of Sale</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            color: #333;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        .header h1 {
            text-align: center;
            color: #4a5568;
            margin-bottom: 10px;
            font-size: 2.5em;
            font-weight: 700;
        }

        .header .subtitle {
            text-align: center;
            color: #718096;
            font-size: 1.1em;
        }

        .main-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        .card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .card h2 {
            color: #4a5568;
            margin-bottom: 20px;
            font-size: 1.8em;
            font-weight: 600;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
            color: #4a5568;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
        }

        .btn-success {
            background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
            color: white;
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(72, 187, 120, 0.3);
        }

        .btn-danger {
            background: linear-gradient(135deg, #f56565 0%, #e53e3e 100%);
            color: white;
        }

        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(245, 101, 101, 0.3);
        }

        .btn-warning {
            background: linear-gradient(135deg, #ed8936 0%, #dd6b20 100%);
            color: white;
        }

        .btn-warning:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(237, 137, 54, 0.3);
        }

        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
        }

        .service-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 12px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
        }

        .service-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 35px rgba(102, 126, 234, 0.4);
        }

        .service-card h3 {
            font-size: 1.2em;
            margin-bottom: 10px;
        }

        .service-card .price {
            font-size: 1.5em;
            font-weight: 700;
        }

        .cart-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .cart-table th,
        .cart-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }

        .cart-table th {
            background: #f7fafc;
            font-weight: 600;
            color: #4a5568;
        }

        .cart-table tr:hover {
            background: #f7fafc;
        }

        .total-section {
            background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
            color: white;
            padding: 20px;
            border-radius: 12px;
            margin-top: 20px;
        }

        .total-section h3 {
            font-size: 1.5em;
            margin-bottom: 10px;
        }

        .total-amount {
            font-size: 2.5em;
            font-weight: 700;
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.9em;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-pending {
            background: #fed7d7;
            color: #c53030;
        }

        .status-process {
            background: #feebc8;
            color: #dd6b20;
        }

        .status-ready {
            background: #c6f6d5;
            color: #2f855a;
        }

        .status-delivered {
            background: #bee3f8;
            color: #2b6cb0;
        }

        .transaction-list {
            max-height: 400px;
            overflow-y: auto;
        }

        .transaction-item {
            background: #f7fafc;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 10px;
            border-left: 4px solid #667eea;
        }

        .transaction-item h4 {
            color: #4a5568;
            margin-bottom: 5px;
        }

        .transaction-item p {
            color: #718096;
            margin-bottom: 5px;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(5px);
        }

        .modal-content {
            background: white;
            margin: 5% auto;
            padding: 30px;
            border-radius: 15px;
            width: 90%;
            max-width: 600px;
            max-height: 80vh;
            overflow-y: auto;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            line-height: 1;
        }

        .close:hover {
            color: #000;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
        }

        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 12px;
            text-align: center;
        }

        .stat-card h3 {
            font-size: 2em;
            margin-bottom: 10px;
        }

        .stat-card p {
            font-size: 1.1em;
            opacity: 0.9;
        }

        @media (max-width: 768px) {
            .main-content {
                grid-template-columns: 1fr;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .header h1 {
                font-size: 2em;
            }

            .services-grid {
                grid-template-columns: 1fr;
            }
        }

        .receipt {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            font-family: "Courier New", monospace;
        }

        .receipt-header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .receipt-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }

        .receipt-total {
            border-top: 2px solid #333;
            padding-top: 10px;
            margin-top: 10px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="mb-3" align="right">
                <a href="{{ route('dashboard.index') }}" class="btn btn-danger" style="text-decoration: none;">Keluar</a>
            </div>
            <h1>
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24">
                        <g fill="none" fill-rule="evenodd" clip-rule="evenodd">
                            <path fill="#020202"
                                d="M23.975 20.409c0-1.623-.06-3.276-.08-4.91V10.61c0-2.224-.09-4.649-.09-6.522V3.086c0-.35-.11-.922-.181-1.393v-.661a1 1 0 0 0-.13-.31A1.43 1.43 0 0 0 22.632.2A3.8 3.8 0 0 0 21.52 0h-3.777c-3.687.19-7.464.21-11.081.32c-1.633.04-3.226.11-4.73.211a.34.34 0 0 0-.32.36a.35.35 0 0 0 .32.321c1.283-.07 2.626-.11 4.008-.14c-.06.501-.16 1.002-.22 1.543q-.086.643-.08 1.292c.024.502.104 1 .24 1.483c-.921.1-1.823.21-2.735.26q-1.077.075-2.154 0c0-.47 0-.931.05-1.332V2.314c0-.43.05-.861.11-1.292a.29.29 0 0 0-.22-.36a.29.29 0 0 0-.33.25c-.07.44-.11.901-.141 1.352c0 .672 0 1.343-.07 2.004C.39 4.74.34 5.27.31 5.841c0 .872-.07 1.814-.1 2.745c-.03.932-.05 2.094 0 2.926c.05.831 0 1.653 0 2.465s0 1.522-.06 2.454l-.1 3.006c0 .661-.07 2.174 0 3.096c-.017.364.048.726.19 1.062c.348.237.76.363 1.182.36c1.162.1 3.106 0 3.577 0l2.675-.13h1.603c1.282 0 2.595.06 3.827 0h5.01c.7 0 1.422 0 2.194-.08c.43 0 1.843 0 2.444-.06c.217-.017.425-.093.601-.22c.268-.295.445-.66.511-1.052q.147-.998.11-2.004M17.773.932h1.853l1.844.07q.375.012.741.09c.16.021.305.1.411.22v.592c.05.38.1.741.13 1.112q.056.545.05 1.092V5.85c-2.665-.16-5.34-.48-8.015-.631c-.691 0-1.382-.06-2.064-.07c0-.501.08-1.002.12-1.483q.037-.556 0-1.112a8.6 8.6 0 0 0-.2-1.553c1.713 0 3.427 0 5.13-.07m-11.101.12l5.28-.05c-.05.42-.12.842-.16 1.262a6 6 0 0 0 0 .702v.701q.04.725.16 1.443h-.802c-.831 0-1.663 0-2.494.05c-.561 0-1.133.06-1.694.11h-.26V4.098c0-.401.06-.832.06-1.253a10.6 10.6 0 0 0-.19-1.813zm16.15 9.558c0 1.002 0 1.934-.07 2.765s0 1.413 0 2.134c0 1.623.07 3.277.05 4.89q.043.816 0 1.633a1.4 1.4 0 0 1-.15.59c-.591.071-2.004 0-2.394.061c-.742.05-1.443.07-2.124.08c-1.664 0-3.216-.06-5.01 0H9.317c-.561 0-1.122 0-1.663.07l-2.715.15H2.754a12 12 0 0 1-1.683-.07h-.14v-.05c-.06-.801 0-2.665 0-3.406l.05-3.006v-2.475c0-.75-.05-1.542-.05-2.424V8.656c0-.811 0-1.643.05-2.414q1.086.162 2.184.16c1.954 0 1.002-.11 8.015-.14h3.557c2.695.07 5.39.21 8.075.23c0 1.363.02 2.776.01 4.118" />
                            <path fill="#020202"
                                d="M18.324 12.333a7 7 0 0 0-1.002-2.304a4.74 4.74 0 0 0-1.883-1.703a4 4 0 0 0-.862-.31q-.646-.12-1.303-.151a.35.35 0 0 0-.32.35a.34.34 0 0 0 .31.361q.616.049 1.223.17q.368.075.701.251c.639.338 1.17.848 1.533 1.473a6.3 6.3 0 0 1 .791 2.004c.15.724.19 1.467.12 2.204a6.3 6.3 0 0 1-.53 2.104a6.5 6.5 0 0 1-2.275 2.725a5 5 0 0 1-3.316.882a6.2 6.2 0 0 1-3.366-1.473A5.8 5.8 0 0 1 6.28 15.8a5.8 5.8 0 0 1 .08-2.545a7 7 0 0 1 .922-2.404a5 5 0 0 1 1.833-1.834a5.1 5.1 0 0 1 2.646-.47a.3.3 0 0 0 .247-.5a.3.3 0 0 0-.207-.102a5.7 5.7 0 0 0-3.006.44a5.7 5.7 0 0 0-2.254 2.075a8.48 8.48 0 0 0-1.313 5.57a6.43 6.43 0 0 0 2.124 3.798a7.25 7.25 0 0 0 4.008 1.753a6 6 0 0 0 4.078-1.092a7.5 7.5 0 0 0 2.524-3.266a7.4 7.4 0 0 0 .531-2.435a8.4 8.4 0 0 0-.17-2.455" />
                            <path fill="#0c6fff"
                                d="M7.313 14.307c.26-.108.543-.146.822-.11q.414.06.811.19c.551.17 1.092.421 1.643.641q.887.375 1.824.592a6.35 6.35 0 0 0 3.296-.31a4.9 4.9 0 0 0 1.563-1.003c.27-.38.07-1.002-.32-.791a4.5 4.5 0 0 1-1.544.851a5.5 5.5 0 0 1-2.755.09c-1.002-.19-2.004-.68-3.005-1.002a5.8 5.8 0 0 0-1.463-.23a2.35 2.35 0 0 0-.932.18q-.314.092-.581.281c-.42.28-.471.862-.14.892q.381-.16.781-.27" />
                            <path fill="#020202"
                                d="M17.292 3.507c.38.06.731.16 1.122.2h.491l.481-.06a10 10 0 0 0 1.132-.31a.33.33 0 0 0 .29-.331a.34.34 0 0 0-.38-.3c-.38 0-.751-.081-1.142-.091a5 5 0 0 0-.762 0q-.647.12-1.272.33a.3.3 0 0 0-.28.321a.3.3 0 0 0 .32.24" />
                        </g>
                    </svg>
                    <h5>Laundromartinee</h5>
                </span>
            </h1>
            <p class="subtitle">
                Point of Sales System - Kelola Transaksi Laundry dengan Mudah
            </p>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Left Panel: New Transaction -->
            <div class="card">
                <h2>Transaksi Baru</h2>

                <form id="transactionForm">
                    <div class="form-group">
                        <label for="customerName">Nama Pelanggan</label>
                        {{-- <input type="text" id="customerName" required /> --}}
                        <select id="customerName" required>
                            <option value="">Pilih Pelanggan</option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->customer_name }}" data-phone="{{ $customer->phone }}"
                                    data-address="{{ $customer->address }}" data-id-customer="{{ $customer->id }}">
                                    {{ $customer->customer_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <input type="hidden" id="customerId">

                    <div class="form-row">
                        <div class="form-group">
                            <label for="customerPhone">No. Telepon</label>
                            <input type="tel" id="customerPhone" readonly />
                        </div>
                        <div class="form-group">
                            <label for="customerAddress">Alamat</label>
                            <input type="text" id="customerAddress" readonly />
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Pilih Layanan</label>
                        <div class="services-grid">
                            {{-- @dd($services) --}}
                            @foreach ($services as $service)
                                <button type="button" class="service-card"
                                    onclick="addService('{{ $service->service_name }}', '{{ $service->price }}')">
                                    <h3>{{ $service->service_name }}</h3>
                                    <div class="price">Rp {{ number_format($service->price, 0, ',', '.') }}</div>
                                </button>
                            @endforeach

                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="serviceWeight">Berat/Kg</label>
                            <input type="number" id="serviceWeight" step="0.1" min="0.1" required />
                        </div>
                        <div class="form-group">
                            <label for="serviceType">Jenis Layanan</label>
                            <select id="serviceType" required>
                                <option value="">Pilih Layanan</option>
                                @foreach ($services as $service)
                                    <option value="{{ $service->service_name }}" data-id="{{ $service->id }}">
                                        {{ $service->service_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="notes">Catatan</label>
                        <textarea id="notes" rows="3" placeholder="Catatan khusus untuk pesanan..."></textarea>
                    </div>

                    <button type="button" class="btn btn-primary" onclick="addToCart()"
                        style="width: 100%; margin-bottom: 10px">
                        + Tambah ke Keranjang
                    </button>
                </form>

                <!-- Cart -->
                <div id="cartSection" style="display: none">
                    <h3>Keranjang Belanja</h3>
                    <table class="cart-table">
                        <thead>
                            <tr>
                                <th>Layanan</th>
                                <th>Qty</th>
                                <th>Harga</th>
                                <th>Subtotal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="cartItems"></tbody>
                    </table>

                    <div class="form-row" style="margin-top: 15px">
                        <div class="form-group">
                            <label for="orderPay">Bayar (Rp)</label>
                            <input type="number" id="orderPay" min="0" required />
                        </div>
                        <div class="form-group">
                            <label for="orderChange">Kembalian (Rp)</label>
                            <input type="number" id="orderChange" min="0" required readonly />
                        </div>
                    </div>

                    <div class="total-section">
                        <h3>Total Pembayaran</h3>
                        <div class="total-amount" id="totalAmount">Rp 0</div>
                        <h3 style="margin-top: 1rem;">Pajak</h3>
                        <div class="total-amount" id="taxAmount">Rp. 0</div>
                        <button class="btn btn-success" onclick="processTransaction()"
                            style="width: 100%; margin-top: 15px">
                            Bayar & Proses Transaksi
                        </button>
                    </div>
                </div>
            </div>

            <!-- Right Panel: Transaction History -->
            <div class="card">
                <h2>Riwayat Transaksi</h2>
                <div class="transaction-list" id="transactionHistory">
                    {{-- <div class="transaction-item">
                        <h4>TRX-001 - John Doe</h4>
                        <p>📞 0812-3456-7890</p>
                        <p>🛍️ Cuci Setrika - 2.5kg</p>
                        <p>💰 Rp 17.500</p>
                        <p>📅 13 Juli 2025, 14:30</p>
                        <span class="status-badge status-process">Proses</span>
                    </div>
                    <div class="transaction-item">
                        <h4>TRX-002 - Jane Smith</h4>
                        <p>📞 0813-7654-3210</p>
                        <p>🛍️ Cuci Kering - 3kg</p>
                        <p>💰 Rp 15.000</p>
                        <p>📅 13 Juli 2025, 13:15</p>
                        <span class="status-badge status-ready">Siap</span>
                    </div> --}}
                </div>

                <button class="btn btn-warning" onclick="showAllTransactions()"
                    style="width: 100%; margin-top: 15px">
                    Lihat Semua Transaksi
                </button>
            </div>
        </div>

        <!-- Action Buttons -->
        <div style="text-align: center; margin-top: 20px">
            <button class="btn btn-primary" onclick="showReports()" style="margin: 0 10px">
                Laporan Penjualan
            </button>
            <button class="btn btn-danger" onclick="clearCart()" style="margin: 0 10px">
                X Bersihkan Keranjang
            </button>
        </div>
    </div>

    <!-- Modal for Transaction Details -->
    <div id="transactionModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <div id="modalContent"></div>
        </div>
    </div>

    <script>
        let cart = [];
        let transactions = [];
        let transactionCounter = transactions.length + 1;

        // ini buat kalo milih customer, langsung munculin nomor telepon dan alamatnya
        document.getElementById("customerName").addEventListener("change", function() {
            const selected = this.options[this.selectedIndex];
            document.getElementById("customerPhone").value = selected.getAttribute("data-phone") || "";
            document.getElementById("customerAddress").value = selected.getAttribute("data-address") || "";
            document.getElementById("customerId").value = selected.getAttribute("data-id-customer") || "";
        });

        /* Shopping Cart Functions */
        function addService(serviceName, price) {
            document.getElementById("serviceType").value = serviceName;
            document.getElementById("serviceWeight").focus();
        }

        // Update addToCart function to handle decimal with comma
        function addToCart() {
            const serviceType = document.getElementById("serviceType").value;
            const weightValue = document.getElementById("serviceWeight").value;
            const weight = parseDecimal(weightValue);
            const notes = document.getElementById("notes").value;

            if (!serviceType || !weightValue || weight <= 0) {
                alert("Mohon lengkapi semua field yang diperlukan!");
                return;
            }

            const services = @json($services);
            const service = services.find(service => service.service_name === serviceType)

            const price = parseFloat(service.price);
            const subtotal = price * weight;

            const item = {
                id: Date.now(),
                id_service: service.id,
                service: serviceType,
                weight: weight,
                price: price,
                subtotal: subtotal,
                notes: notes,
            };

            cart.push(item);
            updateCartDisplay();

            // Clear form
            document.getElementById("serviceType").value = "";
            document.getElementById("serviceWeight").value = "";
            document.getElementById("notes").value = "";
        }

        // Update cart display to show decimal properly
        function updateCartDisplay() {
            const cartItems = document.getElementById("cartItems");
            const cartSection = document.getElementById("cartSection");
            const totalAmount = document.getElementById("totalAmount");
            const taxAmount = document.getElementById("taxAmount");

            if (cart.length === 0) {
                cartSection.style.display = "none";
                return;
            }

            cartSection.style.display = "block";

            let html = "";
            let total = 0;

            cart.forEach((item) => {
                const unit = item.service.includes("Sepatu") ?
                    "pasang" :
                    item.service.includes("Karpet") ?
                    "m²" :
                    "kg";

                // Format weight to show decimal properly
                const formattedWeight =
                    item.weight % 1 === 0 ?
                    item.weight.toString() :
                    item.weight.toFixed(1).replace(".", ",");

                html += `
                    <tr>
                        <td>${item.service}</td>
                        <td>${formattedWeight} ${unit}</td>
                        <td>Rp ${item.price.toLocaleString()}</td>
                        <td>Rp ${item.subtotal.toLocaleString()}</td>
                        <td>
                            <button class="btn btn-danger" onclick="removeFromCart(${
                              item.id
                            })" style="padding: 5px 10px; font-size: 12px;">
                                🗑️
                            </button>
                        </td>
                    </tr>
                `;
                total += item.subtotal;
            });

            cartItems.innerHTML = html;

            pajak = total * 0.05;
            totalAmount.textContent = `Rp ${total.toLocaleString()}`;
            taxAmount.textContent = `Rp ${pajak.toLocaleString()}`

        }

        function removeFromCart(itemId) {
            cart = cart.filter((item) => item.id !== itemId);
            updateCartDisplay();
        }

        function clearCart() {
            cart = [];
            updateCartDisplay();
            document.getElementById("transactionForm").reset();
        }

        function showReceipt(transaction) {
            const receiptHtml = `
                <div class="receipt">
                    <div class="receipt-header">
                        <h2>🧺 LAUNDRY RECEIPT</h2>
                        <p>ID: ${transaction.id}</p>
                        <p>Tanggal: ${new Date(transaction.date).toLocaleString(
                          "id-ID"
                        )}</p>
                    </div>

                    <div style="margin-bottom: 20px;">
                        <strong>Pelanggan:</strong><br>
                        ${transaction.customer.name}<br>
                        $ ${formatPhoneNumberDynamic(transaction.customer.phone)}<br>
                        ${transaction.customer.address}
                    </div>

                    <div style="margin-bottom: 20px;">
                        <strong>Detail Pesanan:</strong><br>
                        ${transaction.items
                          .map(
                            (item) => `
                                                                                                                                                                                                                                                                            <div class="receipt-item">
                                                                                                                                                                                                                                                                                <span>${item.service} (${item.weight} ${
                                                                                                                                                                                                                                                                              item.service.includes("Sepatu")
                                                                                                                                                                                                                                                                                ? "pasang"
                                                                                                                                                                                                                                                                                : item.service.includes("Karpet")
                                                                                                                                                                                                                                                                                ? "m²"
                                                                                                                                                                                                                                                                                : "kg"
                                                                                                                                                                                                                                                                            })</span>
                                                                                                                                                                                                                                                                                <span>Rp ${item.subtotal.toLocaleString()}</span>
                                                                                                                                                                                                                                                                            </div>
                                                                                                                                                                                                                                                                        `
                          )
                          .join("")}

                          <div class="receipt-item">
                            <span>PAJAK:</span>
                            <span>5%</span>
                        </div>
                    </div>

                    <div class="receipt-total">
                        <div class="receipt-item">
                            <span>TOTAL:</span>
                            <span>Rp ${transaction.total.toLocaleString()}</span>
                        </div>
                    </div>

                    <div style="text-align: center; margin-top: 20px;">
                        <p>Terima kasih atas kepercayaan Anda!</p>
                        <p>Barang akan siap dalam 1-2 hari kerja</p>
                    </div>
                </div>

                <div style="text-align: center; margin-top: 20px;">
                    <button class="btn btn-primary" onclick="printReceipt()">🖨️ Cetak Struk</button>
                    <button class="btn btn-success" onclick="closeModal()">✅ Selesai</button>
                </div>
            `;

            document.getElementById("modalContent").innerHTML = receiptHtml;
            document.getElementById("transactionModal").style.display = "block";
        }

        function printReceipt() {
            window.print();
        }
        /* End Shopping Cart Functions */


        /* Trans Order, Details, Pickup Begin */
        async function processTransaction() {
            const customerName = document.getElementById("customerName").value;
            const customerPhone = document.getElementById("customerPhone").value;
            const customerId = document.getElementById("customerId").value;
            const customerAddress = document.getElementById("customerAddress").value;
            const orderPay = parseInt(document.getElementById("orderPay").value) || 0;
            const orderChange = parseInt(document.getElementById("orderChange").value) || 0;

            if (!customerName || !customerPhone || cart.length === 0) {
                alert("Mohon lengkapi data pelanggan dan pastikan ada item di keranjang!");
                return;
            }
            if (orderPay < cart.reduce((sum, item) => sum + item.subtotal, 0)) {
                alert("Nominal bayar kurang dari total pembayaran!");
                return;
            }

            const total = cart.reduce((sum, item) => sum + item.subtotal, 0);

            const transaction = {
                id: `TRX-${transactionCounter.toString().padStart(3, "0")}`,
                customer: {
                    id: customerId,
                    name: customerName,
                    phone: customerPhone,
                    address: customerAddress,
                },
                items: [...cart],
                total: total + (total * 0.05),
                order_pay: orderPay,
                order_change: orderChange,
                date: new Date().toISOString(),
                status: 0,
            };

            //masuk ke database
            try {
                const res = await fetch("{{ route('order.store') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute(
                            "content")
                    },
                    body: JSON.stringify(transaction)
                })

                if (!res.ok) {
                    throw new Error(`HTTP error!! Status: ${res.status}`)
                }

                const result = await res.json();
                alert("Transaksi berhasil disimpan!");

                // Show Receipt
                showReceipt(transaction);
                transactionCounter++;

                // Clear form and cart
                clearCart();
                updateTransactionHistory();
                updateStats();
            } catch (error) {
                console.error("Gagal Menyimpan Data Transaksi: ", error)
            }
        }

        function updateTransactionHistory() {
            const historyContainer = document.getElementById("transactionHistory");
            const recentTransactions = transactions.slice(-5).reverse();
            console.log(recentTransactions)

            const html = recentTransactions
                .map(
                    (transaction) => `
                <div class="transaction-item">
                    <h4>${transaction.order_code} - ${transaction.customer.customer_name}</h4>
                    <p>📞${formatPhoneNumberDynamic(transaction.customer.phone)}</p>
                    <p>🛍️ ${transaction.details
                      .map(
                        (item) =>
                          `${item.service.service_name} - ${item.qty}kg
                                                                                                                                                                                                                                                                          `
                      )
                      .join(", ")}</p>
                    <p>💰 Rp ${transaction.total.toLocaleString()}</p>
                    <p>📅 ${new Date(transaction.order_date).toLocaleString(
                      "id-ID"
                    )}</p>
                    <span class="status-badge status-${
                      transaction.order_status == 0
                        ? "pending"
                        : transaction.order_status == 1
                        ? "delivered"
                        : ""
                    }">${
                        transaction.order_status == 0
                        ? "Baru"
                        : transaction.order_status == 1
                        ? "Sudah diambil"
                        : ""
                    }</span>
                </div>
            `
                )
                .join("");

            historyContainer.innerHTML = html || "<p>Belum ada transaksi</p>";
        }

        function showAllTransactions() {
            const allTransactionsHtml = `
                <h2>Semua Transaksi</h2>
                <div style="max-height: 400px; overflow-y: auto;">
                    ${transactions
                      .map(
                        (transaction) => `
                                                                                                                                                                                                                                                                        <div class="transaction-item">
                                                                                                                                                                                                                                                                            <h4>${transaction.order_code} - ${
                                                                                                                                                                                                                                                                          transaction.customer.customer_name
                                                                                                                                                                                                                                                                        }</h4>
                                                                                                                                                                                                                                                                            <p>📞 ${formatPhoneNumberDynamic(transaction.customer.phone)}</p>
                                                                                                                                                                                                                                                                            <p>🛍️ ${transaction.details
                                                                                                                                                                                                                                                                              .map(
                                                                                                                                                                                                                                                                                (item) =>
                                                                                                                                                                                                                                                                      `${item.service.service_name} - ${item.qty}kg
                      `
                                                                                                                                                                                                                                                                              )
                                                                                                                                                                                                                                                                              .join(", ")}</p>
                                                                                                                                                                                                                                                                            <p>💰 Rp ${transaction.total.toLocaleString()}</p>
                                                                                                                                                                                                                                                                            <p>📅 ${new Date(transaction.order_date).toLocaleString(
                                                                                                                                                                                                                                                                              "id-ID"
                                                                                                                                                                                                                                                                            )}</p>
                                                                                                                                                                                                                                                                            <span class="status-badge status-${
                                                                                                                                                                                                                                                                              transaction.order_status == 0
                                                                                                                                                                                                                                                                                ? "pending"
                                                                                                                                                                                                                                                                                : transaction.order_status == 1
                                                                                                                                                                                                                                                                                ? "delivered"
                                                                                                                                                                                                                                                                                : ""
                                                                                                                                                                                                                                                                            }">${
                                                                                                                                                                                                                                                                              transaction.order_status == 0
                                                                                                                                                                                                                                                                                ? "Baru"
                                                                                                                                                                                                                                                                                : transaction.order_status == 1
                                                                                                                                                                                                                                                                                ? "Sudah diambil"
                                                                                                                                                                                                                                                                                : ""
                                                                                                                                                                                                                                                                            }</span>
                                                                                                                                                                                                                                                                            <button
                                                                                                                                                                                                                                                                            class="btn btn-primary" onclick="updateTransactionStatus('${ transaction.id }')"
                                                                                                                                                                                                                                                                            style="margin-top: 10px; padding: 5px 15px; font-size: 12px;"
                                                                                                                                                                                                                                                                            ${transaction.order_status == 1 ? "hidden" : ""}>
                                                                                                                                                                                                                                                                                Selesaikan Transaksi
                                                                                                                                                                                                                                                                            </button>
                                                                                                                                                                                                                                                                        </div>
                                                                                                                                                                                                                                                                    `
                      )
                      .join("")}
                </div>
            `;

            document.getElementById("modalContent").innerHTML = allTransactionsHtml;
            document.getElementById("transactionModal").style.display = "block";
        }

        async function updateTransactionStatus(transactionId) {
            try {
                const res = await fetch(`/order-json/${transactionId}`, {
                    method: "GET",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute(
                            "content")
                    },
                });
                if (!res.ok) throw new Error("Gagal mengambil data transaksi");
                const transaction = await res.json();

                const customerId = transaction.customer.id; // ambil customerId

                const statusOptions = [{
                        value: "0",
                        text: "Baru"
                    },
                    {
                        value: "1",
                        text: "Sudah diambil"
                    }
                ];

                const statusHtml = `
                    <h2>📝 Update Status Transaksi</h2>
                    <h3>${transaction.order_code} - ${transaction.customer.customer_name}</h3>
                    <p>Status saat ini: <span class="status-badge status-${transaction.order_status}">
                        ${transaction.order_status == 0 ? "Baru" : transaction.order_status == 1 ? "Sudah diambil" : ""}
                    </span></p>
                    <div class="form-group">
                        <label>Pilih Status Baru:</label>
                        <select id="newStatus" style="width: 100%; padding: 10px; margin: 10px 0;">
                            ${statusOptions.map(option => `
                                                                                                                                                                                                                                                                        <option value="${option.value}" ${transaction.order_status == option.value ? "selected" : ""}>
                                                                                                                                                                                                                                                                            ${option.text}
                                                                                                                                                                                                                                                                        </option>
                                                                                                                                                                                                                                                                    `).join("")}
                        </select>
                        <label>Catatan:</label>
                        <textarea id="pickupNotes" rows="3" style="width: 100%; padding: 10px; margin: 10px 0;" placeholder="Catatan tambahan..."></textarea>
                    </div>
                    <div style="text-align: center; margin-top: 20px;">
                        <button class="btn btn-success" onclick="saveStatusUpdate('${transactionId}')">
                            Simpan Perubahan
                        </button>
                        <button class="btn btn-danger" onclick="closeModal()" style="margin-left: 10px;">
                            Batal
                        </button>
                    </div>
                `;

                document.getElementById("modalContent").innerHTML = statusHtml;
                document.getElementById("transactionModal").style.display = "block";

                // Simpan customerId di elemen modal agar bisa diakses di saveStatusUpdate
                document.getElementById("transactionModal").setAttribute("data-customer-id", customerId);
            } catch (error) {
                alert("Gagal mengambil data transaksi!");
                console.error(error);
            }
        }

        async function saveStatusUpdate(transactionId) {
            const newStatus = document.getElementById("newStatus").value;
            // jd dibawah ini ambil customerId sm pickupNotes ambil dari innerHTML modal di fungsi atas
            const customerId = document.getElementById("transactionModal").getAttribute("data-customer-id");
            const pickupNotes = document.getElementById("pickupNotes").value;
            try {
                const res = await fetch(`/order-json-update-status/${transactionId}`, {
                    method: "PUT",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute(
                            "content")
                    },
                    body: JSON.stringify({
                        order_status: newStatus
                    })
                });
                if (!res.ok) throw new Error("Gagal update status transaksi");
                alert("Status berhasil diupdate!");

                // Jika status sudah diambil (1), tambahkan data pickup
                if (parseInt(newStatus) === 1) {
                    await addTransPickupData(transactionId, customerId, pickupNotes);
                }

                closeModal();
                await loadOrders();
            } catch (error) {
                alert("Gagal update status transaksi!");
                console.error(error);
            }
        }

        async function addTransPickupData(transactionId, customerId, pickupNotes) {
            const trans_pickup = {
                id_order: transactionId,
                id_customer: customerId,
                notes: pickupNotes
            };

            try {
                const res = await fetch(`/submit-pickup/`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute(
                            "content")
                    },
                    body: JSON.stringify(trans_pickup)
                });
                if (!res.ok) throw new Error("Gagal menyimpan data pickup");
                const result = await res.json();
                // Optional: alert(result.message);
            } catch (error) {
                console.error("Gagal menyimpan data pickup:", error);
            }
        }
        /* END Trans Order, Details, Pickup */


        /* Statistics and Reports */
        function updateStats() {
            const totalTransactions = transactions.length;
            const totalRevenue = transactions.reduce((sum, t) => sum + t.total, 0);
            const activeOrders = transactions.filter(
                (t) => t.status !== 1
            ).length;
            const completedOrders = transactions.filter(
                (t) => t.status === 1
            ).length;

            document.getElementById("totalTransactions").textContent =
                totalTransactions;
            document.getElementById(
                "totalRevenue"
            ).textContent = `Rp ${totalRevenue.toLocaleString()}`;
            document.getElementById("activeOrders").textContent = activeOrders;
            document.getElementById("completedOrders").textContent =
                completedOrders;
        }

        function showReports() {
            const today = new Date();
            const thisMonth = today.getMonth();
            const thisYear = today.getFullYear();

            const monthlyTransactions = transactions.filter((t) => {
                const tDate = new Date(t.order_date);
                return (
                    tDate.getMonth() === thisMonth && tDate.getFullYear() === thisYear
                );
            });

            const monthlyRevenue = monthlyTransactions.reduce(
                (sum, t) => sum + t.total,
                0
            );
            console.log(transactions);

            const serviceStats = {};
            transactions.forEach((t) => {
                t.details.forEach((item) => {
                    const serviceName = item.service.service_name; // ambil nama layanan

                    if (!serviceStats[serviceName]) {
                        serviceStats[serviceName] = {
                            count: 0,
                            revenue: 0
                        };
                    }

                    serviceStats[serviceName].count += item.qty; // jumlah order per layanan
                    serviceStats[serviceName].revenue += item.subtotal; // total pendapatan
                });
            });
            console.log("A", serviceStats)

            const reportsHtml = `
                <h2>📈 Laporan Penjualan</h2>

                <div class="stats-grid" style="margin-bottom: 20px;">
                    <div class="stat-card">
                        <h3>${transactions.length}</h3>
                        <p>Total Transaksi</p>
                    </div>
                    <div class="stat-card">
                        <h3>${monthlyTransactions.length}</h3>
                        <p>Transaksi Bulan Ini</p>
                    </div>
                    <div class="stat-card">
                        <h3>Rp ${monthlyRevenue.toLocaleString()}</h3>
                        <p>Pendapatan Bulan Ini</p>
                    </div>
                </div>

                <h3>📊 Statistik Layanan</h3>
                <table class="cart-table">
                    <thead>
                        <tr>
                            <th>Layanan</th>
                            <th>Jumlah Order</th>
                            <th>Total Pendapatan</th>
                        </tr>
                    </thead>
                    <tbody>
                         ${Object.entries(serviceStats).map(([service, stats]) => `
                                                                                                                                                                                                                                                                    <tr>
                                                                                                                                                                                                                                                                        <td>${service}</td>
                                                                                                                                                                                                                                                                        <td>${stats.count}</td>
                                                                                                                                                                                                                                                                        <td>Rp ${stats.revenue.toLocaleString()}</td>
                                                                                                                                                                                                                                                                    </tr>
                                                                                                                                                                                                                                                                `).join('')}
                    </tbody>
                </table>
            `;

            document.getElementById("modalContent").innerHTML = reportsHtml;
            document.getElementById("transactionModal").style.display = "block";
        }

        function closeModal() {
            document.getElementById("transactionModal").style.display = "none";
        }
        /* End Statistics and Reports */


        /* Formater and Parsers */
        function formatPhoneNumberDynamic(number) {
            return number.match(/.{1,4}/g).join("-");
        }

        function formatDateYMD(date = new Date()) {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');

            return `${year}${month}${day}`;
        }

        function formatNumber(input) {
            // Replace comma with dot for decimal separator
            let value = input.value.replace(",", ".");

            // Ensure only valid decimal number
            if (!/^\d*\.?\d*$/.test(value)) {
                value = value.slice(0, -1);
            }

            // Update input value
            input.value = value;
        }

        function parseDecimal(value) {
            // Handle both comma and dot as decimal separator
            return parseFloat(value.toString().replace(",", ".")) || 0;
        }
        /* End Formater and Parsers */


        // Initialize the application
        document.addEventListener("DOMContentLoaded", function() {
            updateTransactionHistory();
            updateStats();

            // Add event listener for weight input to handle decimal with comma
            const weightInput = document.getElementById("serviceWeight");
            weightInput.addEventListener("input", function() {
                formatNumber(this);
            });

            // Close modal when clicking outside
            window.onclick = function(event) {
                const modal = document.getElementById("transactionModal");
                if (event.target === modal) {
                    closeModal();
                }
            };
        });

        // load db transaction
        async function loadOrders() {
            try {
                const response = await fetch('/order-json', {
                    method: "GET",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute(
                            "content")
                    },
                });
                const data = await response.json();

                console.log(data); // lihat isi datanya

                transactions = data
                transactionCounter = transactions.length + 1

                updateTransactionHistory();
                updateStats();


            } catch (error) {
                console.error("Gagal load orders:", error);
            }
        }

        // panggil saat halaman load
        document.addEventListener("DOMContentLoaded", loadOrders);

        // Hitung kembalian saat input bayar
        document.getElementById("orderPay").addEventListener("input", function() {
            const total = cart.reduce((sum, item) => sum + item.subtotal, 0);
            const pajak = total * 0.05; 
            const totalBayar = total + pajak;
            const bayar = parseInt(this.value) || 0;
            const kembalian = bayar - totalBayar;
            document.getElementById("orderChange").value = kembalian > 0 ? kembalian : 0;
        });
    </script>

</body>

</html>
