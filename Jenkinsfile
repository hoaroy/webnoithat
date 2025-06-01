pipeline {
    agent any

    environment {
        APP_ENV = 'testing'
        APP_KEY = ''
        DB_CONNECTION = 'mysql'
        DB_HOST = 'localhost'
        DB_PORT = '3306'
        DB_DATABASE = 'webnoithat_test'
        DB_USERNAME = 'root'
        DB_PASSWORD = ''
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
    }

    post {
        success {
            echo 'Laravel build and tests passed.'
        }
        failure {
            echo 'Tests or setup failed.'
        }
    }
}
