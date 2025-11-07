pipeline {
    agent any

    environment {
        COMPOSER_ALLOW_SUPERUSER = 1
    }

    stages {
        stage('Install Dependencies') {
            steps {
                echo 'Installing PHP dependencies...'
                sh 'composer install --no-dev --optimize-autoloader'
            }
        }

        stage('Build Assets') {
            steps {
                echo 'Building frontend assets...'
                sh 'npm install'
                sh 'npm run production'
            }
        }

        stage('Run Tests') {
            steps {
                echo 'Running Laravel tests...'
                sh 'php artisan test'
                sh './vendor/bin/phpunit'
            }
            post {
                always {
                    junit 'storage/logs/junit.xml'
                }
            }
        }

        stage('Setup Environment') {
            steps {
                echo 'Setting up environment...'
                sh 'cp .env.example .env || true'
                sh 'php artisan key:generate'
            }
        }

        stage('Deploy to Server') {
            steps {
                echo 'Deploying to production server...'
            script {
                // Untuk deployment ke server via SSH
                sshagent(['your-ssh-credentials-id']) {
                sh '''
                    ssh user@your-server.com '
                        cd /var/www/laravel-app &&
                        git pull origin main &&
                        composer install --no-dev --optimize-autoloader &&
                        php artisan migrate --force &&
                        php artisan config:cache &&
                        php artisan route:cache &&
                        php artisan view:cache &&
                        sudo systemctl reload apache2
                    '
                '''
            }
        }
    }
}

    post {
        success {
            echo 'Pipeline completed successfully!'
            // Tambahkan notifikasi di sini (email, slack, dll)
        }
        failure {
            echo 'Pipeline failed!'
        }
    }
}