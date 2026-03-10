node {
    stage('Checkout') {
        checkout scm
        echo "✅ Checkout berhasil"
        sh 'ls -la'
    }

    stage('Build Dependencies') {
        docker.image('php:8.2-cli').inside('-u root --dns 8.8.8.8') {
            sh '''
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
        sh '''
            rm -rf /deploy/laravel
            mkdir -p /deploy/laravel
            cp -r . /deploy/laravel/
            chmod -R 777 /deploy/laravel/storage /deploy/laravel/bootstrap/cache || true
        '''
    }
    
    stage('Verification') {
        sh 'echo "✅ Build dan deploy selesai! Silakan jalankan setup environment di host."'
    }
}
