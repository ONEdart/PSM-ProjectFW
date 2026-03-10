node {
    stage('Checkout') {
        checkout scm
        echo "✅ Checkout berhasil dari repository"
        sh 'ls -la'
    }

    stage('Build Dependencies') {
        // Gunakan image PHP resmi dengan CLI, install composer dan ekstensi intl
        docker.image('php:8.1-cli').inside('-u root') {
            // Install dependency system, git, unzip, dan ekstensi intl
            sh 'apt-get update && apt-get install -y git unzip libicu-dev'
            sh 'docker-php-ext-install intl'

            // Install composer
            sh 'curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer'

            // Hapus composer.lock untuk menghindari konflik versi
            sh 'rm -f composer.lock'

            // Install dependensi tanpa dev
            sh 'composer install --no-dev --optimize-autoloader'
        }
    }

    stage('Deploy to Local Container') {
        sh 'rm -rf /deploy/laravel/* || true'
        sh 'mkdir -p /deploy/laravel'
        sh 'cp -r . /deploy/laravel/'
        sh 'chmod -R 777 /deploy/laravel/storage /deploy/laravel/bootstrap/cache || true'
    }

    stage('Setup Environment') {
        sh 'cp /deploy/laravel/.env.example /deploy/laravel/.env'
        sh 'docker exec laravel-target php artisan key:generate'
        sh '''
            docker exec laravel-target sed -i "s/DB_CONNECTION=.*/DB_CONNECTION=mysql/" /var/www/html/.env
            docker exec laravel-target sed -i "s/DB_HOST=.*/DB_HOST=db/" /var/www/html/.env
            docker exec laravel-target sed -i "s/DB_DATABASE=.*/DB_DATABASE=laravel/" /var/www/html/.env
            docker exec laravel-target sed -i "s/DB_USERNAME=.*/DB_USERNAME=laravel_user/" /var/www/html/.env
            docker exec laravel-target sed -i "s/DB_PASSWORD=.*/DB_PASSWORD=secret/" /var/www/html/.env
        '''
        sh 'docker exec laravel-target php artisan migrate --force'
        sh 'docker exec laravel-target php artisan config:cache'
        sh 'docker exec laravel-target php artisan route:cache'
        sh 'docker exec laravel-target php artisan view:cache'
    }

    stage('Verification') {
        sh 'echo "✅ Deployment selesai! Akses aplikasi di http://localhost:8082"'
    }
}
