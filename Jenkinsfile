node {
    stage('Checkout') {
        checkout scm
        echo "✅ Checkout berhasil dari repository"
        sh 'ls -la'
    }

    stage('Build Dependencies') {
        docker.image('php:8.2-cli').inside('-u root --dns 8.8.8.8') {
            sh '''
                set -e
                echo "=== Update package list ==="
                apt-get update -qq
                echo "=== Install git, unzip, libicu-dev, libzip-dev ==="
                apt-get install -y -qq git unzip libicu-dev libzip-dev
                git config --global --add safe.directory /var/jenkins_home/workspace/laravel-deploy
                echo "=== Install PHP extensions intl & zip ==="
                docker-php-ext-install -j$(nproc) intl zip
                echo "=== Install Composer ==="
                curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
                echo "=== Remove composer.lock (if exists) ==="
                rm -f composer.lock
                echo "=== Run composer install ==="
                composer install --no-dev --optimize-autoloader
            '''
        }
    }

    stage('Deploy to Local Container') {
        sh '''
            set -e
            echo "=== Membersihkan folder target /deploy/laravel ==="
            rm -rf /deploy/laravel
            mkdir -p /deploy/laravel
            echo "=== Menyalin semua file dari workspace ke /deploy/laravel ==="
            cp -r . /deploy/laravel/
            echo "=== Mengatur permission storage & bootstrap/cache ==="
            chmod -R 777 /deploy/laravel/storage /deploy/laravel/bootstrap/cache || true
            echo "✅ Deploy selesai"
        '''
    }

    stage('Ensure Target Container') {
        sh '''
            set -e
            if docker ps --format '{{.Names}}' | grep -q laravel-target; then
                echo "✅ Container laravel-target sudah berjalan."
            else
                echo "❌ Container laravel-target tidak ditemukan! Jalankan docker-compose up -d di folder deploy terlebih dahulu."
                exit 1
            fi
        '''
    }

    stage('Setup Environment') {
        sh '''
            set -e
            echo "=== Membuat file .env dari .env.example ==="
            cp /deploy/laravel/.env.example /deploy/laravel/.env

            echo "=== Generate application key ==="
            docker exec laravel-target bash -c "cd /var/www/html && php artisan key:generate"

            echo "=== Mengatur koneksi database di .env ==="
            docker exec laravel-target sed -i "s/DB_CONNECTION=.*/DB_CONNECTION=mysql/" /var/www/html/.env
            docker exec laravel-target sed -i "s/DB_HOST=.*/DB_HOST=db/" /var/www/html/.env
            docker exec laravel-target sed -i "s/DB_DATABASE=.*/DB_DATABASE=laravel/" /var/www/html/.env
            docker exec laravel-target sed -i "s/DB_USERNAME=.*/DB_USERNAME=laravel_user/" /var/www/html/.env
            docker exec laravel-target sed -i "s/DB_PASSWORD=.*/DB_PASSWORD=secret/" /var/www/html/.env

            echo "=== Menjalankan migrasi database ==="
            docker exec laravel-target bash -c "cd /var/www/html && php artisan migrate --force"

            echo "=== Mengoptimalkan cache (config, route, view) ==="
            docker exec laravel-target bash -c "cd /var/www/html && php artisan config:cache"
            docker exec laravel-target bash -c "cd /var/www/html && php artisan route:cache"
            docker exec laravel-target bash -c "cd /var/www/html && php artisan view:cache"

            echo "✅ Setup environment selesai"
        '''
    }

    stage('Verification') {
        sh '''
            echo "✅ Deployment selesai!"
            echo "🌐 Akses aplikasi di: http://localhost:8082"
            echo "📊 phpMyAdmin: http://localhost:8083 (server: db, user: root, password: secret)"
        '''
    }
}
