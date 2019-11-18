# Simple client for Mailchimp
[![Build Status](https://travis-ci.org/alexgoncharcherkassy/mailchimpbundle.svg?branch=master)](https://travis-ci.org/alexgoncharcherkassy/mailchimpbundle)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/alexgoncharcherkassy/mailchimpbundle/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/alexgoncharcherkassy/mailchimpbundle/?branch=master)

### Composer

    php composer.phar require alexgoncharcherkassy/mailchimpbundle
    

### AppKernel

        public function registerBundles()
            {
                $bundles = array(
                    ...
                    new AlexCk\MailchimpBundle\AlexCkMailchimpBundle()
   
   
### Usage

    1. Getting service
    
        $mailchimp = $this->get('alexck_mailchimp.client');
        $mailchimp->configure('username', 'key', '3.0');
    
    2. Get mailchimp lists and webhooks
    
        $lists = $mailchimp->getLists();
    
    3. Create mailchimp list
        
        $contact = new ListItemContact();
        $contact
            ->setAddress1('adr1')
            ...
            ;
                   
        $campaign = new ListItemCampaignDefaults();
        $campaign
            ->setFromName('fromName')
            ...
            ;
        $item = new ListItem();
        $item
            ->setId('id1')
            ...
            ->setContact($contact)
            ->setCampaignDefaults($campaign);
            
        $list = $mailchimp->createList($item);
        
    4. Create mailchimp member
        
        $member = new Member();
        $member
            ->setId('id1')
            ...
            ;
        
        $member = $mailchimp->createMember($member, 'listId');
        
    5. Update mailchimp member
    
        $mergedFields = new MemberMergeFields();
        $mergedFields
            ->setFName('fName')
            ->setLName('lName');
        
        $member = new Member();
        $member
            ->setId('id1')
            ...
            ->setMergeFields($mergedFields);
        
        $member = $mailchimp->updateMember($member, 'listId', 'old_email@email.com');
        
    6. Delete mailchimp member
    
        $member = new Member();
        $member
            ->setId('id1')
            ...
            ;
            
        $member = $mailchimp->deleteMember($member, 'listId');

    7.  Create mailchimp webhooks unsubscribe
    
        $webhook = $mailchimp->createWebHookEventUnsubscribe('listId', 'email_member@email.com');
        
    8. Create batch member
    
        $member = new Member();
            $member
            ->setId('id1')
            ...
            ;
    
        $batchResp = $mailchimp->createBatchMember('', [$member]);
    
          