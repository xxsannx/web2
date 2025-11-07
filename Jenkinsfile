pipeline {
    agent any
    
    stages {
        stage('Setup Node.js') {
            steps {
                script {
                    sh '''
                        # Install Node.js manually
                        curl -fsSL https://deb.nodesource.com/setup_20.x | sudo -E bash -
                        sudo apt-get install -y nodejs
                        
                        # Verify installation
                        echo "Node.js version:"
                        node --version
                        echo "npm version:"
                        npm --version
                    '''
                }
            }
        }
        
        stage('Build Assets') {
            steps {
                echo 'Building frontend assets...'
                sh 'npm install --silent'
                sh 'npm run build'
            }
        }
        
        // Stage lainnya...
    }
}
