pipeline {
    agent any

    environment {
        PROD_HOST = 'localhost'   // karena host sama, bisa pakai localhost
        PROD_USER = 'pakelcomedy'
        DEPLOY_PATH = '/var/www/html/psm-projectfw'
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
                    docker.image('composer:2').inside('-u root -v .:/app') {
                        sh 'composer install --no-dev --optimize-autoloader'
                    }
                }
            }
        }

        stage('Deploy to Server') {
            steps {
                sshagent(credentials: ['ssh-prod']) {
                    sh """
                        ssh-keyscan -H ${PROD_HOST} >> ~/.ssh/known_hosts || true
                        rsync -av --delete ./ ${PROD_USER}@${PROD_HOST}:${DEPLOY_PATH}/ \
                            --exclude=.env \
                            --exclude=.git \
                            --exclude=storage
                        ssh ${PROD_USER}@${PROD_HOST} "
                            cd ${DEPLOY_PATH} && \
                            cp -n .env.example .env && \
                            php8.3 artisan key:generate
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
