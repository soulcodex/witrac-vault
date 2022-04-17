Feature: List all application available libraries

  @createLibrary
  Scenario: I create a library and then request the list
    Given I make a POST request to "/api/libraries" with body
    """
    {
      "name": "Fantasy"
    }
    """
    Then the response status code should be 201
    Then I make a GET request to "api/libraries"
    Then the response status code should be 200