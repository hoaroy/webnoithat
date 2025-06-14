pipeline {
    agent any

    environment {
        APP_ENV = 'testing'
        APP_KEY = ''
        DB_CONNECTION = 'mysql'
        DB_HOST = 'localhost'
        DB_PORT = '3306'
        DB_DATABASE = 'noithat'
        DB_USERNAME = 'root'
        DB_PASSWORD = ''

        JIRA_TICKET = 'SCRUM-1'
        JIRA_URL = 'https://hoaroy2710.atlassian.net'
    }

    stages {
        stage('Clone Source Code') {
            steps {
                git branch: 'master',
                    url: 'https://github.com/hoaroy/webnoithat.git'
            }
        }

        stage('Install Dependencies') {
            steps {
                sh 'composer install'
            }
        }

        stage('Prepare Laravel') {
            steps {
                sh '''
                    cp .env.example .env
                    php artisan config:clear
                    php artisan key:generate
                    php artisan migrate --force
                '''
            }
        }

        stage('Run Tests') {
            steps {
                sh './vendor/bin/phpunit'
            }
        }

        stage('Snyk Code Scan') {
            steps {
                withCredentials([string(credentialsId: 'snyk-api-token', variable: 'SNYK_TOKEN')]) {
                    sh '''
                        npm install -g snyk@1.1185.0
                        export PATH=$(npm config get prefix)/bin:$PATH
                        snyk auth $SNYK_TOKEN
                        snyk code test || true
                    '''
                }
            }
        }  
    }

    failure {
        echo 'Tests or setup failed.'

        withCredentials([
            usernamePassword(
                credentialsId: 'jira-api-tokenn', 
                usernameVariable: 'JIRA_USER',
                passwordVariable: 'JIRA_TOKEN'
            )
        ]) {
            script {
                def summary = "CI/CD Pipeline Failed: Web Noi That"
                def description = """
                    Build failed in Jenkins.
                    
                    • Branch: ${env.BRANCH_NAME ?: 'master'}
                    • Job: ${env.JOB_NAME}
                    • Build #: ${env.BUILD_NUMBER}
                    • URL: ${env.BUILD_URL}
                """.stripIndent().trim()

                def payload = """
                {
                  "fields": {
                    "project": {
                      "key": "SCRUM"
                    },
                    "summary": "${summary}",
                    "description": "${description}",
                    "issuetype": {
                      "name": "Bug"
                    }
                  }
                }
                """

                echo "Sending Jira issue payload..."
                sh """
                    curl --fail -X POST \\
                         -H "Content-Type: application/json" \\
                         -u "$JIRA_USER:$JIRA_TOKEN" \\
                         --data @- <<EOF
${payload}
EOF
                """
            }
        }
    }
}
