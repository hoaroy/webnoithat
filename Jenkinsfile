pipeline {
    agent any

    environment {
        APP_ENV = 'testing'
        DB_CONNECTION = 'mysql'
        DB_HOST = 'localhost'
        DB_PORT = '3306'
        DB_DATABASE = 'noithat'
        DB_USERNAME = 'root'
        DB_PASSWORD = ''
    }

    stages {
        stage('Clone Source Code') {
            steps {
                git branch: 'master', url: 'https://github.com/hoaroy/webnoithat.git'
            }
        }

        stage('Install Dependencies') {
            steps {
                sh 'composer install --no-interaction --prefer-dist'
            }
        }

        stage('Prepare Laravel') {
            steps {
                sh '''
                    cp .env.example .env
                    echo "APP_ENV=${APP_ENV}" >> .env
                    echo "DB_CONNECTION=${DB_CONNECTION}" >> .env
                    echo "DB_HOST=${DB_HOST}" >> .env
                    echo "DB_PORT=${DB_PORT}" >> .env
                    echo "DB_DATABASE=${DB_DATABASE}" >> .env
                    echo "DB_USERNAME=${DB_USERNAME}" >> .env
                    echo "DB_PASSWORD=${DB_PASSWORD}" >> .env

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
 tests passed.'
        }
        failure {
            echo 'Tests or setup failed.'
        }
    }
}
