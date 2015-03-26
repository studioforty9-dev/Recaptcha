Feature: Contact Form ReCaptcha
  As a website visitor
  I want to submit my information
  Without spamming the website

  Scenario: Unsuccessful submission of the ReCaptcha on contact form on contacts page
    Given I am on "/contacts"
    And the page has the required layout XML defined
    When I submit the form without setting the captcha
    Then I should be redirected back
    And I should see "message goes here"

  Scenario: Unsuccessful submission of the ReCaptcha on contact form on arbitrary cms page
    Given I am on a cms page
    And the page has the required layout XML defined
    When I submit the form without setting the captcha
    Then I should be redirected back
    And I should see "message goes here"
