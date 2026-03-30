<template>
  <main class="min-h-screen bg-white overflow-hidden selection:bg-cyan-100 selection:text-cyan-900">

    <nav class="fixed top-4 left-1/2 -translate-x-1/2 w-[calc(100%-2rem)] max-w-7xl z-50 flex items-center justify-between px-8 py-4 bg-white/80 backdrop-blur-xl rounded-2xl shadow-lg shadow-slate-200/50 border border-slate-100/80 transition-all duration-300">
      <div class="flex items-center gap-2">
        <div class="text-cyan-400">
          <LogoIcon />
        </div>
        <span class="text-2xl font-bold tracking-tight text-slate-900">{{ setting?.hotel_name || 'Lokanata Hotel' }}</span>
      </div>

      <div class="hidden md:flex items-center gap-8 font-medium text-slate-700">
        <router-link to="/" class="hover:text-cyan-500 transition-colors">Beranda</router-link>
        <router-link to="/rooms" class="hover:text-cyan-500 transition-colors">Kamar</router-link>
        <a href="#kontak" class="hover:text-cyan-500 transition-colors">Kontak</a>
      </div>

      <div class="hidden md:flex items-center gap-4">
        <router-link to="/rooms" class="px-6 py-2.5 rounded-full bg-cyan-400 text-white font-medium hover:bg-cyan-500 transition-colors">
          Pesan Sekarang
        </router-link>
      </div>
    </nav>

    <section class="max-w-7xl mx-auto px-8 pt-28 pb-12 grid lg:grid-cols-2 gap-12 items-center relative z-10">
      <div class="space-y-8">
        <h1 class="text-5xl lg:text-7xl font-bold leading-[1.1] tracking-tight text-slate-900">
          Kemewahan dan Kenyamanan Menanti Anda di <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-blue-500">{{ setting?.hotel_name || 'Lokanata' }}</span>
        </h1>
        <p class="text-lg text-slate-600 leading-relaxed max-w-xl">
          Hadirkan momen tak terlupakan dengan fasilitas premium dan layanan eksklusif di {{ setting?.hotel_name || 'Lokanata Hotel' }}.
        </p>

        <div class="flex items-center gap-4">
          <router-link to="/rooms" class="px-8 py-3.5 rounded-full border-2 border-slate-200 font-semibold text-slate-700 hover:border-slate-300 transition-colors">
            Jelajahi Kamar
          </router-link>
          <router-link to="/rooms" class="px-8 py-3.5 rounded-full bg-cyan-400 text-white font-semibold hover:bg-cyan-500 transition-colors flex items-center gap-2">
            <ChevronsRight class="w-5 h-5" />
            Pesan Sekarang
          </router-link>
        </div>

        <div class="pt-8 w-full max-w-md overflow-hidden">
          <p class="text-[13px] font-bold text-slate-400 mb-4 uppercase tracking-wider">Dipercaya oleh :</p>
          <div class="relative w-full overflow-hidden flex" style="mask-image: linear-gradient(to right, transparent, black 10%, black 90%, transparent); -webkit-mask-image: linear-gradient(to right, transparent, black 10%, black 90%, transparent);">
            <div class="flex flex-nowrap shrink-0 gap-8 animate-marquee items-center opacity-40 grayscale transition-all duration-300 hover:opacity-100 hover:grayscale-0">
              <div v-for="i in 3" :key="'marquee-sm-'+i" class="flex gap-8 shrink-0 items-center whitespace-nowrap px-4">
                <div class="flex items-center gap-2"><div class="w-3 h-3 bg-slate-900 rounded-[3px]"></div> <span class="text-xl font-bold text-slate-900 tracking-tight">Traveloka</span></div>
                <div class="flex items-center gap-2"><div class="w-3 h-3 bg-slate-900 rounded-full"></div> <span class="text-xl font-bold text-slate-900 tracking-tight">Tiket.com</span></div>
                <div class="flex items-center gap-2"><div class="w-3 h-3 bg-slate-900 rotate-45"></div> <span class="text-xl font-bold text-slate-900 tracking-tight">Agoda</span></div>
                <div class="flex items-center gap-2"><div class="w-3 h-3 bg-slate-900 rounded-[3px]"></div> <span class="text-xl font-bold text-slate-900 tracking-tight">Booking.com</span></div>
                <div class="flex items-center gap-2"><div class="w-3 h-3 bg-slate-900 rounded-full"></div> <span class="text-xl font-bold text-slate-900 tracking-tight">AirAsia</span></div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="relative mt-8 lg:mt-0">
        <div class="relative h-[600px] w-full rounded-[2.5rem] overflow-hidden">
          <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Luxury Resort Pool" class="w-full h-full object-cover" />
        </div>

        <div class="absolute -bottom-12 left-1/2 -translate-x-1/2 w-[95%] bg-white rounded-3xl shadow-[0_20px_50px_-12px_rgba(0,0,0,0.1)] p-6 z-20">
          <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="space-y-2">
              <label class="text-sm font-semibold text-slate-900">Check-in</label>
              <div class="flex items-center gap-3 px-4 py-3 rounded-2xl border border-slate-200 bg-slate-50/50 focus-within:border-cyan-400 focus-within:ring-2 focus-within:ring-cyan-100 transition">
                <Calendar class="w-5 h-5 text-slate-400 shrink-0" />
                <input v-model="searchForm.checkIn" type="date" :min="todayDate" class="bg-transparent border-none outline-none w-full text-sm text-slate-700 relative [&::-webkit-calendar-picker-indicator]:absolute [&::-webkit-calendar-picker-indicator]:inset-0 [&::-webkit-calendar-picker-indicator]:w-full [&::-webkit-calendar-picker-indicator]:h-full [&::-webkit-calendar-picker-indicator]:opacity-0 [&::-webkit-calendar-picker-indicator]:cursor-pointer" />
              </div>
            </div>
            <div class="space-y-2">
              <label class="text-sm font-semibold text-slate-900">Check-out</label>
              <div class="flex items-center gap-3 px-4 py-3 rounded-2xl border border-slate-200 bg-slate-50/50 focus-within:border-cyan-400 focus-within:ring-2 focus-within:ring-cyan-100 transition">
                <Calendar class="w-5 h-5 text-slate-400 shrink-0" />
                <input v-model="searchForm.checkOut" type="date" :min="searchForm.checkIn || todayDate" class="bg-transparent border-none outline-none w-full text-sm text-slate-700 relative [&::-webkit-calendar-picker-indicator]:absolute [&::-webkit-calendar-picker-indicator]:inset-0 [&::-webkit-calendar-picker-indicator]:w-full [&::-webkit-calendar-picker-indicator]:h-full [&::-webkit-calendar-picker-indicator]:opacity-0 [&::-webkit-calendar-picker-indicator]:cursor-pointer" />
              </div>
            </div>
            <div class="space-y-2">
              <label class="text-sm font-semibold text-slate-900">Jumlah Tamu</label>
              <div class="flex items-center gap-3 px-4 py-3 rounded-2xl border border-slate-200 bg-slate-50/50 focus-within:border-cyan-400 focus-within:ring-2 focus-within:ring-cyan-100 transition">
                <Users class="w-5 h-5 text-slate-400 shrink-0" />
                <input v-model="searchForm.guests" type="number" min="1" max="10" placeholder="2" class="bg-transparent border-none outline-none w-full text-sm text-slate-700" />
              </div>
            </div>
          </div>

          <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
            <div class="flex flex-wrap items-center gap-3">
              <span class="text-sm font-semibold text-slate-900 mr-2">Tipe:</span>
              <button
                v-for="rt in roomTypes.slice(0, 4)"
                :key="'tag-'+rt.id"
                @click="selectRoomType(rt.id)"
                :class="[
                  'px-4 py-2 rounded-full text-sm font-medium transition-colors',
                  searchForm.selectedTypeId === rt.id
                    ? 'bg-cyan-400 text-white border border-cyan-400'
                    : 'border border-slate-200 text-slate-600 hover:bg-slate-50'
                ]"
              >
                {{ rt.name }}
              </button>
            </div>
            <button @click="handleSearch" class="w-full md:w-auto px-6 py-3 rounded-full bg-slate-900 text-white font-medium hover:bg-slate-800 transition-colors flex items-center justify-center gap-2">
              Cek Ketersediaan
              <ArrowRight class="w-4 h-4" />
            </button>
          </div>
        </div>
      </div>
    </section>


    <section class="max-w-7xl mx-auto px-8 py-12 mt-8 relative z-10">
      <div class="flex flex-col md:flex-row md:items-center justify-between mb-10 gap-4">
        <h2 class="text-3xl font-bold text-slate-900">Kamar & Suite Kami</h2>
        <router-link to="/rooms" class="flex items-center gap-2 text-sm font-semibold text-cyan-500 hover:text-cyan-600 transition-colors">
          Lihat Semua <ArrowRight class="w-4 h-4" />
        </router-link>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <div v-for="rt in roomTypes" :key="rt.id" class="group flex flex-col h-full bg-white rounded-[2rem] p-4 transition-all hover:shadow-[0_20px_40px_-15px_rgba(0,0,0,0.05)] border border-transparent hover:border-slate-100">
          <div class="relative h-64 w-full rounded-[1.5rem] overflow-hidden mb-5 shrink-0 bg-slate-100 cursor-pointer" @click="openModal(rt)">
            <img :src="getRoomImage(rt, activeImages[rt.id] || 0)" :alt="rt.name" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" />
            <div class="absolute top-4 left-4 bg-white/95 backdrop-blur-md px-3 py-1.5 rounded-full text-xs font-bold text-slate-800 shadow-sm pointer-events-none">
              {{ rt.capacity }} Tamu
            </div>

            <template v-if="getImageCount(rt) > 1">
              <button @click.stop="prevImg(rt)" class="absolute left-3 top-1/2 -translate-y-1/2 w-8 h-8 bg-white/90 hover:bg-white hover:scale-105 text-slate-800 rounded-full flex items-center justify-center shadow-lg opacity-0 group-hover:opacity-100 transition-all duration-300">
                <ChevronLeft class="w-5 h-5 -ml-0.5" />
              </button>
              <button @click.stop="nextImg(rt)" class="absolute right-3 top-1/2 -translate-y-1/2 w-8 h-8 bg-white/90 hover:bg-white hover:scale-105 text-slate-800 rounded-full flex items-center justify-center shadow-lg opacity-0 group-hover:opacity-100 transition-all duration-300">
                <ChevronRight class="w-5 h-5 ml-0.5" />
              </button>

              <div class="absolute bottom-3 left-0 right-0 flex justify-center gap-1.5 pointer-events-none">
                <span v-for="n in getImageCount(rt)" :key="n" class="transition-all duration-300 rounded-full" :class="n - 1 === (activeImages[rt.id] || 0) ? 'w-2 h-2 bg-white shadow-sm' : 'w-1.5 h-1.5 bg-white/50'"></span>
              </div>
            </template>
          </div>

          <div class="flex-1 flex flex-col px-2">
            <h3 class="text-xl font-bold text-slate-900 cursor-pointer hover:text-cyan-500 transition-colors w-max" @click="openModal(rt)">{{ rt.name }}</h3>
            <p class="text-sm text-slate-500 mt-1 mb-2">{{ rt.bed_type || '-' }} · {{ rt.size || '-' }}</p>
            <p class="text-sm text-slate-500 line-clamp-2 leading-relaxed">{{ rt.description }}</p>

            <div class="flex flex-wrap gap-1.5 py-4">
              <span v-for="f in (rt.facilities || []).slice(0, 3)" :key="f.id" class="text-[11px] font-medium bg-slate-50 border border-slate-100 text-slate-600 px-2.5 py-1 rounded-lg">{{ f.name }}</span>
            </div>

            <button @click="openModal(rt)" class="text-[13px] font-bold text-cyan-500 hover:text-cyan-600 w-max underline underline-offset-4 decoration-cyan-200 hover:decoration-cyan-400 transition-all mb-6">
              Rincian selengkapnya ↗
            </button>

            <div class="flex items-end justify-between pt-4 mt-auto border-t border-slate-100/60">
              <div>
                <p class="text-[11px] font-bold tracking-widest uppercase text-slate-400 mb-1">Mulai dari</p>
                <div class="flex items-baseline gap-1">
                  <p class="text-xl font-bold text-slate-900">{{ formatCurrency(rt.base_price) }}</p>
                  <p class="text-xs text-slate-500">/malam</p>
                </div>
              </div>
              <router-link :to="`/booking/${rt.id}`" class="px-6 py-2.5 rounded-full bg-cyan-400 text-white text-sm font-bold hover:bg-cyan-500 transition-colors shadow-lg shadow-cyan-400/20 hover:shadow-cyan-400/40 hover:-translate-y-0.5 transform">
                Pesan
              </router-link>
            </div>
          </div>
        </div>
      </div>
    </section>

    <footer class="bg-slate-900 text-slate-300 mt-16 relative overflow-hidden" id="kontak">
      <div class="absolute top-0 right-0 w-96 h-96 bg-cyan-500/5 rounded-full blur-[100px] -translate-y-1/2 translate-x-1/2"></div>
      <div class="absolute bottom-0 left-0 w-72 h-72 bg-blue-500/5 rounded-full blur-[80px] translate-y-1/2 -translate-x-1/2"></div>

      <div class="max-w-7xl mx-auto px-8 pt-20 pb-8 relative z-10">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-16">

          <div class="lg:col-span-1 space-y-6">
            <div class="flex items-center gap-2">
              <LogoIcon />
              <span class="text-xl font-bold text-white tracking-tight">{{ setting?.hotel_name || 'Lokanata' }}</span>
            </div>
            <p class="text-sm text-slate-400 leading-relaxed">
              Pengalaman menginap premium dengan layanan terbaik dan fasilitas kelas dunia untuk kenyamanan Anda.
            </p>
            <div class="flex items-center gap-3">
              <a href="#" class="w-9 h-9 rounded-full bg-white/5 border border-white/10 flex items-center justify-center hover:bg-cyan-500 hover:border-cyan-500 transition-all group">
                <svg class="w-4 h-4 text-slate-400 group-hover:text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
              </a>
              <a href="#" class="w-9 h-9 rounded-full bg-white/5 border border-white/10 flex items-center justify-center hover:bg-cyan-500 hover:border-cyan-500 transition-all group">
                <svg class="w-4 h-4 text-slate-400 group-hover:text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
              </a>
              <a href="#" class="w-9 h-9 rounded-full bg-white/5 border border-white/10 flex items-center justify-center hover:bg-cyan-500 hover:border-cyan-500 transition-all group">
                <svg class="w-4 h-4 text-slate-400 group-hover:text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z"/></svg>
              </a>
            </div>
          </div>

          <div class="space-y-5">
            <h5 class="text-sm font-bold text-white uppercase tracking-widest">Navigasi</h5>
            <ul class="space-y-3">
              <li><router-link to="/" class="text-sm text-slate-400 hover:text-cyan-400 transition-colors">Beranda</router-link></li>
              <li><router-link to="/rooms" class="text-sm text-slate-400 hover:text-cyan-400 transition-colors">Kamar & Suite</router-link></li>
              <li><a href="#kontak" class="text-sm text-slate-400 hover:text-cyan-400 transition-colors">Hubungi Kami</a></li>
              <li><router-link to="/login" class="text-sm text-slate-400 hover:text-cyan-400 transition-colors">Portal Staff</router-link></li>
            </ul>
          </div>

          <div class="space-y-5">
            <h5 class="text-sm font-bold text-white uppercase tracking-widest">Kontak</h5>
            <ul class="space-y-4">
              <li class="flex items-start gap-3">
                <MapPin class="w-4 h-4 text-cyan-400 mt-0.5 shrink-0" />
                <span class="text-sm text-slate-400">{{ setting?.address || 'Pusat Kota' }}</span>
              </li>
              <li class="flex items-center gap-3">
                <Phone class="w-4 h-4 text-cyan-400 shrink-0" />
                <span class="text-sm text-slate-400">{{ setting?.phone || '+62 0000 0000' }}</span>
              </li>
              <li class="flex items-center gap-3">
                <Mail class="w-4 h-4 text-cyan-400 shrink-0" />
                <span class="text-sm text-slate-400">{{ setting?.email || 'info@lokanata.com' }}</span>
              </li>
              <li class="flex items-center gap-3">
                <Clock class="w-4 h-4 text-cyan-400 shrink-0" />
                <span class="text-sm text-slate-400">Resepsionis 24 Jam</span>
              </li>
            </ul>
          </div>

          <div class="space-y-5">
            <h5 class="text-sm font-bold text-white uppercase tracking-widest">Pesan Langsung</h5>
            <p class="text-sm text-slate-400 leading-relaxed">
              Dapatkan penawaran terbaik untuk menginap di {{ setting?.hotel_name || 'Lokanata Hotel' }}.
            </p>
            <router-link to="/rooms" class="inline-flex items-center gap-2 px-6 py-3 rounded-full bg-cyan-400 text-white text-sm font-semibold hover:bg-cyan-500 transition-colors">
              <ChevronsRight class="w-4 h-4" />
              Lihat Kamar
            </router-link>
          </div>

        </div>

        <div class="pt-8 border-t border-white/10 flex flex-col md:flex-row justify-between items-center gap-4">
          <p class="text-xs text-slate-500">Copyright &copy; {{ new Date().getFullYear() }} | Developed by Cybha.</p>
          <div class="flex items-center gap-6 text-xs text-slate-500">
            <a href="#" class="hover:text-slate-300 transition-colors">Privacy Policy</a>
            <a href="#" class="hover:text-slate-300 transition-colors">Terms of Service</a>
            <a href="#" class="hover:text-slate-300 transition-colors">Cookie Policy</a>
          </div>
        </div>
      </div>
    </footer>

    <!-- Modal Rincian Kamar -->
    <div v-if="selectedModalRoom" class="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-6 lg:p-8">
      <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity" @click="closeModal"></div>
      
      <div class="relative bg-white rounded-[2rem] shadow-2xl w-full max-w-5xl h-[90vh] sm:h-[85vh] overflow-hidden flex flex-col lg:flex-row animate-slide-up origin-bottom">
        
        <!-- Image Slider Section -->
        <div class="relative w-full lg:w-[55%] h-64 sm:h-80 lg:h-full bg-slate-100 shrink-0">
          <img :src="getRoomImage(selectedModalRoom, modalActiveImage)" class="w-full h-full object-cover transition-opacity duration-300" />
          
          <button @click="closeModal" class="absolute top-4 left-4 lg:hidden w-10 h-10 bg-white/90 text-slate-800 rounded-full flex items-center justify-center shadow-lg">
            <X class="w-5 h-5" />
          </button>

          <template v-if="getImageCount(selectedModalRoom) > 1">
            <button @click="modalPrevImg" class="absolute left-6 top-1/2 -translate-y-1/2 w-12 h-12 bg-white/90 hover:bg-white text-slate-800 rounded-full flex items-center justify-center shadow-xl transition-transform hover:scale-105">
              <ChevronLeft class="w-6 h-6 -ml-0.5" />
            </button>
            <button @click="modalNextImg" class="absolute right-6 top-1/2 -translate-y-1/2 w-12 h-12 bg-white/90 hover:bg-white text-slate-800 rounded-full flex items-center justify-center shadow-xl transition-transform hover:scale-105">
              <ChevronRight class="w-6 h-6 ml-0.5" />
            </button>
            <div class="absolute bottom-6 left-0 right-0 flex justify-center gap-2">
              <span v-for="n in getImageCount(selectedModalRoom)" :key="n" class="transition-all duration-300 rounded-full" :class="n - 1 === modalActiveImage ? 'w-2.5 h-2.5 bg-white shadow-md' : 'w-2 h-2 bg-white/50'"></span>
            </div>
          </template>
        </div>

        <!-- Detail Section -->
        <div class="flex-1 flex flex-col h-full bg-white relative">
          <div class="hidden lg:flex items-center justify-between px-8 py-6 border-b border-slate-100 sticky top-0 bg-white z-10">
            <h3 class="text-xl font-extrabold text-slate-900 tracking-tight">Rincian Kamar</h3>
            <button @click="closeModal" class="w-10 h-10 rounded-full bg-slate-50 hover:bg-slate-100 text-slate-600 flex items-center justify-center transition-colors">
              <X class="w-5 h-5" />
            </button>
          </div>
          
          <div class="p-6 lg:p-8 space-y-8 flex-1 overflow-y-auto">
            <div>
              <h2 class="text-2xl lg:text-3xl font-extrabold text-slate-900 mb-4 tracking-tight">{{ selectedModalRoom.name }}</h2>
              <div class="flex flex-wrap items-center gap-2 text-sm text-slate-600 font-medium">
                <span class="flex items-center gap-1.5 bg-cyan-50 text-cyan-700 px-3 py-1.5 rounded-full">
                  <span class="w-1.5 h-1.5 rounded-full bg-cyan-500"></span> {{ selectedModalRoom.capacity }} Tamu
                </span>
                <span class="px-3 py-1.5 rounded-full bg-slate-50 border border-slate-100">{{ selectedModalRoom.bed_type || '-' }}</span>
                <span class="px-3 py-1.5 rounded-full bg-slate-50 border border-slate-100">{{ selectedModalRoom.size || '-' }}</span>
              </div>
            </div>

            <div class="w-12 h-1 bg-cyan-100 rounded-full"></div>

            <div>
              <h4 class="font-bold text-slate-900 mb-3 text-lg">Deskripsi Gambaran</h4>
              <p class="text-slate-600 leading-relaxed max-w-none">{{ selectedModalRoom.description }}</p>
            </div>

            <div v-if="categorizedFacilities && Object.keys(categorizedFacilities).length > 0">
              <h4 class="font-bold text-slate-900 mb-6 text-xl tracking-tight">Apa saja yang ditawarkan tempat ini</h4>
              <div class="space-y-8">
                <div v-for="(facilities, category) in categorizedFacilities" :key="category">
                  <h5 class="font-bold text-slate-800 mb-4 text-base capitalize">{{ category }}</h5>
                  <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div v-for="f in facilities" :key="f.id" class="flex items-center gap-3">
                      <CheckCircle2 class="w-5 h-5 text-cyan-500 shrink-0" stroke-width="2.5" />
                      <span class="text-sm font-medium text-slate-600">{{ f.name }}</span>
                    </div>
                  </div>
                  <div class="border-b border-slate-100 mt-6" v-if="category !== Object.keys(categorizedFacilities).pop()"></div>
                </div>
              </div>
            </div>
          </div>

          <div class="p-6 lg:p-8 border-t border-slate-100 bg-white flex items-center justify-between sticky bottom-0 z-10 shadow-[0_-10px_30px_rgba(0,0,0,0.02)]">
            <div>
              <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Total</p>
              <div class="flex items-baseline gap-1.5">
                <p class="text-2xl font-black text-slate-900 tracking-tight">{{ formatCurrency(selectedModalRoom.base_price) }}</p>
                <p class="text-sm text-slate-500 font-medium">/ malam</p>
              </div>
            </div>
            <router-link :to="`/booking/${selectedModalRoom.id}`" class="px-8 py-4 rounded-full bg-cyan-400 text-white font-bold hover:bg-cyan-500 transition-all shadow-lg shadow-cyan-400/30 hover:shadow-cyan-400/50 hover:-translate-y-1">
              Pesan Sekarang
            </router-link>
          </div>
        </div>
        
      </div>
    </div>
  </main>
