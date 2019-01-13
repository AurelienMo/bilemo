@api
@api_client
@api_client_create

Feature: As an auth user from BilemoCompany, I need to be able to create a client

  Background:
    Given I load following collaborators:
      | username | email               | password | role              |
      | bilemo   | bilemo@yopmail.com  | 12345678 | ROLE_COLLABORATOR |
    And I load following clients:
      | username | email               | password | role        |
      | johndoe  | johndoe@yopmail.com | 12345678 | ROLE_CLIENT |

  Scenario: [Fail] Try to create client without authentication
    When I send a "POST" request to "/api/clients" with body:
    """
    {
    }
    """
    Then the response status code should be 401
    And the JSON node "message" should be equal to "Merci de vous authentifier."

  Scenario: [Fail] Try to create client with client account
    When After authentication on url "/api/login_check" with method "POST" as user "johndoe" with password "12345678", I send a "POST" request to "/api/clients" with body:
    """
    {
    }
    """
    Then the response status code should be 403
    And the JSON node "message" should be equal to "Vous devez faire partis de la société Bilemo pour créer des comptes clients."

  Scenario: [Fail] Try to create client with bilemo account but no payload
    When After authentication on url "/api/login_check" with method "POST" as user "bilemo" with password "12345678", I send a "POST" request to "/api/clients" with body:
    """
    {
    }
    """
    Then the response status code should be 400
    And the JSON should be equal to:
    """
    {
        "username": [
            "Un nom d'utilisateur est requis."
        ],
        "email": [
            "Une adresse email est requise."
        ],
        "password": [
            "Vous devez spécifier un mot de passe."
        ]
    }
    """

  Scenario: [Fail] Try to create client with bilemo account but client already exist
    When After authentication on url "/api/login_check" with method "POST" as user "bilemo" with password "12345678", I send a "POST" request to "/api/clients" with body:
    """
    {
        "username": "johndoe",
        "email": "johndoe@yopmail.com",
        "password": "12345678"
    }
    """
    Then the response status code should be 400
    And the JSON should be equal to:
    """
    {
        "": [
            "Un compte client est déjà existant avec cet identiant, adresse email."
        ]
    }
    """

  Scenario: [Success] Create a new client
    When After authentication on url "/api/login_check" with method "POST" as user "bilemo" with password "12345678", I send a "POST" request to "/api/clients" with body:
    """
    {
        "username": "janedoe",
        "email": "janedoe@yopmail.com",
        "password": "12345678"
    }
    """
    Then the response status code should be 201
    And the header "Location" exist
