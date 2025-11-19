pipeline {
    agent any

    stages {

        stage('Checkout') {
            steps {
                checkout scm
            }
        }

        stage('Install & Build') {
            steps {
                nodejs(nodeJSInstallationName: 'Node 24.11.0') {
                    sh 'npm install'
                    sh 'npm run build'
                }
            }
        }

        stage('Run Tests') {
            steps {
                nodejs(nodeJSInstallationName: 'Node 25.0') {
                    sh 'npm test'
                }
            }
        }

        stage('Security Scan') {
            steps {
                nodejs(nodeJSInstallationName: 'Node 25.0') {
                    sh 'npm audit --audit-level=high'
                    sh 'npx eslint . --ext .js,.ts'
                }
            }
        }

        stage('Package') {
            steps {
                nodejs(nodeJSInstallationName: 'Node 25.0') {
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
