# Sendbee PHP API Client  

```

                .' '.            __
       .        .   .           (__\_
        .         .         . -{{_(|8)
          ' .  . ' ' .  . '     (__/

```  

## Table of contents  

-   [Installation](#installation)  
-   [Initialization](#initialization)    

#### Contacts  

-   [Fetch contacts](#fetch-contacts)  
-   [Subscribe contact](#subscribe-contact)  
-   [Update contact](#update-contact)  

#### Contact Tags  

-   [Fetch tags](#fetch-tags)  
-   [Create tag](#create-tag)  
-   [Update tag](#update-tag)  
-   [Delete tag](#delete-tag)  

#### Contact Fields  

-   [Fetch contact fields](#fetch-contact-fields)  
-   [Create contact field](#create-contact-field)  
-   [Update contact field](#update-contact-field)  
-   [Delete contact field](#delete-contact-field)  

#### Messages  

-   [Fetch message templates](#fetch-message-templates)  
-   [Send template message](#send-template-message)  
-   [Send message](#send-message)  

#### Automation  

-   [Toggle bot for conversation with contact on off](#Toggle-bot-for-conversation-with-contact-on-off)  

#### Mics  

-   [Exception handling](#exception-handling)  
-   [Authenticate webhook request](#authenticate-webhook-request)  
-   [Warnings](#warnings)  
-   [Debugging](#debugging)  
-   [Official Documentation](http://developer.sendbee.io)  

## <a href='installation'>Installation</a>  

The recommended way to install Sendbee API is with [Composer](https://getcomposer.org/).

#### 1. Install Composer
```bash
curl -sS https://getcomposer.org/installer | php
```

#### 2. Install Sendbee API using Composer

##### 2.a Using Composer CLI
You can add Sendbee API as a dependency using the composer.phar CLI:

```bash
php composer.phar require sendbee/api
```

##### 2.b Using global composer CLI
If Composer is available globally on your system, you can run the following from your project root.

```bash
composer require sendbee/api
```

##### 2.c Modifying existing composer.json
If you have an existing project that uses Composer and has `composer.json` file, 
you can specify `sendbee/api` as a dependency.
```json
 {
   "require": {
      "sendbee/api": "~1.0"
   }
}
```

After adding a dependency you should tell composer to update dependencies
```bash
composer update
```

## Usage  

### <a href='initialization'>Autoload</a>  
After installing, you need to require Composer's autoloader:
```php
require 'vendor/autoload.php';
```

You can find out more on how to install Composer, configure autoloading, and other best-practices for defining dependencies at [Composer](https://getcomposer.org/).


### <a href='initialization'>Initialization</a>  

To initialize the API client, you'll need a public key and secret. That data is available in your Sendbee dashboard.

```php
$sendbeeApi = new \Sendbee\Api\Client($public_key, $secret);
```

### <a href='fetch-contacts'>Fetch contacts</a>  

```php
$sendbeeApi = new \Sendbee\Api\Client($public_key, $secret);

# optional parameters
$params = [
    'tags' => '', // Filter contacts by tag
    'status' => '', // Filter contacts by status
    'search_query' => '', // Filter contacts by query string
    'page' => 1 // Page number for pagination
];

try
{
    $response = $sendbeeApi->getContacts($params);
}
catch(\Exception $ex)
{
    // handle exception thrown by GuzzleHttp
    // this is most likely due to a network issue
    echo "Could not contact backend endpoint. ", $ex->getMessage();
}

if($response->isSuccess())
{
    $data = $response->getData();

    foreach($data as $contact)
    {
        /**
         * @var $contact \Sendbee\Api\Models\Contact
         */
        echo "\n ID: ", $contact->id;
        echo "\n name: ", $contact->name;
        echo "\n phone: ", $contact->phone;
        echo "\n email: ", $contact->email;
        echo "\n created_at: ", $contact->created_at;
        echo "\n status: ", $contact->status;
        echo "\n folder: ", $contact->folder;
        echo "\n facebook_link: ", $contact->facebook_link;
        echo "\n twitter_link: ", $contact->twitter_link;

        foreach($contact->tags as $tag)
        {
            /**
             * @var $tag \Sendbee\Api\Models\ContactTag
             */

            echo "\n tag -> id: ", $tag->id;
            echo "\n tag -> name: ", $tag->name;
        }

        foreach($contact->notes as $note)
        {
            /**
             * @var $note \Sendbee\Api\Models\ContactNote
             */

            echo "\n note -> value: ", $note->value;
        }

        foreach($contact->contact_fields as $contactField)
        {
            /**
             * @var $contactField \Sendbee\Api\Models\ContactContactField
             */

            echo "\n contact_field -> key: ", $contactField->key;
            echo "\n contact_field -> value: ", $contactField->value;
        }


    }
}
else
{
    /**
     * @var $error \Sendbee\Api\Transport\ResponseError
     */
    $error = $response->getError();

    if($error)
    {
        echo $error->type;
        echo $error->detail;
    }
}
```

### <a href='subscribe-contact'>Subscribe contact</a>  

```php
$sendbeeApi = new \Sendbee\Api\Client($public_key, $secret);

$contactData = [
    // contact phone number, MANDATORY
    'phone' => '+...',

    // feel free to specify other contact data here
    // data listed below is optional

    // tag new contact
    // if tag doesn't exist, it will be created
    'tags' => ['...', ],

    // contact name
    'name' => '...',

    // contact email
    'email' => '...',

    // contact address
    // specify line, city and postal_code
    'address' => ['line' => '...', 'city' => '...', 'postal_code' => '...'],

    // contact fields
    // contact fields must be pre-created in Sendbee Dashboard
    // any non-existent field will be ignored
    'contact_fields' => ['...' => '...'],

    // contact facebook link
    'facebook_link' => '...',

    // contact twitter link
    'twitter_link' => '...',

    // your notes about subscriber
    'notes' => ['...'],

    // prevent sending browser push notification and email
    // notification to agents, when new contact subscribes
    // (default is True)
    'block_notifications' => true,

    // prevent sending automated template messages to newly
    // subscribed contact (if any is set in Sendbee Dashboard)
    // (default is True)
    'block_automation' => true
];

try
{
    $response = $sendbeeApi->subscribeContact($contactData);
}
catch(\Sendbee\Api\Support\DataException $ex)
{
    // handle missing data
    // this happens when required data was not provided
    echo "Could not subscribe a contact. ", $ex->getMessage();
}
catch(\Exception $ex)
{
    // handle exception thrown by GuzzleHttp
    // this is most likely due to a network issue
    echo "Could not contact backend endpoint. ", $ex->getMessage();
}

if($response->isSuccess())
{
    /**
     * @var $contact \Sendbee\Api\Models\Contact
     */
    $contact = $response->getData();

    // contact is now subscribed (created),
    // handle success here
}
else
{
    /**
     * @var $error \Sendbee\Api\Transport\ResponseError
     */
    $error = $response->getError();
    if($error)
    {
        // handle error
        echo "\n error type: ", $error->type;
        echo "\n error details: ", $error->detail;
    }
}
```

### <a href='update-contact'>Update contact</a>  

```php
## update an existing contact

$contactData = [
    // contact id, MANDATORY
    'id' => '...',

    // feel free to specify other contact data here
    // data listed below is optional

    // tag new contact
    // if tag doesn't exist, it will be created
    'tags' => ['...', ],

    // contact name
    'name' => '...',

    // contact email
    'email' => '...',

    // contact address
    // specify line, city and postal_code
    'address' => ['line' => '...', 'city' => '...', 'postal_code' => '...'],

    // contact fields
    // contact fields must be pre-created in Sendbee Dashboard
    // any non-existent field will be ignored
    'contact_fields' => ['...' => '...'],

    // contact facebook link
    'facebook_link' => '...',

    // contact twitter link
    'twitter_link' => '...',

    // your notes about subscriber
    'notes' => ['...'],

    // prevent sending browser push notification and email
    // notification to agents, when new contact subscribes
    // (default is True)
    'block_notifications' => true,

    // prevent sending automated template messages to newly
    // subscribed contact (if any is set in Sendbee Dashboard)
    // (default is True)
    'block_automation' => true
];

try
{
    $response = $sendbeeApi->updateContact($contactData);
}
catch(\Sendbee\Api\Support\DataException $ex)
{
    // handle missing data
    // this happens when required data was not provided
    echo "Could not update a contact. ", $ex->getMessage();
}
catch(\Exception $ex)
{
    // handle exception thrown by GuzzleHttp
    // this is most likely due to a network issue
    echo "Could not contact backend endpoint. ", $ex->getMessage();
}

if($response->isSuccess())
{
    /**
     * @var $contact \Sendbee\Api\Models\Contact
     */
    $contact = $response->getData();

    // contact is now updated,
    // handle success here
}
else
{
    /**
     * @var $error \Sendbee\Api\Transport\ResponseError
     */
    $error = $response->getError();
    if($error)
    {
        // handle error
        echo "\n error type: ", $error->type;
        echo "\n error details: ", $error->detail;
    }
}

```

### <a href='fetch-tags'>Fetch tags</a>  

```php

```

### <a href='create-tag'>Create tag</a>  

```php

```

### <a href='update-tag'>Update tag</a>  

```php

```

### <a href='update-tag'>Update tag</a>  

```php

```

### <a href='fetch-contact-fields'>Fetch contact fields</a>  

```php

```

### <a href='create-contact-field'>Create contact field</a>  

```php

```

### <a href='update-contact-field'>Update contact field</a>  

```php

```

### <a href='delete-contact-field'>Delete contact field</a>  

```php

```

### <a href='fetch-message-templates'>Fetch message templates</a>  

```php

```

### <a href='send-template-message'>Send template message</a>  

```php

```

### <a href='send-message'>Send message</a>  

You can send either text message or media message.  
For media message, following formats are supported:  
Audio: AAC, M4A, AMR, MP3, OGG OPUS  
video: MP4, 3GPP  
Image: JPG/JPEG, PNG  
Documents: PDF, DOC, DOCX, PPT, PPTX, XLS, XLSX  

```php

```

### <a href='toggle-bot-for-conversation-with-contact-on-off'>Toggle bot for conversation with contact on off</a>  

Every contact is linked with conversation with an agent.  
Conversation could be handled by an agent or a bot (automation).  
Every time a message has been sent to a contact by an agent or using the API, the bot is automatically turned off for that conversation.  
But there is always a use case when you need to turn it on or off manually.  

```php

```

### <a href='exception-handling'>Exception handling</a>  

Every time something is not as it should be, like parameter is missing, parameter value is invalid, authentication fails, etc, API returns a http status code accordingly and an error message.  
By using this client library, an error message is detected and taken, and an exception is raised, so you can handle it like this:  

```php

```    

### <a href='authenticate-webhook-request'>Authenticate webhook request</a>  

After activating your webhook URL in Sendbee Dashboard, we will start sending requests on that URL depending on which webhook type is linked with that webhook URL.  
Every request that we make will have authorization token in header, like this:  

```
{
    ...
    'X-Authorization': '__auth_token_here__',
    ...
}
```

To authenticate requests that we make to your webhook URL, take this token from request header and check it using Sendbee API Client:  

```php

```  

### <a href='warnings'>Warnings</a>  

Sometimes APi returns a worning so you could be warned about something.  
The waning is displayed in standard output:  

![Debugging](docs/images/warning.png)  

### <a href='debugging'>Debugging</a>  

This library has it's own internal debugging tool.  
By default it is disabled, and to enable it, pass the `debug` parameter:  

```php

```  

Once you enabled the internal debug tool, every request to API will output various request and response data in standard output:  

![Debugging](docs/images/debugging.png)   
