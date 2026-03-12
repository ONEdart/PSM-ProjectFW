pipeline {
    agent any

    environment {
        // Sesuaikan dengan IP server Ubuntu-mu (bisa localhost jika Jenkins dan server di mesin sama)
        PROD_HOST = '192.168.1.10' 
        PROD_USER = 'pakelcomedy'
        DEPLOY_PATH = '/var/www/html/psm-projectfw'
        REPO_URL = 'https://github.com/ONEdart/PSM-ProjectFW'
        BRANCH = 'main'
        // Gunakan PHP 8.3 yang sudah diinstall di server
        PHP_BIN = 'php8.3'
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
                    // Gunakan image composer dengan PHP 8.3 (composer:2.7.1 sudah support)
                    docker.image('composer:2.7.1').inside('-u root -v .:/app') {
                        sh 'composer install --no-dev --optimize-autoloader'
                    }
                }
            }
        }

        stage('Deploy to Server') {
            steps {
                script {
                    // Perintah rsync dan ssh. Pastikan container Jenkins sudah memiliki rsync dan ssh-client.
                    sh """
                        rsync -av --delete ./ ${PROD_USER}@${PROD_HOST}:${DEPLOY_PATH}/ \
                            --exclude=.env \
                            --exclude=.git \
                            --exclude=storage
                        ssh ${PROD_USER}@${PROD_HOST} "
                            cd ${DEPLOY_PATH} && \
                            cp -n .env.example .env && \
                            ${PHP_BIN} artisan key:generate
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
