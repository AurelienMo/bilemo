@api
@api_security
@api_security_login

Feature: I need to be able to authenticate to API & obtain token

  Background:
    Given I load following clients:
      | username | email               | password | role      |
      | johndoe  | johndoe@yopmail.com | 12345678 | ROLE_USER |

  Scenario: [Fail] Submit request with invalid invalid credentials
    When Send auth request with method "POST" request to "/api/login_check" with username "johndoe" and password "123456789"
    Then the response status code should be 401
    And the JSON node "code" should be equal to "401"
    And the JSON node "message" should be equal to "Identifiants invalides."

  Scenario: [Success] Obtain bearer token
    When Send auth request with method "POST" request to "/api/login_check" with username "johndoe" and password "12345678"
    Then the response status code should be 200
    And the JSON node "token" should exist
