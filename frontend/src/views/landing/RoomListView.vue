<template>
  <main class="min-h-screen bg-white overflow-hidden selection:bg-cyan-100 selection:text-cyan-900">

    <nav class="fixed top-4 left-1/2 -translate-x-1/2 w-[calc(100%-2rem)] max-w-7xl z-50 flex items-center justify-between px-8 py-4 bg-white/80 backdrop-blur-xl rounded-2xl shadow-lg shadow-slate-200/50 border border-slate-100/80">
      <router-link to="/" class="flex items-center gap-2">
        <div class="text-cyan-400">
          <LogoIcon />
        </div>
        <span class="text-2xl font-bold tracking-tight text-slate-900">Lokanata Hotel</span>
      </router-link>

      <div class="hidden md:flex items-center gap-8 font-medium text-slate-700">
        <router-link to="/" class="hover:text-cyan-500 transition-colors">Beranda</router-link>
        <router-link to="/rooms" class="text-cyan-500 font-semibold">Kamar</router-link>
      </div>

      <router-link to="/" class="px-6 py-2.5 rounded-full border border-slate-200 font-medium text-slate-700 hover:bg-slate-50 transition-colors hidden md:inline-flex">
        ← Kembali
      </router-link>
    </nav>

    <section class="max-w-7xl mx-auto px-8 pt-28 pb-12 relative z-10">
      <div class="text-center max-w-2xl mx-auto mb-16">
        <h1 class="text-4xl font-bold text-slate-900 mb-4">Pilih Kamar Ideal Anda</h1>
        <p class="text-slate-600">Dari kamar superior yang nyaman hingga suite mewah, kami memiliki ruang yang sempurna untuk istirahat Anda.</p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <div v-for="rt in roomTypes" :key="rt.id" class="group cursor-pointer flex flex-col h-full">
          <div class="relative h-64 w-full rounded-3xl overflow-hidden mb-4 shrink-0 bg-slate-100">
            <img :src="getRoomImage(rt, 0)" :alt="rt.name" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
            <div class="absolute top-4 left-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-semibold text-slate-700">
              {{ rt.capacity }} Tamu
            </div>
          </div>

          <div class="space-y-2 flex-1 flex flex-col">
            <div class="flex items-center gap-1 text-sm">
              <Star class="w-4 h-4 fill-amber-400 text-amber-400" />
              <span class="font-semibold text-slate-900">5.0</span>
              <span class="text-slate-500">({{ rt.available_rooms_count || 0 }} tersedia)</span>
            </div>

            <h3 class="text-xl font-bold text-slate-900">{{ rt.name }}</h3>
            <p class="text-sm text-slate-500 mb-1">{{ rt.bed_type || '-' }} · {{ rt.size || '-' }}</p>
            <p class="text-sm text-slate-500 line-clamp-2 leading-relaxed">{{ rt.description }}</p>

            <div class="flex flex-wrap gap-1.5 py-3">
              <span v-for="f in rt.facilities?.slice(0, 4)" :key="f.id" class="text-xs bg-slate-50 border border-slate-100 text-slate-600 px-2 py-1 rounded-lg">{{ f.name }}</span>
            </div>

            <router-link :to="`/rooms/${rt.id}`" class="text-[13px] font-bold text-cyan-500 hover:text-cyan-600 w-max underline underline-offset-4 decoration-cyan-200 hover:decoration-cyan-400 transition-all mb-4 mt-1">
              Rincian selengkapnya ↗
            </router-link>

            <div class="flex items-end justify-between pt-4 mt-auto border-t border-slate-100">
              <div>
                <p class="text-xs text-slate-500 mb-0.5">Mulai dari</p>
                <p class="text-lg font-bold text-slate-900">{{ formatCurrency(rt.base_price) }}</p>
                <p class="text-xs text-slate-500">/ malam</p>
              </div>
              <router-link :to="`/booking/${rt.id}`" class="px-5 py-2.5 rounded-full bg-cyan-400 text-white text-sm font-semibold hover:bg-cyan-500 transition-colors">
                Pesan sekarang
              </router-link>
            </div>
          </div>
        </div>
      </div>
    </section>

    <footer class="border-t border-slate-100 py-12 mt-12 relative z-10">
      <div class="max-w-7xl mx-auto px-8 text-center text-slate-500 text-sm">
        Copyright &copy; {{ new Date().getFullYear() }} | Developed by Cybha.
      </div>
    </footer>
  </main>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { Star } from 'lucide-vue-next'
import LogoIcon from '../../components/LogoIcon.vue'
import api from '../../services/api'

const roomTypes = ref([])

const roomImages = [
  'https://images.unsplash.com/photo-1611892440504-42a792e24d32?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
  'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
  'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
]

onMounted(async () => {
  try {
    const res = await api.get('/guest/room-types')
    roomTypes.value = res.data
  } catch (error) {
    console.error(error)
  }
})

function getRoomImage(rt, idx = 0) {
  if (rt.images && rt.images.length > idx) return '/storage/' + rt.images[idx]
  return roomImages[(rt.id + idx) % 3]
}

function formatCurrency(v) {
  return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(v || 0)
}
</script>
