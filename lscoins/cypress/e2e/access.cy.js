describe("Routes", () => {
    before(() => {
        cy.recreateDatabase();

        cy.visit("/sign-up");
        cy.get(`[data-cy="sign-up__email"]`).type("student3@salle.url.edu");
        cy.get(`[data-cy="sign-up__password"]`).type("Test001");
        cy.get(`[data-cy="sign-up__repeatPassword"]`).type("Test001");
        cy.get(`[data-cy="sign-up__coins"]`).type("100");
        cy.get(`[data-cy="sign-up__btn"]`).click();
    });

    it("[R-1] shows the homepage to an unauthorized user", () => {
        cy.visit("/");
        cy.get(`[data-cy="home__welcomeMsg"]`).should("exist");
        cy.get(`[data-cy="home__welcomeMsg"]`)
            .invoke("text")
            .should("eq", "Hello stranger!");
    });

    it("[R-2] shows correct message to an authorized user", () => {
        cy.visit("/sign-in");
        cy.get(`[data-cy="sign-in__email"]`).type("student3@salle.url.edu");
        cy.get(`[data-cy="sign-in__password"]`).type("Test001");
        cy.get(`[data-cy="sign-in__btn"]`).click();
        cy.location("pathname").should("eq", "/");
        cy.get(`[data-cy="home__welcomeMsg"]`).should("exist");
        cy.get(`[data-cy="home__welcomeMsg"]`)
            .invoke("text")
            .should("eq", "Hello student3!");
    });

    it("[R-3] shows the sign-in page when unauthorized user tries to access profile page", () => {
        cy.visit("/profile");
        cy.location("pathname").should("eq", "/sign-in");
        cy.get(`[data-cy="sign-in"]`).should("exist");
        cy.get(`[data-cy="sign-in__message"]`).should("exist");
        cy.get(`[data-cy="sign-in__message"]`)
            .invoke("text")
            .should("eq", "You must be logged in to access the profile page.");
    });

    it("[R-4] shows the sign-in page when unauthorized user tries to access change password page", () => {
        cy.visit("/profile/changePassword");
        cy.location("pathname").should("eq", "/sign-in");
        cy.get(`[data-cy="sign-in"]`).should("exist");
        cy.get(`[data-cy="sign-in__message"]`).should("exist");
        cy.get(`[data-cy="sign-in__message"]`)
            .invoke("text")
            .should("eq", "You must be logged in to access the changePassword page.");
    });

    it("[R-5] shows the sign-in page when unauthorized user tries to access market page", () => {
        cy.visit("/market");
        cy.location("pathname").should("eq", "/sign-in");
        cy.get(`[data-cy="sign-in"]`).should("exist");
        cy.get(`[data-cy="sign-in__message"]`).should("exist");
        cy.get(`[data-cy="sign-in__message"]`)
            .invoke("text")
            .should("eq", "You must be logged in to access the market page.");
    });

    it("[R-6] shows market page when user is authorized", () => {
        cy.visit("/sign-in");
        cy.get(`[data-cy="sign-in__email"]`).type("student3@salle.url.edu");
        cy.get(`[data-cy="sign-in__password"]`).type("Test001");
        cy.get(`[data-cy="sign-in__btn"]`).click();
        cy.visit("/market");
        cy.location("pathname").should("eq", "/market");
        cy.get(`[data-cy="market"]`).should("exist");
        cy.get(`[data-cy="market"]`)
            .invoke("text")
            .should("eq", "Here the user can access the cryptomarket.");
    });

    it("[R-7] shows profile page when user is authorized", () => {
        cy.visit("/sign-in");
        cy.get(`[data-cy="sign-in__email"]`).type("student3@salle.url.edu");
        cy.get(`[data-cy="sign-in__password"]`).type("Test001");
        cy.get(`[data-cy="sign-in__btn"]`).click();
        cy.visit("/profile");
        cy.location("pathname").should("eq", "/profile");
        cy.get(`[data-cy="profile"]`).should("exist");
        cy.get(`[data-cy="profile"]`)
            .invoke("text")
            .should("eq", "Here the user can see the profile information.");
    });

    it("[R-8] shows change password page when user is authorized", () => {
        cy.visit("/sign-in");
        cy.get(`[data-cy="sign-in__email"]`).type("student3@salle.url.edu");
        cy.get(`[data-cy="sign-in__password"]`).type("Test001");
        cy.get(`[data-cy="sign-in__btn"]`).click();
        cy.visit("/profile/changePassword");
        cy.location("pathname").should("eq", "/profile/changePassword");
        cy.get(`[data-cy="changePassword"]`).should("exist");
        cy.get(`[data-cy="changePassword"]`)
            .invoke("text")
            .should("eq", "Here the user can change passwords.");
    });
});
