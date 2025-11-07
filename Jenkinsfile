pipeline {
    agent any
    
    tools {
        nodejs "NodeJS"
    }
    
    environment {
        // ZAP Configuration dengan port berbeda
        ZAP_DOCKER_IMAGE = "owasp/zap2docker-stable"
        ZAP_REPORT_DIR = "zap-reports"
        ZAP_PORT = "8090"
        TARGET_URL = "http://host.docker.internal:4173"
        
        // Application Configuration
        BUILD_ARTIFACT = "build-${BUILD_NUMBER}.tar.gz"
        SECURITY_SCORE_THRESHOLD = "80"
    }
    
    parameters {
        choice(
            choices: ['staging', 'production'],
            description: 'Select deployment environment',
            name: 'DEPLOY_ENVIRONMENT'
        )
        
        booleanParam(
            defaultValue: true,
            description: 'Run full ZAP active scan (takes longer)',
            name: 'RUN_FULL_ZAP_SCAN'
        )
        
        string(
            defaultValue: '',
            description: 'Custom target URL for security testing (optional)',
            name: 'CUSTOM_TARGET_URL'
        )
    }
    
    stages {
        stage('Checkout Code') {
            steps {
                checkout scm
                sh '''
                    echo "🔍 Starting Security Pipeline"
                    echo "📊 ZAP will use port: ${ZAP_PORT}"
                    echo "🌐 Jenkins is using port: 8080"
                    echo "🎯 Target Environment: ${DEPLOY_ENVIRONMENT}"
                '''
            }
        }
        
        stage('Install Dependencies') {
            steps {
                sh '''
                    echo "📦 Installing dependencies..."
                    npm install
                '''
            }
        }
        
        stage('Build Application') {
            steps {
                sh '''
                    echo "🏗️ Building application..."
                    npm run build
                    echo "✅ Build completed"
                '''
            }
        }
        
        stage('Start Application') {
            steps {
                sh '''
                    echo "🚀 Starting application on port 4173..."
                    npm run preview -- --port 4173 &
                    APP_PID=$!
                    echo $APP_PID > app.pid
                    sleep 20
                    
                    # Test if app is running
                    curl -f http://localhost:4173 > /dev/null 2>/dev/null && echo "✅ Application is running on port 4173" || echo "⚠️ Application might not be ready"
                '''
            }
        }
        
        stage('SAST - Static Analysis') {
            parallel {
                stage('npm Audit') {
                    steps {
                        sh '''
                            echo "🔒 Running npm audit..."
                            mkdir -p sast-reports
                            npm audit --audit-level moderate > sast-reports/npm-audit.txt || true
                            npm audit --json > sast-reports/npm-audit.json || true
                        '''
                    }
                }
                
                stage('Dependency Check') {
                    steps {
                        sh '''
                            echo "📦 Checking dependencies..."
                            mkdir -p sast-reports
                            npm list --depth=0 > sast-reports/dependencies.txt
                            npx license-checker --json > sast-reports/licenses.json 2>/dev/null || echo "License checker not available"
                        '''
                    }
                }
            }
        }
        
        stage('DAST - ZAP Baseline Scan') {
            steps {
                script {
                    echo "🎯 Starting ZAP Baseline Scan on port ${ZAP_PORT}"
                    
                    sh """
                        mkdir -p ${ZAP_REPORT_DIR}
                        echo "ZAP will run on port ${ZAP_PORT}"
                    """
                    
                    // Determine target URL
                    def actualTargetUrl = params.CUSTOM_TARGET_URL ?: env.TARGET_URL
                    
                    // Run ZAP Baseline Scan
                    sh """
                        docker run --rm \\
                          -v $(pwd)/${ZAP_REPORT_DIR}:/zap/reports \\
                          -t ${ZAP_DOCKER_IMAGE} zap-baseline.py \\
                          -t ${actualTargetUrl} \\
                          -J /zap/reports/zap-baseline-report.json \\
                          -r /zap/reports/zap-baseline-report.html \\
                          -x /zap/reports/zap-baseline-report.xml \\
                          -a || echo "ZAP baseline scan completed"
                        
                        echo "✅ ZAP Baseline Scan finished"
                    """
                }
            }
            post {
                always {
                    archiveArtifacts artifacts: "${ZAP_REPORT_DIR}/zap-baseline-report.*", fingerprint: true
                    publishHTML([
                        allowMissing: true,
                        alwaysLinkToLastBuild: true,
                        keepAll: true,
                        reportDir: "${ZAP_REPORT_DIR}",
                        reportFiles: 'zap-baseline-report.html',
                        reportName: 'ZAP Baseline Report'
                    ])
                }
            }
        }
        
        stage('DAST - ZAP Full Scan') {
            when {
                expression { params.RUN_FULL_ZAP_SCAN == true }
            }
            steps {
                script {
                    echo "⚡ Running ZAP Full Active Scan"
                    
                    def actualTargetUrl = params.CUSTOM_TARGET_URL ?: env.TARGET_URL
                    
                    sh """
                        # Start ZAP in daemon mode
                        docker run -d --rm \\
                          --name zap-full-scan \\
                          -p ${ZAP_PORT}:8080 \\
                          -v $(pwd)/${ZAP_REPORT_DIR}:/zap/reports \\
                          -t ${ZAP_DOCKER_IMAGE} zap.sh \\
                          -daemon -host 0.0.0.0 -port 8080 \\
                          -config api.disablekey=true
                        
                        echo "⏳ Waiting for ZAP to start..."
                        sleep 15
                        
                        # Spider the target
                        echo "🕷️ Running ZAP Spider..."
                        curl -s "http://localhost:${ZAP_PORT}/JSON/spider/action/scan/?url=${actualTargetUrl}&maxChildren=10&recurse=true" > /dev/null
                        sleep 30
                        
                        # Active scan
                        echo "⚡ Running ZAP Active Scan..."
                        curl -s "http://localhost:${ZAP_PORT}/JSON/ascan/action/scan/?url=${actualTargetUrl}&recurse=true&inScopeOnly=true" > /dev/null
                        
                        echo "⏳ Waiting for active scan to complete (2 minutes)..."
                        sleep 120
                        
                        # Generate reports
                        echo "📊 Generating reports..."
                        curl -s "http://localhost:${ZAP_PORT}/OTHER/core/other/htmlreport/" > ${ZAP_REPORT_DIR}/zap-full-scan-report.html
                        curl -s "http://localhost:${ZAP_PORT}/JSON/core/action/jsonreport/" > ${ZAP_REPORT_DIR}/zap-full-scan-report.json
                        
                        # Stop ZAP container
                        docker stop zap-full-scan
                        
                        echo "✅ ZAP Full Active Scan completed"
                    """
                }
            }
        }
        
        stage('Security Analysis') {
            steps {
                script {
                    sh """
                        echo "📊 Analyzing security results..."
                        
                        SECURITY_SCORE=100
                        HIGH_COUNT=0
                        MEDIUM_COUNT=0
                        LOW_COUNT=0
                        
                        # Analyze ZAP baseline report
                        if [ -f "${ZAP_REPORT_DIR}/zap-baseline-report.json" ]; then
                            HIGH_COUNT=\$(jq -r '[.site[].alerts[] | select(.riskcode == \"3\") | .count] | add // 0' ${ZAP_REPORT_DIR}/zap-baseline-report.json 2>/dev/null || echo "0")
                            MEDIUM_COUNT=\$(jq -r '[.site[].alerts[] | select(.riskcode == \"2\") | .count] | add // 0' ${ZAP_REPORT_DIR}/zap-baseline-report.json 2>/dev/null || echo "0")
                            LOW_COUNT=\$(jq -r '[.site[].alerts[] | select(.riskcode == \"1\") | .count] | add // 0' ${ZAP_REPORT_DIR}/zap-baseline-report.json 2>/dev/null || echo "0")
                            
                            PENALTY=\$((\$HIGH_COUNT * 10 + \$MEDIUM_COUNT * 5 + \$LOW_COUNT * 2))
                            SECURITY_SCORE=\$((100 - \$PENALTY))
                            [ \$SECURITY_SCORE -lt 0 ] && SECURITY_SCORE=0
                        fi
                        
                        echo "SECURITY_SCORE=\$SECURITY_SCORE" > security.env
                        echo "HIGH_COUNT=\$HIGH_COUNT" >> security.env
                        echo "MEDIUM_COUNT=\$MEDIUM_COUNT" >> security.env
                        echo "LOW_COUNT=\$LOW_COUNT" >> security.env
                    """
                    
                    load 'security.env'
                    echo "🔐 Security Score: ${SECURITY_SCORE}/100"
                    echo "High Risk: ${HIGH_COUNT}, Medium Risk: ${MEDIUM_COUNT}, Low Risk: ${LOW_COUNT}"
                    
                    currentBuild.description = "Security: ${SECURITY_SCORE}/100"
                }
            }
        }
        
        stage('Security Quality Gate') {
            steps {
                script {
                    def securityScore = Integer.parseInt(env.SECURITY_SCORE ?: "100")
                    def highCount = Integer.parseInt(env.HIGH_COUNT ?: "0")
                    
                    echo "🚨 Security Quality Gate Assessment"
                    echo "Current Score: ${securityScore}/100"
                    echo "High Risk Issues: ${highCount}"
                    
                    // Critical: Fail if high risk vulnerabilities found
                    if (highCount > 0) {
                        echo "❌ CRITICAL: ${highCount} high risk vulnerabilities detected"
                        if (params.DEPLOY_ENVIRONMENT == 'production') {
                            error "Cannot deploy to production with high risk vulnerabilities"
                        } else {
                            input(
                                message: "⚠️ ${highCount} high risk vulnerabilities found. Continue to ${params.DEPLOY_ENVIRONMENT}?",
                                ok: "Continue Anyway"
                            )
                        }
                    }
                    
                    // Warning: Low security score
                    if (securityScore < Integer.parseInt(env.SECURITY_SCORE_THRESHOLD)) {
                        echo "⚠️ WARNING: Security score ${securityScore} is below threshold ${env.SECURITY_SCORE_THRESHOLD}"
                        input(
                            message: "Security score ${securityScore}/100 is below threshold. Continue deployment to ${params.DEPLOY_ENVIRONMENT}?",
                            ok: "Deploy Anyway"
                        )
                    }
                    
                    echo "✅ Security quality gate passed"
                }
            }
        }
        
        stage('Package & Archive') {
            steps {
                sh """
                    echo "📦 Packaging application..."
                    tar -czf ${BUILD_ARTIFACT} --exclude='node_modules' --exclude='.git' .
                    echo "✅ Package created: ${BUILD_ARTIFACT}"
                """
                
                archiveArtifacts artifacts: "*.tar.gz", fingerprint: true
                archiveArtifacts artifacts: "**/*-report.*", fingerprint: true
            }
        }
        
        stage('Deploy') {
            steps {
                script {
                    echo "🚀 Deploying to ${params.DEPLOY_ENVIRONMENT}"
                    echo "📊 Security Score: ${env.SECURITY_SCORE}/100"
                    echo "🔐 High Risk Issues: ${env.HIGH_COUNT}"
                    
                    // Deployment commands based on environment
                    if (params.DEPLOY_ENVIRONMENT == 'production') {
                        sh '''
                            echo "🔒 PRODUCTION DEPLOYMENT"
                            echo "This would deploy to production servers"
                            # Add your production deployment commands here
                        '''
                    } else {
                        sh '''
                            echo "🧪 STAGING DEPLOYMENT"
                            echo "This would deploy to staging servers"
                            # Add your staging deployment commands here
                        '''
                    }
                    
                    echo "✅ Deployment to ${params.DEPLOY_ENVIRONMENT} completed"
                }
            }
        }
    }
    
    post {
        always {
            sh '''
                echo "🧹 Cleaning up..."
                # Stop application
                kill $(cat app.pid) 2>/dev/null || true
                pkill -f "node" || true
                
                # Stop any running ZAP containers
                docker stop zap-full-scan 2>/dev/null || true
                docker rm zap-full-scan 2>/dev/null || true
                
                # Cleanup files
                rm -f app.pid security.env
                
                echo "✅ Cleanup completed"
            '''
        }
        
        success {
            echo "🎉 Security Pipeline Success!"
            script {
                if (env.SECURITY_SCORE) {
                    echo "📊 Final Security Score: ${env.SECURITY_SCORE}/100"
                    echo "🔐 Vulnerabilities - High: ${env.HIGH_COUNT}, Medium: ${env.MEDIUM_COUNT}, Low: ${env.LOW_COUNT}"
                }
            }
        }
        
        failure {
            echo "❌ Pipeline Failed!"
        }
        
        unstable {
            echo "⚠️ Pipeline Unstable - Security issues detected"
        }
    }
    
    options {
        buildDiscarder(logRotator(numToKeepStr: '10'))
        timeout(time: 60, unit: 'MINUTES')
        disableConcurrentBuilds()
    }
}