pipeline {
    agent any

    options {
        skipDefaultCheckout()
    }

    environment {
        SNYK_TOKEN = credentials('snyk-api-token')
    }

    stages {
        stage('Cleanup Workspace') {
            steps {
                cleanWs()
            }
        }

        stage('Checkout') {
            steps {
                git credentialsId: 'github-token', url: 'https://github.com/hoaroy/webnoithat.git'
            }
        }

        stage('Verify composer.json') {
            steps {
                sh 'ls -la'
            }
        }

        stage('Install Dependencies') {
            steps {
                sh 'composer install --no-interaction --prefer-dist'
            }
        }

        stage('Run Security Scan') {
            steps {
                sh 'snyk test || true'
            }
        }

        stage('Run Unit Tests') {
            steps {
                sh './vendor/bin/phpunit'
            }
        }

        stage('Deploy or Package') {
            steps {
                echo 'Triển khai hoặc build nếu cần (copy lên host, FTP, v.v.)'
            }
        }
    }
}
