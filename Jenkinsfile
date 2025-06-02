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
                //dir('webnoithat') {
                    sh 'composer install'
               // }
            }
        }

        stage('Prepare Laravel') {
            steps {
                // dir('webnoithat') {
                    sh '''
                        cp .env.example .env
                        php artisan config:clear
                        php artisan key:generate
                        php artisan migrate --force
                    '''
               // }
            }
        }

        stage('Run Tests') {
            steps {
                //dir('webnoithat') {
                    sh './vendor/bin/phpunit'
//}
            }
        }

        stage('Snyk Code Scan') {
    steps {
        withCredentials([string(credentialsId: 'snyk-api-token', variable: 'SNYK_TOKEN')]) {
            sh '''
                npm install -g snyk
                export PATH=$(npm config get prefix)/bin:$PATH
                snyk auth $SNYK_TOKEN
                snyk code test || true
            '''
            }
        }
    }  
}

    post {
        success {
            echo 'Laravel build and tests passed.'
            script {
                withCredentials([string(credentialsId: 'jira-api-token', variable: 'JIRA_TOKEN')]) {
                    sh '''
                        curl -X POST \
                        -H "Content-Type: application/json" \
                        -u "hoaroy2710@gmail.com:$JIRA_TOKEN" \
                        --data '{"body": "Jenkins build *passed* for SCRUM-1 on branch *master*."}' \
                        https://hoaroy2710.atlassian.net/rest/api/2/issue/SCRUM-1/comment
                        '''
                }
            }
        }
        failure {
            echo 'Tests or setup failed.'
            withCredentials([
                usernamePassword(
                    credentialsId: 'jira-api-token',  
                    usernameVariable: 'JIRA_USER',
                    passwordVariable: 'JIRA_TOKEN'
                )
            ]) {
                script {
                    def summary = "CI/CD Pipeline Failed: Web Nội Thất"
                    def description = "Build failed during Jenkins pipeline.\n\nBranch: master\nJob: ${env.JOB_NAME}\nBuild Number: ${env.BUILD_NUMBER}\nURL: ${env.BUILD_URL}"
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

                    sh """
                        curl -X POST -H "Content-Type: application/json" \
                        -u "$JIRA_USER:$JIRA_TOKEN" \
                        --data @- <<EOF
                        ${payload}
                        EOF
                    """
                }
            }
        }
    }
}
