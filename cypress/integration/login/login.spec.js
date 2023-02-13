/// <reference types="Cypress" /> 

context('Login', () => {
    beforeEach(() => {
        cy.visit('http://admin.starter.test/')
    })
    describe('Going to login page and loggin in', () => {
        it('works', () => {
            cy.get('input[name=email]')
                .type('admin@example.com').should('have.value', 'admin@example.com')
            cy.get('input[type=password]')
                .type('password',{delay:100}).should('have.value','password')

            cy.contains('Login')
                .click()
            // cy.request('POST',Cypress.config().baseUrl+'/api/auth/login',{email:'admin@example.com',password:'password'})
            //     .then((resp) =>{
            //         expect(resp.status).to.eq(200)
            //         // expect(resp.redirectedToUrl).to.eq(Cypress.config().baseUrl+'/admin')
            //         cy.url().should('eq', Cypress.config().baseUrl+'/admin')
            //     })
            // it('Try and log in', function () {
            //     cy.task('queryDb', "CREATE TABLE Persons (PersonID int, FirstName varchar(255), Address varchar(255), City varchar(255))")
            // })
            cy.wait(6000)
            cy.url().should('eq', Cypress.config().baseUrl+'/admin') //'http://admin.starter.test/admin'
        //     cy.url().should((loc)=>{
        //         expect(loc.pathname,{timeout:10000}).to.eq('/admin')
        //     })
        })
    })
})