</template>

<script setup>
import { ref, reactive, computed, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { ArrowRight, ChevronsRight, Calendar, Users, MapPin, Phone, Mail, Clock, ChevronLeft, ChevronRight, X, CheckCircle2 } from 'lucide-vue-next'
import LogoIcon from '../../components/LogoIcon.vue'
import api from '../../services/api'

const router = useRouter()
const setting = ref(null)
const roomTypes = ref([])

const roomImages = [
  'https://images.unsplash.com/photo-1611892440504-42a792e24d32?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
  'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
  'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
]

const activeImages = reactive({})
const selectedModalRoom = ref(null)
const modalActiveImage = ref(0)

const categorizedFacilities = computed(() => {
  if (!selectedModalRoom.value) return {}
  const groups = {}
  
  if (selectedModalRoom.value.facilities) {
    selectedModalRoom.value.facilities.forEach(f => {
      const cat = f.category || 'Lainnya'
      if (!groups[cat]) groups[cat] = []
      groups[cat].push(f)
    })
  }

  if (selectedModalRoom.value.custom_facilities) {
    for (const [cat, text] of Object.entries(selectedModalRoom.value.custom_facilities)) {
      if (!text || !text.trim()) continue;
      if (!groups[cat]) groups[cat] = []
      
      const items = text.split(',').map(s => s.trim()).filter(s => s)
      items.forEach((item, idx) => {
        groups[cat].push({ id: `c-${cat}-${idx}`, name: item })
      })
    }
  }

  return groups
})

function getImageCount(rt) {
  if (rt.images && rt.images.length > 0) return rt.images.length
  return 3 // fallback unsplash limit
}

function prevImg(rt) {
  const count = getImageCount(rt)
  let current = activeImages[rt.id] || 0
  activeImages[rt.id] = (current - 1 + count) % count
}

function nextImg(rt) {
  const count = getImageCount(rt)
  let current = activeImages[rt.id] || 0
  activeImages[rt.id] = (current + 1) % count
}

function openModal(rt) {
  selectedModalRoom.value = rt
  modalActiveImage.value = 0
  document.body.style.overflow = 'hidden'
}

function closeModal() {
  selectedModalRoom.value = null
  document.body.style.overflow = ''
}

function modalPrevImg() {
  const count = getImageCount(selectedModalRoom.value)
  modalActiveImage.value = (modalActiveImage.value - 1 + count) % count
}

function modalNextImg() {
  const count = getImageCount(selectedModalRoom.value)
  modalActiveImage.value = (modalActiveImage.value + 1) % count
}

function getRoomImage(rt, idx = 0) {
  if (rt.images && rt.images.length > idx) return '/storage/' + rt.images[idx]
  return roomImages[(rt.id + idx) % 3]
}

const todayDate = new Date().toISOString().split('T')[0]

const searchForm = reactive({
  checkIn: '',
  checkOut: '',
  guests: 2,
  selectedTypeId: null,
})

function selectRoomType(id) {
  searchForm.selectedTypeId = searchForm.selectedTypeId === id ? null : id
}

function handleSearch() {
  if (searchForm.selectedTypeId) {
    const query = {}
    if (searchForm.checkIn) query.check_in = searchForm.checkIn
    if (searchForm.checkOut) query.check_out = searchForm.checkOut
    if (searchForm.guests) query.guests = searchForm.guests
    router.push({ path: `/booking/${searchForm.selectedTypeId}`, query })
  } else {
    router.push('/rooms')
  }
}

onMounted(async () => {
  try {
    const res = await api.get('/guest/landing')
    setting.value = res.data.setting
    roomTypes.value = res.data.room_types
  } catch (error) {
    console.error(error)
  }
})

function formatCurrency(v) {
  return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(v || 0)
}
</script>
