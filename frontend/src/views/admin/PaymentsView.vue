<template>
  <div class="space-y-6">
    <div class="flex items-center justify-between"><h1 class="page-title">Pembayaran & Faktur</h1></div>
    <div class="table-container">
      <table class="data-table">
        <thead><tr><th>ID</th><th>Reservasi</th><th>Tamu</th><th>Jumlah</th><th>Metode</th><th>Status</th><th>Tanggal</th></tr></thead>
        <tbody>
          <tr v-for="p in payments" :key="p.id">
            <td>#{{ p.id }}</td>
            <td class="font-mono text-[var(--primary)]">{{ p.reservation?.reservation_code || '-' }}</td>
            <td>{{ p.reservation?.guest?.name || '-' }}</td>
            <td class="font-semibold">{{ formatCurrency(p.amount) }}</td>
            <td>{{ p.payment_method || '-' }}</td>
            <td><span :class="'badge badge-' + p.status">{{ p.status === 'paid' ? 'Lunas' : 'Belum' }}</span></td>
            <td>{{ p.paid_at ? formatDate(p.paid_at) : '-' }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>
<script setup>
import { ref, onMounted } from 'vue'
import api from '../../services/api'
import { useAuthStore } from '../../stores/authStore'

const auth = useAuthStore()
const prefix = auth.userRole === 'receptionist' ? '/receptionist' : '/admin'

const payments = ref([])
onMounted(async () => { const res = await api.get(`${prefix}/payments`); payments.value = res.data.data || res.data })
function formatCurrency(v) { return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(v || 0) }
function formatDate(d) { return new Date(d).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' }) }
</script>
