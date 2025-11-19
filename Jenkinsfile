pipeline {
    agent any

    environment {
        PATH = "/usr/bin:/usr/local/bin:$PATH"  // pastikan Node & npm terlihat Jenkins
    }

    stages {

        stage('Checkout') {
            steps {
                echo '🔍 Checkout repository...'
                checkout scm
            }
        }

        stage('Check Node & npm') {
            steps {
                echo '🛠 Checking Node.js and npm versions'
                sh 'node -v'
                sh 'npm -v'
            }
        }

        stage('Install Dependencies') {
            steps {
                echo '📦 Installing dependencies...'
                sh 'npm install'
            }
        }

        stage('Build Application') {
            steps {
                echo '🏗 Building application...'
                sh 'npm run build'
            }
        }

        stage('Run Tests') {
            steps {
                echo '🧪 Running tests...'
                sh 'npm test'
            }
        }

        stage('Security Scan') {
            steps {
                echo '🔒 Running npm audit & ESLint security scan...'
                sh 'npm audit --audit-level=high'
                sh 'npx eslint . --ext .js,.ts'
            }
        }

        stage('Package') {
            steps {
                echo '📦 Packaging application...'
                sh 'tar -czf app.tar.gz ./dist'
            }
        }
    }

    post {
        always {
            echo '🧹 Cleanup finished'
        }
        failure {
            echo '❌ Pipeline failed!'
        }
    }
}
