pipeline {
    agent any

    environment {
        WORKSPACE_DIR = "/var/jenkins_home/workspace/laravel-dev"
    }

    stages {
        stage('Checkout') {
            steps {
                checkout scm
                script {
                    // Fix Git ownership warning
                    sh "git config --global --add safe.directory ${WORKSPACE_DIR}"
                }
            }
        }

        stage('Build') {
            steps {
                script {
                    docker.image('php:8.2-cli').inside('-u root') {
                        sh '''
                            # Install PHP extensions needed for Laravel & Filament
                            apt-get update && apt-get install -y libicu-dev zip unzip zlib1g-dev libonig-dev libxml2-dev
                            docker-php-ext-install intl bcmath pcntl

                            # Hapus composer.lock agar install terbaru sesuai composer.json
                            rm -f composer.lock

                            # Install Composer jika belum ada
                            php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
                            php composer-setup.php --install-dir=/usr/local/bin --filename=composer
                            rm composer-setup.php

                            # Install dependencies
                            composer install --no-interaction --prefer-dist
                        '''
                    }
                }
            }
        }

        stage('Test') {
            steps {
                script {
                    docker.image('ubuntu:22.04').inside('-u root') {
                        sh 'echo "Pipeline testing success!"'
                    }
                }
            }
        }
    }

    post {
        success {
            echo "Pipeline berhasil!"
        }
        failure {
            echo "Pipeline gagal. Periksa log build."
        }
    }
}