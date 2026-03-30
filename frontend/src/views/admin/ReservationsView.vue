<template>
  <div class="space-y-6">
    <div class="flex items-center justify-between">
      <h1 class="page-title">Reservasi</h1>
      <button @click="showForm = true" class="btn-primary">+ Reservasi Manual</button>
    </div>
    <div class="table-container">
      <table class="data-table">
        <thead><tr><th>Kode</th><th>Tamu</th><th>Kamar</th><th>Check-in</th><th>Check-out</th><th>Status</th><th>Total</th></tr></thead>
        <tbody>
          <tr v-for="r in reservations" :key="r.id">
            <td class="font-mono font-semibold text-[var(--primary)]">{{ r.reservation_code }}</td>
            <td>{{ r.guest?.name }}</td>
            <td>{{ r.room?.room_number }} — {{ r.room?.room_type?.name }}</td>
            <td>{{ formatDate(r.check_in_date) }}</td>
            <td>{{ formatDate(r.check_out_date) }}</td>
            <td><span :class="'badge badge-' + r.status">{{ statusLabel(r.status) }}</span></td>
            <td class="font-semibold">{{ formatCurrency(r.total_price) }}</td>
          </tr>
        </tbody>
      </table>
    </div>
    <div v-if="showForm" class="modal-overlay" @click.self="showForm = false">
      <div class="modal-content p-6 animate-slide-up">
        <h3 class="text-lg font-bold mb-4">Reservasi Manual</h3>
        <form @submit.prevent="createReservation" class="space-y-4">
          <div><label class="label">Nama Tamu</label><input v-model="form.guest_name" class="input-field" required /></div>
          <div class="grid grid-cols-2 gap-4">
            <div><label class="label">Email</label><input v-model="form.guest_email" type="email" class="input-field" /></div>
            <div><label class="label">Telepon</label><input v-model="form.guest_phone" class="input-field" /></div>
          </div>
          <div><label class="label">Kamar</label>
            <select v-model="form.room_id" class="select-field" required>
              <option v-for="r in availableRooms" :key="r.id" :value="r.id">{{ r.room_number }} — {{ r.room_type?.name }}</option>
            </select>
          </div>
          <div class="grid grid-cols-2 gap-4">
            <div><label class="label">Check-in</label><input v-model="form.check_in_date" type="date" class="input-field" required /></div>
            <div><label class="label">Check-out</label><input v-model="form.check_out_date" type="date" class="input-field" required /></div>
          </div>
          <div><label class="label">Jumlah Tamu</label><input v-model="form.number_of_guests" type="number" min="1" class="input-field" required /></div>
          <div><label class="label">Permintaan Khusus</label><textarea v-model="form.special_requests" class="input-field" rows="2"></textarea></div>
          <div class="flex gap-2 justify-end"><button type="button" @click="showForm = false" class="btn-ghost">Batal</button><button type="submit" class="btn-primary">Simpan</button></div>
        </form>
      </div>
    </div>
  </div>
</template>
<script setup>
import { ref, onMounted } from 'vue'
import api from '../../services/api'
import { useAuthStore } from '../../stores/authStore'

const auth = useAuthStore()
const prefix = auth.userRole === 'receptionist' ? '/receptionist' : '/admin'

const reservations = ref([])
const availableRooms = ref([])
const showForm = ref(false)
const form = ref({ guest_name: '', guest_email: '', guest_phone: '', room_id: '', check_in_date: '', check_out_date: '', number_of_guests: 1, special_requests: '' })
onMounted(async () => {
  await fetchData()
  const roomRes = await api.get('/admin/rooms', { params: { status: 'available' } })
  availableRooms.value = roomRes.data
})
async function fetchData() { const res = await api.get(`${prefix}/reservations`); reservations.value = res.data.data || res.data }
async function createReservation() { await api.post(`${prefix}/reservations`, form.value); showForm.value = false; fetchData() }
function formatDate(d) { return d ? new Date(d).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' }) : '-' }
function formatCurrency(v) { return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(v || 0) }
function statusLabel(s) { const l = { pending: 'Tertunda', confirmed: 'Dikonfirmasi', checked_in: 'Check-In', checked_out: 'Check-Out', cancelled: 'Dibatalkan' }; return l[s] || s }
</script>
