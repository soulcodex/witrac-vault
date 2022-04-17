Feature: Create a new library to group files

  Scenario: A valid library name
    Given I make a POST request to "/api/libraries" with body
    """
    {
      "name": "Fantasy"
    }
    """
    Then the response content should be empty
    And the response status code should be 201

  Scenario: A invalid library name
    Given I make a POST request to "/api/libraries" with body
    """
    {
      "name": null
    }
    """
    Then the response status code should be 400