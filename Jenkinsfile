pipeline {
    agent any
    stages {
        stage('Checkout') {
            steps {
                git branch: '*/dev'
            }
        }
        stage('Composer Install') {
            steps {
                sh 'composer install --no-dev'
            }
        }
        stage('PHPUnit') {
            steps {
                sh 'vendor/bin/phpunit'
            }
        }
        stage('Create Release') {
            steps {
                sh './create_release.sh'
            }
        }
        stage('Deploy') {
            steps {
                sh './deploy.sh'
            }
        }
    }
}
