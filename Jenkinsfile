pipeline {
    agent any
    stages {
        stage("Cloning repository") {
            steps {
                git url: 'git@github.com:esofstarter/starter.git', branch: 'dev'
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
