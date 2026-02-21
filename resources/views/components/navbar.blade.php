<nav class="bg-white shadow-md fixed w-full z-50">
    <div class="max-w-7xl mx-auto px-6 lg:px-12">
        <div class="flex justify-between items-center h-16">

            <!-- Logo + Nama -->
            <a href="/" class="flex items-center space-x-3">
                <img src="{{ asset('assets/IC-PSM.jpg') }}"
                     alt="Logo PSM"
                     class="w-10 h-10 object-cover rounded-full">

                <span class="text-lg font-bold text-primary hidden sm:block">
                    UKM PSM
                </span>
            </a>

            <!-- Menu Desktop -->
            <div class="hidden md:flex space-x-8 font-medium">
                <a href="/" class="hover:text-primary">Beranda</a>
                <a href="/tentang" class="hover:text-primary">Tentang</a>
                <a href="/artikel" class="hover:text-primary">Artikel</a>
                <a href="/program" class="hover:text-primary">Program</a>
                <a href="/organisasi" class="hover:text-primary">Organisasi</a>
                <a href="/majalah" class="hover:text-primary">Majalah</a>
            </div>

        </div>
    </div>
</nav>
