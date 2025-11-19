pipeline {
    agent any

    stages {

        stage('Checkout') {
            steps {
                echo '🔍 Checkout repository...'
                checkout scm
            }
        }

        stage('Use Node 25') {
            steps {
                // Pakai NodeJS Plugin
                nodejs(nodeJSInstallationName: 'Node 25.0') {
                    
                    stage('Install Dependencies') {
                        echo '📦 Installing dependencies...'
                        sh 'npm install'
                    }

                    stage('Build Application') {
                        echo '🏗 Building application...'
                        sh 'npm run build'
                    }

                    stage('Run Tests') {
                        echo '🧪 Running tests...'
                        sh 'npm test'
                    }

                    stage('Security Scan') {
                        echo '🔒 Running npm audit & ESLint security scan'
                        sh 'npm audit --audit-level=high'
                        sh 'npx eslint . --ext .js,.ts'
                    }

                    stage('Package') {
                        echo '📦 Packaging application...'
                        sh 'tar -czf app.tar.gz ./dist'
                    }

                } // end nodejs
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
