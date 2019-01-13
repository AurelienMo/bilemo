@api
@api_phones
@api_phones_detail

Feature: I need to be able to access detail phone information

  Background:
    Given I load following clients:
      | username | email               | password | role        |
      | johndoe  | johndoe@yopmail.com | 12345678 | ROLE_CLIENT |
    And I load following collaborators:
      | username | email               | password | role              |
      | bilemo   | bilemo@yopmail.com  | 12345678 | ROLE_COLLABORATOR |
    And I load prod datas
    And phone with name "P20 Pro" must return following unique identifier "BBBBBBBB-BBBB-BBBB-BBBB-BBBBBBBBBBBB"

  Scenario: [Fail] Try to submit request without auth
    When I send a "GET" request to "/api/phones/75232bb8-062d-452f-afb2-49c5bd2c8fd3"
    Then the response status code should be 401
    And the JSON node "message" should be equal to "Merci de vous authentifier."

  Scenario: [Fail] Try to submit request to not found phone
    When After authentication on url "/api/login_check" with method "POST" as user "johndoe" with password "12345678", I send a "GET" request to "/api/phones/AAAAAAAA-AAAA-AAAA-AAAA-AAAAAAAAAAAA" with body:
    """
    """
    Then the response status code should be 404
    And the JSON node "message" should be equal to "Ce produit n'existe pas."

  Scenario: [Success] Obtain detail phone information with user as role ROLE_CLIENT
    When After authentication on url "/api/login_check" with method "POST" as user "johndoe" with password "12345678", I send a "GET" request to "/api/phones/BBBBBBBB-BBBB-BBBB-BBBB-BBBBBBBBBBBB" with body:
    """
    """
    Then the response status code should be 200
    And the JSON should be valid according to this schema:
    """
    {
        "type": "object",
        "properties": {
            "id": {
                "type": "string",
                "required": true
            },
            "name": {
                "type": "string",
                "required": true
            },
            "options": {
                "type": "array",
                "items": {
                    "$ref": "#/definitions/OptionOutput"
                }
            },
            "links": {
                "type": "array",
                "items": {
                    "$ref": "#/definitions/LinkOutput"
                }
            }
        },
        "definitions": {
            "OptionOutput": {
                "type": "object"
            },
            "LinkOutput": {
                "type": "object"
            }
        }
    }
    """

