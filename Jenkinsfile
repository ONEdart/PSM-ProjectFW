pipeline {
    agent any

    environment {
        // Ganti dengan alamat IP server Ubuntu kamu
        PROD_HOST = '192.168.1.10' 
        // Ganti dengan user yang digunakan untuk SSH ke server
        PROD_USER = 'pakelcomedy'
        // Ganti dengan path folder deploy di server
        DEPLOY_PATH = '/var/www/html/psm-projectfw'
        // Ganti dengan URL repository-mu
        REPO_URL = 'https://github.com/ONEdart/PSM-ProjectFW'
        BRANCH = 'main'
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
                    docker.image('composer:latest').inside('-u root -v .:/app') {
                        sh 'composer install --no-dev --optimize-autoloader'
                    }
                }
            }
        }

        stage('Deploy to Server') {
            steps {
                script {
                    sh """
                        rsync -av --delete ./ ${PROD_USER}@${PROD_HOST}:${DEPLOY_PATH}/ \
                            --exclude=.env \
                            --exclude=.git \
                            --exclude=storage
                        ssh ${PROD_USER}@${PROD_HOST} "
                            cd ${DEPLOY_PATH} && \
                            cp .env.example .env && \
                            php artisan key:generate
                        "
                    """
                }
            }
        }
    }

    post {
        success {
            echo '✅ Deploy berhasil!'
        }
        failure {
            echo '❌ Deploy gagal!'
        }
    }
}
