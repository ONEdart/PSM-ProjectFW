node {
    stage('Checkout') {
        checkout scm
        echo "✅ Checkout berhasil"
        sh 'ls -la'
    }

stage('Build Dependencies') {
    docker.image('php:8.2-cli').inside('-u root --dns 8.8.8.8') {
        sh '''
            echo "=== Tes Koneksi ke deb.debian.org ==="
            ping -c 2 deb.debian.org || true
            curl -v http://deb.debian.org || true
            echo "======================================"
            
            apt-get update && apt-get install -y git unzip libicu-dev libzip-dev
            git config --global --add safe.directory /var/jenkins_home/workspace/laravel-deploy
            docker-php-ext-install intl zip
            curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
            rm -f composer.lock
            composer install --no-dev --optimize-autoloader
        '''
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
