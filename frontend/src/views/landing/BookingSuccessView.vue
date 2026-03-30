<template>
  <main class="min-h-screen bg-white flex items-center justify-center px-4 selection:bg-cyan-100 selection:text-cyan-900">
    <div class="text-center max-w-lg mx-auto bg-white p-12 rounded-3xl shadow-[0_20px_50px_-12px_rgba(0,0,0,0.08)] border border-slate-100">
      <div class="w-24 h-24 bg-emerald-50 rounded-full flex items-center justify-center mx-auto mb-8">
        <CheckCircle class="w-12 h-12 text-emerald-500" />
      </div>
      <h2 class="text-3xl font-bold text-slate-900 mb-3 tracking-tight">Pemesanan Berhasil!</h2>
      <p class="text-slate-500 mb-6">Kode reservasi Anda:</p>

      <div class="bg-slate-50 border border-slate-200 px-8 py-5 rounded-2xl inline-block mb-8">
        <p class="text-4xl font-mono font-bold text-slate-900 tracking-wider">{{ $route.params.code }}</p>
      </div>

      <p class="text-sm text-slate-500 mb-10 max-w-sm mx-auto leading-relaxed">
        Silakan simpan kode reservasi ini. Tim kami akan mengkonfirmasi pemesanan Anda dalam waktu singkat.
      </p>

      <router-link to="/" class="w-full inline-flex items-center justify-center py-3.5 rounded-full bg-cyan-400 text-white font-semibold hover:bg-cyan-500 transition-colors text-base">
        Kembali ke Beranda
      </router-link>
    </div>
  </main>
</template>

<script setup>
import { CheckCircle } from 'lucide-vue-next'
</script>
