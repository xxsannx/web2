pipeline {
    agent any

    tools {
        php 'PHP'  // Gunakan PHP yang sudah dikonfigurasi di Jenkins
        nodejs 'NodeJS'  // Gunakan Node.js yang sudah dikonfigurasi di Jenkins
    }

    environment {
        // Menyeting environment variables untuk tes Laravel dan MySQL (SQLite untuk pengujian)
        DB_CONNECTION = 'sqlite'
        DB_DATABASE = ':memory:'  // Menggunakan SQLite dalam memori untuk pengujian
        APP_ENV = 'testing'  // Set environment Laravel untuk pengujian
    }

    stages {
        stage('Checkout Code') {
            steps {
                echo 'Checking out code from repository...'
                checkout scm
            }
        }

        stage('Install Dependencies') {
            steps {
                echo 'Installing PHP dependencies...'
                // Instalasi dependensi PHP menggunakan Composer
                sh 'composer install --no-dev --optimize-autoloader'

                echo 'Installing Node.js dependencies...'
                // Instalasi dependensi frontend menggunakan npm
                sh 'npm install --silent'
           }
        }

        stage('Setup Database') {
            steps {
                echo 'Running database migrations for testing...'
                // Jalankan migrasi untuk database SQLite yang digunakan untuk pengujian
                sh 'php artisan migrate --env=testing'
            }
        }

        stage('Run Tests') {
            steps {
                echo 'Running PHPUnit tests...'
                // Menjalankan PHPUnit untuk pengujian
                sh './vendor/bin/phpunit --configuration phpunit.xml'
            }
        }

        stage('Build Frontend Assets') {
            steps {
                echo 'Building frontend assets...'
                // Membangun aset frontend menggunakan Vite atau alat build lainnya
                sh 'npm run build'
            }
        }

        stage('Deploy to Staging') {
            steps {
                echo 'Deploying to staging server...'
                // Anda bisa menambahkan langkah-langkah untuk deploy ke server staging di sini
                // Misalnya menggunakan SCP atau alat lainnya
                // sh 'scp -r dist/* user@staging-server:/path/to/staging'
            }
        }

        stage('Deploy to Production') {
            steps {
                echo 'Deploying to production server...'
                // Anda bisa menambahkan langkah-langkah untuk deploy ke server produksi di sini
                // Misalnya menggunakan SCP atau alat lainnya
                // sh 'scp -r dist/* user@production-server:/path/to/production'
            }
        }
    }

    post {
        always {
            // Membersihkan workspace setelah pipeline selesai
            cleanWs()        }

        success {
            // Jika pipeline berhasil, tampilkan pesan sukses
            echo '✅ Pipeline succeeded!'
        }

        failure {
            // Jika pipeline gagal, tampilkan pesan gagal
            echo '❌ Pipeline failed!'
        }
  }
}
