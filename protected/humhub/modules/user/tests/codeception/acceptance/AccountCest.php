<?php
namespace user\acceptance;

use user\AcceptanceTester;

class AccountCest
{
    public function testBaseAccountSettings(AcceptanceTester $I)
    {
        $I->wantTo('ensure that the basic account settings work');
        
        $I->amGoingTo('save access my account settings');
        $I->amUser();
        $I->amOnProfile();
        
        $I->click('Edit account');
        $I->waitForText('Account settings');
        $I->click('Settings');
        
        $I->waitForText('User settings');
        
        $I->amGoingTo('fill the basic settings form');
        
        $I->fillField('#accountsettings-tags', 'Tester, Actor');
        #$I->selectOption('#accountsettings-language', 'Deutsch');
        $I->click('Save');
        
        /*
        $I->expectTo('see the german translation');
        $I->see('Sprache');
        $I->see('Speichern');
        $I->click('Save');
        $I->waitForElementVisible('.data-saved', 5);
         * 
        
        $I->selectOption('#accountsettings-language', 'English(US)');
        $I->click('Save');
        $I->waitForElementVisible('.data-saved', 5);
        */
        
        $I->seeSuccess('Saved');

        $I->amOnProfile();
        $I->expectTo('see my user tags');
        $I->see('User tags');
        $I->see('Tester');
        $I->see('Actor');
    }
    
    public function testSaveBaseNotifications(AcceptanceTester $I)
    {
        $I->wantTo('ensure that the notification settings can be saved');
        
        $I->amGoingTo('save access my account settings');
        $I->amUser();
        $I->amOnProfile();
        
        $I->click('Edit account');
        $I->waitForText('Account settings');
        $I->click('Settings');
        $I->waitForText('User settings');
        
        $I->click('Notifications'); //Notification tab
        $I->waitForText('Send notifications');
        
        $I->expectTo('see the notification settings form');
        $I->see('Send notifications?');
        $I->see('Send activities?');
        $I->selectOption('AccountEmailing[receive_email_notifications]', 'Never');
        $I->selectOption('AccountEmailing[receive_email_activities]', 'Never');
        $I->click('.regular-checkbox-box');
        
        $I->click('Save');
        
        $I->seeSuccess('Saved');
        
        // Refresh page
        $I->amOnPage('index-test.php?r=user%2Faccount%2Femailing');
        $I->waitForElementVisible('#accountemailing-receive_email_activities');
        $I->seeOptionIsSelected('AccountEmailing[receive_email_notifications]', 'Never');
        $I->seeOptionIsSelected('AccountEmailing[receive_email_activities]', 'Never');
    }
}