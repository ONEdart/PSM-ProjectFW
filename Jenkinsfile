pipeline {
    agent any

    environment {
        // Konfigurasi server tujuan (sesuaikan dengan IP dan user kamu)
        PROD_HOST = '192.168.1.10'        // Ganti dengan IP server Ubuntu kamu
        PROD_USER = 'pakelcomedy'          // Ganti dengan username SSH kamu
        DEPLOY_PATH = '/var/www/html/psm-projectfw'
        REPO_URL = 'https://github.com/ONEdart/PSM-ProjectFW'
        BRANCH = 'main'

        // Konfigurasi database (nilai dari instruksi)
        DB_CONNECTION = 'mysql'
        DB_HOST = '127.0.0.1'
        DB_PORT = '3306'
        DB_DATABASE = 'psm_projectfw_db'
        DB_USERNAME = 'psm_user'
        DB_PASSWORD = 'password123'
    }

    stages {
        stage('Checkout') {
            steps {
                git branch: BRANCH, url: REPO_URL
            }
        }

        stage('Build') {
            steps {
                script {
                    docker.image('composer:2.7.1').inside('-u root -v .:/app') {
                        sh 'composer install --no-dev --optimize-autoloader'
                    }
                }
            }
        }

        stage('Deploy Files') {
            steps {
                script {
                    sh """
                        rsync -av --delete ./ ${PROD_USER}@${PROD_HOST}:${DEPLOY_PATH}/ \
                            --exclude=.env \
                            --exclude=.git \
                            --exclude=storage
                    """
                }
            }
        }

        stage('Setup Environment & Database') {
            steps {
                script {
                    sh """
                        ssh ${PROD_USER}@${PROD_HOST} "
                            cd ${DEPLOY_PATH} && \
                            cp .env.example .env && \
                            sed -i 's/^DB_CONNECTION=.*/DB_CONNECTION=${DB_CONNECTION}/' .env && \
                            sed -i 's/^DB_HOST=.*/DB_HOST=${DB_HOST}/' .env && \
                            sed -i 's/^DB_PORT=.*/DB_PORT=${DB_PORT}/' .env && \
                            sed -i 's/^DB_DATABASE=.*/DB_DATABASE=${DB_DATABASE}/' .env && \
                            sed -i 's/^DB_USERNAME=.*/DB_USERNAME=${DB_USERNAME}/' .env && \
                            sed -i 's/^DB_PASSWORD=.*/DB_PASSWORD=${DB_PASSWORD}/' .env && \
                            php8.3 artisan key:generate
                        "
                    """
                }
            }
        }

        stage('Run Migrations') {
            steps {
                script {
                    sh """
                        ssh ${PROD_USER}@${PROD_HOST} "
                            cd ${DEPLOY_PATH} && \
                            php8.3 artisan migrate --force
                        "
                    """
                }
            }
        }
    }

    post {
        success {
            echo '✅ Deploy berhasil! Aplikasi siap diakses.'
        }
        failure {
            echo '❌ Deploy gagal! Periksa log untuk detail error.'
        }
    }
}
