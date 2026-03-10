node {
    // ==================== STAGE 1: CHECKOUT ====================
    stage('Checkout') {
        checkout scm
        echo "✅ Checkout berhasil dari repository"
        sh 'ls -la'
    }

    // ==================== STAGE 2: BUILD ====================
    stage('Build Dependencies') {
        docker.image('composer:2.5').inside('-u root') {
            // Hapus composer.lock untuk menghindari konflik versi
            sh 'rm -f composer.lock'
            
            // Install dependencies tanpa package dev (production)
            sh 'composer install --no-dev --optimize-autoloader'
            
            // Debug: lihat vendor yang terinstall
            sh 'ls -la vendor || true'
        }
    }

    // ==================== STAGE 3: DEPLOY TO CONTAINER ====================
    stage('Deploy to Local Container') {
        // Bersihkan folder target di volume
        sh 'rm -rf /deploy/laravel/* || true'
        sh 'mkdir -p /deploy/laravel'
        
        // Salin semua file dari workspace ke folder deploy
        sh 'cp -r . /deploy/laravel/'
        
        // Debug: lihat hasil copy
        sh 'echo "📁 File yang dideploy:"'
        sh 'ls -la /deploy/laravel'
        
        // Atur permission untuk storage dan cache
        sh 'chmod -R 777 /deploy/laravel/storage /deploy/laravel/bootstrap/cache || true'
    }

    // ==================== STAGE 4: SETUP ENVIRONMENT ====================
    stage('Setup Environment') {
        // Buat file .env dari contoh
        sh 'cp /deploy/laravel/.env.example /deploy/laravel/.env'
        
        // Generate application key
        sh 'docker exec laravel-target php artisan key:generate'
        
        // Konfigurasi database connection
        sh '''
            docker exec laravel-target sed -i "s/DB_CONNECTION=.*/DB_CONNECTION=mysql/" /var/www/html/.env
            docker exec laravel-target sed -i "s/DB_HOST=.*/DB_HOST=db/" /var/www/html/.env
            docker exec laravel-target sed -i "s/DB_DATABASE=.*/DB_DATABASE=laravel/" /var/www/html/.env
            docker exec laravel-target sed -i "s/DB_USERNAME=.*/DB_USERNAME=laravel_user/" /var/www/html/.env
            docker exec laravel-target sed -i "s/DB_PASSWORD=.*/DB_PASSWORD=secret/" /var/www/html/.env
        '''
        
        // Jalankan migrasi database
        sh 'docker exec laravel-target php artisan migrate --force'
        
        // Optimasi untuk production (Laravel)
        sh 'docker exec laravel-target php artisan config:cache'
        sh 'docker exec laravel-target php artisan route:cache'
        sh 'docker exec laravel-target php artisan view:cache'
    }

    // ==================== STAGE 5: VERIFICATION ====================
    stage('Verification') {
        // Cek apakah container target berjalan
        sh 'docker ps | grep laravel-target || echo "⚠️ Container target tidak berjalan!"'
        
        // Cek apakah file index.php ada
        sh 'docker exec laravel-target ls -la /var/www/html/public/index.php || echo "⚠️ index.php tidak ditemukan!"'
        
        // Cek response HTTP (optional)
        sh '''
            curl -I http://localhost:8082 || echo "⚠️ Aplikasi belum merespons di port 8082"
        '''
        
        echo "✅ Deployment selesai!"
        echo "🌐 Akses aplikasi di: http://localhost:8082"
        echo "📊 Akses phpMyAdmin di: http://localhost:8083 (server: db, user: root, password: secret)"
    }

    // ==================== STAGE 6: CLEANUP (OPTIONAL) ====================
    stage('Cleanup') {
        // Bersihkan file sementara jika perlu
        sh 'rm -rf /tmp/composer-* || true'
        echo "🧹 Cleanup selesai"
    }
    
    // ==================== POST BUILD ACTIONS ====================
    post {
        success {
            echo "🎉 Pipeline berhasil! Aplikasi terdeploy."
        }
        failure {
            echo "❌ Pipeline gagal. Periksa console output untuk detail error."
        }
    }
}
