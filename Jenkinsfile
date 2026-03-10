node {
    checkout scm

    stage('Build') {
        // Gunakan image composer dengan PHP 8.1/8.2 untuk Laravel 10
        docker.image('composer:2.5').inside('-u root') {
            sh 'rm -f composer.lock'
            sh 'composer install --no-dev'
        }
    }

    stage('Deploy to Local Container') {
        // Bersihkan folder target (di host, yang di-mount ke container target)
        sh 'rm -rf /deploy/laravel/*'
        // Salin semua file (termasuk vendor) ke folder deploy
        sh 'cp -r . /deploy/laravel/'
        // Atur permission untuk storage
        sh 'chmod -R 777 /deploy/laravel/storage /deploy/laravel/bootstrap/cache'
    }

    stage('Setup Environment') {
        // Buat .env dari contoh
        sh 'cp /deploy/laravel/.env.example /deploy/laravel/.env'
        // Generate key
        sh 'docker exec laravel-target php artisan key:generate'
        // Set database connection (sesuaikan dengan konfigurasi MySQL)
        sh '''
            docker exec laravel-target sed -i "s/DB_CONNECTION=.*/DB_CONNECTION=mysql/" /var/www/html/.env
            docker exec laravel-target sed -i "s/DB_HOST=.*/DB_HOST=db/" /var/www/html/.env
            docker exec laravel-target sed -i "s/DB_DATABASE=.*/DB_DATABASE=laravel/" /var/www/html/.env
            docker exec laravel-target sed -i "s/DB_USERNAME=.*/DB_USERNAME=laravel_user/" /var/www/html/.env
            docker exec laravel-target sed -i "s/DB_PASSWORD=.*/DB_PASSWORD=secret/" /var/www/html/.env
        '''
        // Migrasi database
        sh 'docker exec laravel-target php artisan migrate --force'
    }

    stage('Test') {
        sh 'echo "Deployment selesai. Akses aplikasi di http://localhost:8082"'
    }
}
