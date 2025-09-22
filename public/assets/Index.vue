<script setup lang="ts">
import { ref, reactive, computed, onMounted } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { kasir_customers, kasir_services, kasir_store, customers_register } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import Button from '@/components/ui/button/Button.vue';

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Kasir', href: '#' },
];

type Customer = { id: number; customer_name: string; phone?: string; address?: string };
type Service = { id: number; service_name: string; price: number };
type CartItem = {
    id_service: number;
    service_name: string;
    price: number;
    qty: number;
    subtotal: number;
};

const customers = ref<Customer[]>([]);
const services = ref<Service[]>([]);
const selectedCustomer = ref<number | null>(null);
const selectedService = ref<number | null>(null);
const qty = ref<number>(1);
const cart = reactive<CartItem[]>([]);
const orderPay = ref<number | null>(null);
const loading = ref(false);
const errors = ref<Record<string, string[]>>({});

const today = new Date().toISOString().slice(0, 10);

const total = computed(() => cart.reduce((s, i) => s + i.subtotal, 0));
const change = computed(() => {
    if (orderPay.value == null) return 0;
    return Math.max(0, Number(orderPay.value) - Number(total.value));
});

function getCsrf(): string {
    return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ?? '';
}

async function fetchData() {
    try {
        const [cRes, sRes] = await Promise.all([
            fetch(kasir_customers().url, { credentials: 'same-origin' }),
            fetch(kasir_services().url, { credentials: 'same-origin' }),
        ]);
        if (cRes.ok) customers.value = await cRes.json();
        if (sRes.ok) services.value = await sRes.json();
    } catch (e) {
        console.error('Failed to fetch data', e);
    }
}

function findService(id: number | null) {
    return services.value.find((s) => s.id === id) ?? null;
}

function addToCart() {
    if (!selectedService.value) return;
    const svc = findService(selectedService.value);
    if (!svc) return;
    if (qty.value <= 0) return;

    const existing = cart.find((c) => c.id_service === svc.id);
    if (existing) {
        existing.qty += qty.value;
        existing.subtotal = Number((existing.qty * existing.price).toFixed(2));
    } else {
        cart.push({
            id_service: svc.id,
            service_name: svc.service_name,
            price: Number(svc.price),
            qty: qty.value,
            subtotal: Number((svc.price * qty.value).toFixed(2)),
        });
    }
    selectedService.value = null;
    qty.value = 1;
}

function removeFromCart(index: number) {
    cart.splice(index, 1);
}

function clearCart() {
    cart.splice(0, cart.length);
    orderPay.value = null;
    selectedCustomer.value = null;
}

async function submitOrder() {
    if (!selectedCustomer.value) {
        alert('Pilih customer terlebih dahulu.');
        return;
    }
    if (cart.length === 0) {
        alert('Keranjang kosong.');
        return;
    }
    loading.value = true;
    errors.value = {};
    try {
        const payload = {
            id_customer: selectedCustomer.value,
            order_date: today,
            order_end_date: null,
            order_status: 0,
            order_pay: orderPay.value ?? 0,
            order_change: Number(change.value),
            total: Number(total.value),
            details: cart.map((c) => ({
                id_service: c.id_service,
                qty: c.qty,
                subtotal: c.subtotal,
            })),
        };

        const res = await fetch(kasir_store().url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getCsrf(),
            },
            credentials: 'same-origin',
            body: JSON.stringify(payload),
        });

        if (res.ok) {
            alert('Order berhasil disimpan.');
            clearCart();
        } else if (res.status === 422) {
            const data = await res.json();
            errors.value = data.errors ?? {};
            alert('Validasi gagal, periksa input.');
        } else {
            console.error('Server error', await res.text());
            alert('Terjadi kesalahan saat menyimpan order.');
        }
    } catch (e) {
        console.error(e);
        alert('Gagal menghubungi server.');
    } finally {
        loading.value = false;
    }
}

onMounted(fetchData);
</script>

