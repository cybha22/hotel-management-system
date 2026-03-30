<template>
  <div class="flex h-screen overflow-hidden bg-slate-50">
    <Sidebar :user="auth.user" :user-role="auth.userRole" :is-collapsed="isSidebarCollapsed" @logout="handleLogout" @toggle="isSidebarCollapsed = !isSidebarCollapsed" />
    <main class="flex-1 overflow-y-auto flex flex-col min-w-0 transition-all duration-300">
      <Navbar :page-title="currentPageTitle" />
      <div class="p-8 animate-fade-in">
        <router-view />
      </div>
    </main>
  </div>
</template>

<script setup>
import { computed, ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useAuthStore } from '../../stores/authStore'
import Sidebar from './Sidebar.vue'
import Navbar from './Navbar.vue'

const auth = useAuthStore()
const route = useRoute()
const router = useRouter()
const isSidebarCollapsed = ref(false)

const pageTitles = {
  dashboard: 'Dasbor',
  'room-types': 'Tipe Kamar',
  rooms: 'Daftar Kamar',
  facilities: 'Fasilitas',
  'booking-online': 'Booking Online',
  reservations: 'Reservasi',
  'check-in-out': 'Check In/Out',
  payments: 'Pembayaran & Faktur',
  guests: 'Data Tamu',
  housekeeping: 'Tata Graha',
  staff: 'Manajemen Staf',
  reports: 'Laporan',
  settings: 'Pengaturan',
}

const currentPageTitle = computed(() => {
  const segments = route.path.split('/')
  const lastSegment = segments[segments.length - 1]
  return pageTitles[lastSegment] || 'Dasbor'
})

async function handleLogout() {
  await auth.logout()
  router.push('/login')
}
</script>
