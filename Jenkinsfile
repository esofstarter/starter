pipeline {
    agent any
    stages {
        stage('Build') {
            steps {
                git 'https://github.com/esofstarter/starter.git'
            }
        }
        stage('Composer Install') {
            steps {
                sh 'composer install --no-dev'
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