<template>

    <Head title="Kasir" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-4">
            <div class="grid gap-4 md:grid-cols-3">
                <!-- Left: Controls -->
                <div class="md:col-span-2 space-y-4">
                    <div class="rounded-lg border p-4">
                        <h2 class="mb-2 text-lg font-medium">Informasi Pelanggan</h2>
                        <div class="flex gap-2">
                            <select v-model="selectedCustomer" class="w-1/2 rounded border p-2">
                                <option :value="null">-- Pilih customer --</option>
                                <option v-for="c in customers" :key="c.id" :value="c.id">
                                    {{ c.customer_name }} - {{ c.phone ?? '' }}
                                </option>
                            </select>
                            <Link :href="customers_register().url">
                            <Button variant="secondary">Baru +</Button>
                            </Link>
                        </div>
                    </div>

                    <div class="rounded-lg border p-4">
                        <h2 class="mb-2 text-lg font-medium">Tambah Layanan</h2>
                        <div class="flex gap-2 items-center">
                            <select v-model="selectedService" class="flex-1 rounded border p-2">
                                <option :value="null">-- Pilih layanan --</option>
                                <option v-for="s in services" :key="s.id" :value="s.id">
                                    {{ s.service_name }} — Rp {{ Number(s.price).toLocaleString() }}
                                </option>
                            </select>
                            <input type="number" min="1" v-model.number="qty" class="w-24 rounded border p-2" />
                            <Button variant="outline" @click="addToCart">
                                Tambah
                            </Button>
                        </div>
                    </div>

                    <div class="rounded-lg border p-4">
                        <h2 class="mb-2 text-lg font-medium">Keranjang</h2>
                        <table class="w-full table-auto">
                            <thead>
                                <tr class="text-left text-sm text-gray-500">
                                    <th class="py-2">Layanan</th>
                                    <th class="py-2">Kg</th>
                                    <th class="py-2">Harga</th>
                                    <th class="py-2">Subtotal</th>
                                    <th class="py-2">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item, idx) in cart" :key="item.id_service" class="border-t">
                                    <td class="py-2">{{ item.service_name }}</td>
                                    <td class="py-2">{{ item.qty }}</td>
                                    <td class="py-2">Rp {{ Number(item.price).toLocaleString() }}</td>
                                    <td class="py-2">Rp {{ Number(item.subtotal).toLocaleString() }}</td>
                                    <td class="py-2">
                                        <Button variant="destructive" size="sm"
                                            @click="removeFromCart(idx)">
                                            Hapus
                                        </Button>
                                    </td>
                                </tr>
                                <tr v-if="cart.length === 0">
                                    <td colspan="5" class="py-4 text-center text-sm text-gray-500">Keranjang kosong</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Right: Summary & Payment -->
                <div class="space-y-4">
                    <div class="rounded-lg border p-4">
                        <h3 class="text-lg font-medium">Ringkasan</h3>
                        <div class="mt-2 space-y-2">
                            <div class="flex justify-between">
                                <span>Subtotal</span>
                                <span>Rp {{ Number(total).toLocaleString() }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Pembayaran</span>
                                <input type="number" min="0" v-model.number="orderPay"
                                    class="w-32 rounded border p-2 text-right" />
                            </div>
                            <div class="flex justify-between font-semibold">
                                <span>Kembalian</span>
                                <span>Rp {{ Number(change).toLocaleString() }}</span>
                            </div>
                        </div>

                        <div class="mt-4 flex gap-2">
                            <button class="w-full rounded bg-blue-500/65 px-4 py-2 text-white disabled:opacity-50"
                                :disabled="loading" @click="submitOrder">
                                Simpan Order
                            </button>
                            <button class="w-full rounded border px-4 py-2" :disabled="loading" @click="clearCart">
                                Reset
                            </button>
                        </div>
                    </div>

                    <div class="rounded-lg border p-4">
                        <h3 class="text-lg font-medium">Informasi</h3>
                        <p class="mt-2 text-sm text-gray-600">
                            Tanggal: {{ today }} <br />
                            Jumlah item: {{ cart.length }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
