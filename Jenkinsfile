node {
    stage('Checkout') {
        checkout scm
        echo "Checkout berhasil!"
        sh 'ls -la'
    }
    
    stage('Test Docker') {
        sh 'docker --version'
    }
    
    stage('Success') {
        echo "Pipeline berjalan!"
    }
}
