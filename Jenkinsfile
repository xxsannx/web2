pipeline {
    agent any

    environment {
        APP_NAME = "pineus-tilu"
        DEPLOY_HOST = credentials('SERVER_HOST')   // SSH Host
        DEPLOY_USER = credentials('SERVER_USER')   // SSH User
        DEPLOY_KEY  = credentials('SERVER_KEY')    // SSH Private Key
        NODE_VERSION = '18'                         // Node.js version
    }

    stages {

        stage('Checkout') {
            steps {
                echo "🔍 Checkout repository"
                checkout scm
            }
        }

        stage('Setup Environment') {
            steps {
                echo "🛠 Setting up Node.js and Java"
                // Setup Node.js
                nodejs(nodeJSInstallationName: 'Node 18') {
                    sh 'node -v'
                    sh 'npm -v'
                }
                // Setup Java for OWASP ZAP
                // Pastikan Java terinstall di agent / Jenkins Global Tool
                sh 'java -version'
            }
        }

        stage('Install Dependencies') {
            steps {
                nodejs(nodeJSInstallationName: 'Node 18') {
                    sh 'npm ci'
                    sh 'composer install --prefer-dist --no-interaction --no-progress --optimize-autoloader'
                }
            }
        }

        stage('Build Application') {
            steps {
                nodejs(nodeJSInstallationName: 'Node 18') {
                    sh 'npm run build || true'
                }
            }
        }

        stage('Run Tests') {
            steps {
                nodejs(nodeJSInstallationName: 'Node 18') {
                    sh 'php artisan test'
                }
            }
        }

        stage('Static Analysis (ESLint)') {
            steps {
                nodejs(nodeJSInstallationName: 'Node 18') {
                    sh 'npx eslint . --ext .js,.ts || true'
                }
            }
        }

        stage('Dynamic Security Scan (OWASP ZAP)') {
            steps {
                echo "🔒 Running OWASP ZAP scan"
                sh '''
                    docker run --rm -t owasp/zap2docker-stable zap-baseline.py \
                    -t http://localhost:8000 \
                    -r zap_report.html || true
                '''
            }
        }

        stage('Deploy') {
            steps {
                echo "🚀 Deploying application"
                sshagent(credentials: ['deploy-ssh-key']) {
                    sh '''
                        ssh -o StrictHostKeyChecking=no $DEPLOY_USER@$DEPLOY_HOST '
                            cd /opt/pineus-tilu &&
                            git pull &&
                            docker-compose down &&
                            docker-compose up -d --build &&
                            php artisan migrate --force
                        '
                    '''
                }
            }
        }
    }

    post {
        always {
            echo '🧹 Pipeline finished'
        }
        success {
            echo '✅ Pipeline succeeded'
        }
        failure {
            echo '❌ Pipeline failed'
        }
    }
}
