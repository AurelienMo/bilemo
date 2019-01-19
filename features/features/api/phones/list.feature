@api
@api_phones
@api_phones_list

Feature: As an auth user, I need to be able to get list phones

  Background:
    Given I load following clients:
      | username | email               | password | role        |
      | johndoe  | johndoe@yopmail.com | 12345678 | ROLE_CLIENT |
    And I load following collaborators:
      | username | email               | password | role              |
      | bilemo   | bilemo@yopmail.com  | 12345678 | ROLE_COLLABORATOR |
    And I load prod datas

  Scenario: [Fail] Try to get list phones without auth
    When I send a "GET" request to "/api/phones"
    Then the response status code should be 401
    And the JSON node "message" should be equal to "Merci de vous authentifier."

  Scenario: [Success] Get list phones with auth as ROLE_CLIENT
    When After authentication on url "/api/login_check" with method "POST" as user "johndoe" with password "12345678", I send a "GET" request to "/api/phones" with body:
    """
    """
    Then the response status code should be 200
    And the JSON should be valid according to this schema:
    """
    {
        "type": "array",
        "items": {
            "$ref": "#/definitions/PhoneForListOutput"
        },
        "definitions": {
            "PhoneForListOutput": {
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
                    "os": {
                        "type": "string",
                        "required": true
                    },
                    "memory": {
                        "type": "string",
                        "required": true
                    }
                }
            }
        }
    }
    """
    And the JSON node "root[0]._links" should have 1 element

  Scenario: [Success] Get list phones with auth as ROLE_COLLABORATOR
    When After authentication on url "/api/login_check" with method "POST" as user "bilemo" with password "12345678", I send a "GET" request to "/api/phones" with body:
    """
    """
    Then the response status code should be 200
    And the JSON should be valid according to this schema:
    """
    {
        "type": "array",
        "items": {
            "$ref": "#/definitions/PhoneForListOutput"
        },
        "definitions": {
            "PhoneForListOutput": {
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
                    "os": {
                        "type": "string",
                        "required": true
                    },
                    "memory": {
                        "type": "string",
                        "required": true
                    }
                }
            }
        }
    }
    """
    And the JSON node "root[0]._links" should have 2 elements
