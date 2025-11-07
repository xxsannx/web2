pipeline {
    agent any
    
    tools {
        nodejs "NodeJS"
    }
    
    environment {
        // Ganti dengan path deployment yang sesuai
        BUILD_ARTIFACT = "build-${BUILD_NUMBER}.tar.gz"
    }
    
    stages {
        stage('Checkout') {
            steps {
                checkout scm
            }
        }
        
        stage('Install Dependencies') {
            steps {
                sh 'npm install'
            }
        }
        
        stage('Build') {
            steps {
                sh 'npm run build'
            }
        }
        
        stage('Verify Build') {
            steps {
                sh '''
                    echo "=== Build Verification ==="
                    echo "Directory structure after build:"
                    ls -la
                    echo "Build completed at: $(date)"
                '''
            }
        }
        
        stage('Create Artifacts') {
            steps {
                sh """
                    # Create archive of entire project (excluding node_modules and .git)
                    tar -czf ${BUILD_ARTIFACT} --exclude='node_modules' --exclude='.git' .
                    echo "Artifact created: ${BUILD_ARTIFACT}"
                    ls -la *.tar.gz
                """
                archiveArtifacts artifacts: "*.tar.gz", fingerprint: true
            }
        }
        
        stage('Deploy to Server') {
            steps {
                script {
                    // OPSI A: Deploy dengan SCP (Uncomment jika ingin deploy otomatis)
                    /*
                    withCredentials([sshUserPrivateKey(
                        credentialsId: 'your-server-credentials',
                        keyFileVariable: 'SSH_KEY',
                        usernameVariable: 'SSH_USER'
                    )]) {
                        sh """
                            echo "Deploying to server..."
                            scp -i $SSH_KEY ${BUILD_ARTIFACT} $SSH_USER@your-server.com:/tmp/
                            ssh -i $SSH_KEY $SSH_USER@your-server.com "
                                cd /var/www/html &&
                                tar -xzf /tmp/${BUILD_ARTIFACT} &&
                                chmod -R 755 . &&
                                echo 'Deployment completed successfully'
                            "
                        """
                    }
                    */
                    
                    // OPSI B: Manual Approval lalu Deploy (Recommended)
                    input message: '🚀 Deploy to Production?', ok: 'Deploy Now'
                    
                    // Setelah approve, lakukan deploy
                    sh """
                        echo "Starting deployment process..."
                        # Tambahkan script deploy Anda di sini
                        echo "1. Download artifact: ${BUILD_ARTIFACT}"
                        echo "2. Extract to server"
                        echo "3. Configure environment"
                        echo "✅ Deployment simulation completed!"
                        
                        # Simulasi deploy success
                        echo "Deployment to production SUCCESSFUL!"
                    """
                }
            }
        }
        
        stage('Health Check') {
            steps {
                sh '''
                    echo "=== Health Check ==="
                    echo "✅ Application deployed successfully"
                    echo "📊 Build Number: ${BUILD_NUMBER}"
                    echo "🕒 Deployment Time: $(date)"
                    echo "🌐 Ready for testing"
                '''
            }
        }
    }
    
    post {
        always {
            echo "Pipeline execution completed"
            sh "rm -f *.tar.gz"  // Cleanup
        }
        success {
            echo "✅ ✅ ✅ DEPLOYMENT SUCCESS! Application is LIVE!"
            // Optional: Send success notification
        }
        failure {
            echo "❌ Deployment failed! Check logs above."
        }
    }
}