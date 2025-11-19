pipeline {
    agent any

    stages {

        stage('Checkout') {
            steps {
                echo '🔍 Checkout repository...'
                checkout scm
            }
        }

        stage('Install & Build') {
            steps {
                // NodeJS Plugin otomatis install Node 25.0 jika belum ada
                nodejs(nodeJSInstallationName: 'Node 25.0') {
                    echo '📦 Installing dependencies...'
                    sh 'npm install'
                    echo '🏗 Building application...'
                    sh 'npm run build'
                }
            }
        }

        stage('Run Tests') {
            steps {
                nodejs(nodeJSInstallationName: 'Node 25.0') {
                    echo '🧪 Running tests...'
                    sh 'npm test'
                }
            }
        }

        stage('Security Scan') {
            steps {
                nodejs(nodeJSInstallationName: 'Node 25.0') {
                    echo '🔒 Running npm audit & ESLint security scan'
                    sh 'npm audit --audit-level=high'
                    sh 'npx eslint . --ext .js,.ts'
                }
            }
        }

        stage('Package') {
            steps {
                nodejs(nodeJSInstallationName: 'Node 25.0') {
                    echo '📦 Packaging application...'
                    sh 'tar -czf app.tar.gz ./dist'
                }
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
