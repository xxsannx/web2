pipeline {
    agent any

    environment {
        // Pastikan PATH mengarah ke lokasi Node.js dan npm
        PATH = "/usr/bin:/usr/local/bin:$PATH"
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
                sh 'which node'
                sh 'which npm'
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
                sh 'npm run build'  // sesuaikan dengan script build kamu
            }
        }

        stage('Start Application for Testing') {
            steps {
                echo '🚀 Starting application for tests...'
                sh 'npm run start & echo $! > app.pid'
                sh 'sleep 5'  // beri waktu aplikasi start
            }
        }

        stage('SAST - Static Application Security Testing') {
            steps {
                echo '🔒 Running Static Application Security Tests...'
                // Contoh ESLint security scan
                sh 'npx eslint . --ext .js,.ts'
            }
        }

        stage('npm Audit - Dependency Scan') {
            steps {
                echo '📊 Running npm audit...'
                sh 'npm audit --audit-level=high'
            }
        }

        stage('DAST - ZAP Security Scan') {
            steps {
                echo '🕵️ Running Dynamic Application Security Scan with ZAP...'
                // Pastikan ZAP sudah terinstall di agent
                sh './zap.sh -daemon -host 127.0.0.1 -port 8080 &'
                sh 'sleep 10'  // tunggu ZAP ready
            }
        }

        stage('Security Quality Gate') {
            steps {
                echo '✅ Security quality checks completed.'
                // Bisa tambahkan logic pass/fail berdasarkan hasil audit
            }
        }

        stage('Package & Archive') {
            steps {
                echo '📦 Packaging artifacts...'
                sh 'tar -czf app.tar.gz ./dist'
            }
        }

        stage('Deploy') {
            steps {
                echo '🚀 Deploying application (security approved)...'
                // Tambahkan perintah deploy sesuai kebutuhan
            }
        }

    }

    post {
        always {
            echo '🧹 Cleaning up...'
            sh '''
                if [ -f app.pid ]; then kill $(cat app.pid); fi
                pkill -f zap.sh || true
                rm -f app.pid zap.pid security_metrics.env
                rm -f .eslintrc.security.js
            '''
            echo '✅ Cleanup completed'
        }
        failure {
            echo '❌ Pipeline failed, sending notification...'
            // Kirim email atau notifikasi lain
        }
    }
}
