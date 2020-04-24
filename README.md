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

#### Conversations

-   [Fetch conversations](#fetch-conversations)  
-   [Fetch messages](#fetch-messages)  

#### Messages  

-   [Fetch message templates](#fetch-message-templates)  
-   [Send template message](#send-template-message)  
-   [Send message](#send-message)  

#### Automation  

-   [Toggle bot for conversation with contact on off](#Toggle-bot-for-conversation-with-contact-on-off)  

#### Mics  

-   [Pagination](#pagination)  
-   [Exception handling](#exception-handling)  
-   [Authenticate webhook request](#authenticate-webhook-request)  
-   [Official Documentation](http://developer.sendbee.io)  

## <a href='installation'>Installation</a>  

The recommended way to install Sendbee API is with [Composer](https://getcomposer.org/).

### 1. Install Composer
```bash
curl -sS https://getcomposer.org/installer | php
```

### 2. Install Sendbee API using Composer

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

## Contacts

### <a href='fetch-contacts'>Fetch contacts</a>  

```php
// optional parameters
$params = [
    'tags' => '', // Filter contacts by tag
    'status' => '', // Filter contacts by status
    'search_query' => '', // Filter contacts by query string
    'page' => 1 // Page number for pagination
];

try {
    $response = $sendbeeApi->getContacts($params);
} catch (\Exception $ex) {
    // handle exception thrown by GuzzleHttp
    // this is most likely due to a network issue
    echo "Could not contact backend endpoint. ", $ex->getMessage();
}

if ($response->isSuccess()) {
    // everything is OK

    $data = $response->getData();

    foreach ($data as $contact) {
        /**
         * @var $contact \Sendbee\Api\Models\Contact
         */
        echo "\n ID: ", $contact->id;
        echo "\n name: ", $contact->name;
        echo "\n phone: ", $contact->phone;
        echo "\n created_at: ", $contact->created_at;
        echo "\n status: ", $contact->status;
        echo "\n folder: ", $contact->folder;

        foreach ($contact->tags as $tag) {
            /**
             * @var $tag \Sendbee\Api\Models\ContactTag
             */

            echo "\n tag -> id: ", $tag->id;
            echo "\n tag -> name: ", $tag->name;
        }

        foreach ($contact->notes as $note) {
            /**
             * @var $note \Sendbee\Api\Models\ContactNote
             */

            echo "\n note -> value: ", $note->value;
        }

        foreach ($contact->contact_fields as $contactField) {
            /**
             * @var $contactField \Sendbee\Api\Models\ContactContactField
             */

            echo "\n contact_field -> key: ", $contactField->key;
            echo "\n contact_field -> value: ", $contactField->value;
        }
    }
} else {
    /**
     * @var $error \Sendbee\Api\Transport\ResponseError
     */
    $error = $response->getError();
    if ($error) {
        echo "\n error type: ", $error->type;
        echo "\n error details: ", $error->detail;
    }
}
```

### <a href='subscribe-contact'>Subscribe contact</a>  

```php
$contactData = [
    // contact phone number, MANDATORY
    'phone' => '+...',

    // feel free to specify other optional contact data here

    // tag new contact
    // if tag doesn't exist, it will be created
    'tags' => ['...',],

    // contact name
    'name' => '...',

    // contact fields
    // contact fields must be pre-created in Sendbee Dashboard
    // any non-existent field will be ignored
    'contact_fields' => ['key' => 'value'],

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

try {
    $response = $sendbeeApi->subscribeContact($contactData);
} catch (\Sendbee\Api\Support\DataException $ex) {
    // handle missing data
    // this happens when required data was not provided
    echo "Could not subscribe a contact. ", $ex->getMessage();
} catch (\Exception $ex) {
    // handle exception thrown by GuzzleHttp
    // this is most likely due to a network issue
    echo "Could not contact backend endpoint. ", $ex->getMessage();
}

if ($response->isSuccess()) {
    /**
     * @var $contact \Sendbee\Api\Models\Contact
     */
    $contact = $response->getData();

    // contact is now subscribed (created)
    // $contact contains the newly created contact data
} else {
    /**
     * @var $error \Sendbee\Api\Transport\ResponseError
     */
    $error = $response->getError();
    if ($error) {
        // handle error
        echo "\n error type: ", $error->type;
        echo "\n error details: ", $error->detail;
    }
}
```

### <a href='update-contact'>Update contact</a>  

```php
$contactData = [
    // contact id, MANDATORY
    'id' => '...',

    // feel free to specify other optional contact data here

    // tag new contact
    // if tag doesn't exist, it will be created
    'tags' => ['...',],

    // contact name
    'name' => '...',

    // contact fields
    // contact fields must be pre-created in Sendbee Dashboard
    // any non-existent field will be ignored
    'contact_fields' => ['...' => '...'],

    // your notes about subscriber
    // TAKE CARE, notes are not replaced but are instead appended to existing notes
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

try {
    $response = $sendbeeApi->updateContact($contactData);
} catch (\Sendbee\Api\Support\DataException $ex) {
    // handle missing data
    // this happens when required data was not provided
    echo "Could not update a contact. ", $ex->getMessage();
} catch (\Exception $ex) {
    // handle exception thrown by GuzzleHttp
    // this is most likely due to a network issue
    echo "Could not contact backend endpoint. ", $ex->getMessage();
}

if ($response->isSuccess()) {
    /**
     * @var $contact \Sendbee\Api\Models\Contact
     */
    $contact = $response->getData();

    // contact is now updated
    // $contact contains the updated contact data

} else {
    /**
     * @var $error \Sendbee\Api\Transport\ResponseError
     */
    $error = $response->getError();
    if ($error) {
        // handle error
        echo "\n error type: ", $error->type;
        echo "\n error details: ", $error->detail;
    }
}
```

## Contact tags

### <a href='fetch-tags'>Fetch tags</a>  

```php
// optional parameters
$params = [
    'name' => '', // Name of the tag
    'page' => 1 // Page number for pagination
];

try {
    $response = $sendbeeApi->getTags($params);
} catch (\Exception $ex) {
    // handle exception thrown by GuzzleHttp
    // this is most likely due to a network issue
    echo "Could not contact backend endpoint. ", $ex->getMessage();
}

if ($response->isSuccess()) {
    // everything is OK

    $data = $response->getData();

    foreach ($data as $tag) {
        /**
         * @var $tag \Sendbee\Api\Models\ContactTag
         */
        echo "\n ID: ", $tag->id;
        echo "\n name: ", $tag->name;
    }
} else {
    /**
     * @var $error \Sendbee\Api\Transport\ResponseError
     */
    $error = $response->getError();
    if ($error) {
        echo "\n error type: ", $error->type;
        echo "\n error details: ", $error->detail;
    }
}
```

### <a href='create-tag'>Create tag</a>  

```php
$data = [
    // tag name, MANDATORY
    'name' => '...'
];

try {
    $response = $sendbeeApi->createTag($data);
} catch (\Sendbee\Api\Support\DataException $ex) {
    // handle missing data
    // this happens when required data was not provided
    echo "Missing required data. ", $ex->getMessage();
} catch (\Exception $ex) {
    // handle exception thrown by GuzzleHttp
    // this is most likely due to a network issue
    echo "Could not contact backend endpoint. ", $ex->getMessage();
}

if ($response->isSuccess()) {
    /**
     * @var $tag \Sendbee\Api\Models\ContactTag
     */
    $tag = $response->getData();
    print_r($tag);
    // tag is now created
    // $tag contains the newly created tag data
} else {
    /**
     * @var $error \Sendbee\Api\Transport\ResponseError
     */
    $error = $response->getError();
    if ($error) {
        // handle error
        echo "\n error type: ", $error->type;
        echo "\n error details: ", $error->detail;
    }
}
```

### <a href='update-tag'>Update tag</a>  

```php
$data = [
    // tag id, MANDATORY
    'id' => '...',
    // tag name, MANDATORY
    'name' => '...'
];

try {
    $response = $sendbeeApi->updateTag($data);
} catch (\Sendbee\Api\Support\DataException $ex) {
    // handle missing data
    // this happens when required data was not provided
    echo "Missing required data. ", $ex->getMessage();
} catch (\Exception $ex) {
    // handle exception thrown by GuzzleHttp
    // this is most likely due to a network issue
    echo "Could not contact backend endpoint. ", $ex->getMessage();
}

if ($response->isSuccess()) {
    /**
     * @var $tag \Sendbee\Api\Models\ContactTag
     */
    $tag = $response->getData();
    // tag is now updated
    // $tag contains the updated tag data
    print_r($tag);
    
} else {
    /**
     * @var $error \Sendbee\Api\Transport\ResponseError
     */
    $error = $response->getError();
    if ($error) {
        // handle error
        echo "\n error type: ", $error->type;
        echo "\n error details: ", $error->detail;
    }
}
```

### <a href='delete-tag'>Delete tag</a>  

```php
$data = [
    // tag id, MANDATORY
    'id' => '...',
];

try {
    $response = $sendbeeApi->deleteTag($data);
} catch (\Sendbee\Api\Support\DataException $ex) {
    // handle missing data
    // this happens when required data was not provided
    echo "Missing required data. ", $ex->getMessage();
} catch (\Exception $ex) {
    // handle exception thrown by GuzzleHttp
    // this is most likely due to a network issue
    echo "Could not contact backend endpoint. ", $ex->getMessage();
}

if ($response->isSuccess()) {
    /**
     * @var $message \Sendbee\Api\Models\ServerMessage
     */
    $message = $response->getData();
    // record is now deleted
    // $message contains server info message
    print_r($message);
    
} else {
    /**
     * @var $error \Sendbee\Api\Transport\ResponseError
     */
    $error = $response->getError();
    if ($error) {
        // handle error
        echo "\n error type: ", $error->type;
        echo "\n error details: ", $error->detail;
    }
}
```

## Contact fields

### <a href='fetch-contact-fields'>Fetch contact fields</a>  

```php
$params = [
    'search_query' => '', // Filter by query string
    'page' => 1 // Page number for pagination
];

try {
    $response = $sendbeeApi->getContactFields($params);
} catch (\Exception $ex) {
    // handle exception thrown by GuzzleHttp
    // this is most likely due to a network issue
    echo "Could not contact backend endpoint. ", $ex->getMessage();
}

if ($response->isSuccess()) {
    // everything is OK

    $data = $response->getData();

    foreach ($data as $field) {
        /**
         * @var $tag \Sendbee\Api\Models\ContactField
         */
        echo "\n ID: ", $field->id;
        echo "\n type: ", $field->type;
        echo "\n name: ", $field->name;

        foreach ($field->options as $option) {
            /**
             * @var $option string
             */

            echo "\n field -> option: ", $option;
        }

    }
} else {
    /**
     * @var $error \Sendbee\Api\Transport\ResponseError
     */
    $error = $response->getError();
    if ($error) {
        echo "\n error type: ", $error->type;
        echo "\n error details: ", $error->detail;
    }
}
```

### <a href='create-contact-field'>Create contact field</a>  

```php
$data = [
    // name, MANDATORY
    'name' => 'field name',
    // type, one of ['text', 'number', 'list', 'date', 'boolean'], MANDATORY
    'type' => 'text',
    // List of options. Send it only if the field type is a list.
    // values are strings
    'options' => []
];

try {
    $response = $sendbeeApi->createContactField($data);
} catch (\Sendbee\Api\Support\DataException $ex) {
    // handle missing data
    // this happens when required data was not provided
    echo "Missing required data. ", $ex->getMessage();
} catch (\Exception $ex) {
    // handle exception thrown by GuzzleHttp
    // this is most likely due to a network issue
    echo "Could not contact backend endpoint. ", $ex->getMessage();
}

if ($response->isSuccess()) {
    /**
     * @var $contactField \Sendbee\Api\Models\ContactField
     */
    $contactField = $response->getData();
    // contact field is now created
    // $contactField contains the newly created contact field data
    print_r($contactField);
} else {
    /**
     * @var $error \Sendbee\Api\Transport\ResponseError
     */
    $error = $response->getError();
    if ($error) {
        // handle error
        echo "\n error type: ", $error->type;
        echo "\n error details: ", $error->detail;
    }
}
```

### <a href='update-contact-field'>Update contact field</a>  

```php
$data = [
    // id, MANDATORY
    'id' => '...',
    // name, MANDATORY
    'name' => 'field name update',
    // type, one of ['text', 'number', 'list', 'date', 'boolean'], MANDATORY
    'type' => 'text',
    // List of options. Send it only if the field type is a list.
    // values are strings
    'options' => []
];

try {
    $response = $sendbeeApi->updateContactField($data);
} catch (\Sendbee\Api\Support\DataException $ex) {
    // handle missing data
    // this happens when required data was not provided
    echo "Missing required data. ", $ex->getMessage();
} catch (\Exception $ex) {
    // handle exception thrown by GuzzleHttp
    // this is most likely due to a network issue
    echo "Could not contact backend endpoint. ", $ex->getMessage();
}

if ($response->isSuccess()) {
    /**
     * @var $contactField \Sendbee\Api\Models\ContactField
     */
    $contactField = $response->getData();
    // contact field is now updated
    // $contactField contains the updated contact field data
    print_r($contactField);

} else {
    /**
     * @var $error \Sendbee\Api\Transport\ResponseError
     */
    $error = $response->getError();
    if ($error) {
        // handle error
        echo "\n error type: ", $error->type;
        echo "\n error details: ", $error->detail;
    }
}
```

### <a href='delete-contact-field'>Delete contact field</a>  

```php
$data = [
    // id, MANDATORY
    'id' => '...',
];

try {
    $response = $sendbeeApi->deleteContactField($data);
} catch (\Sendbee\Api\Support\DataException $ex) {
    // handle missing data
    // this happens when required data was not provided
    echo "Missing required data. ", $ex->getMessage();
} catch (\Exception $ex) {
    // handle exception thrown by GuzzleHttp
    // this is most likely due to a network issue
    echo "Could not contact backend endpoint. ", $ex->getMessage();
}

if ($response->isSuccess()) {
    /**
     * @var $message \Sendbee\Api\Models\ServerMessage
     */
    $message = $response->getData();
    // record is now deleted
    // $message contains server info message
    print_r($message);
    
} else {
    /**
     * @var $error \Sendbee\Api\Transport\ResponseError
     */
    $error = $response->getError();
    if ($error) {
        // handle error
        echo "\n error type: ", $error->type;
        echo "\n error details: ", $error->detail;
    }
}
```

## Conversations and messages

### <a href='fetch-conversations'>Fetch conversations</a>  

```php
// optional parameters
$params = [
    // Filter conversations by folder. Specify open, done, spam or notified
    'folder' => '',
    // Any kind of string that will be used to perform filtering
    'search_query' => '',
    // Page number for pagination
    'page' => 1
];

try {
    $response = $sendbeeApi->getConversations($params);
} catch (\Exception $ex) {
    // handle exception thrown by GuzzleHttp
    // this is most likely due to a network issue
    echo "Could not contact backend endpoint. ", $ex->getMessage();
}


if ($response->isSuccess()) {
    // everything is OK
    $data = $response->getData();

    foreach ($data as $conversation) {
        /**
         * @var $conversation \Sendbee\Api\Models\Conversation
         */
        echo "\n ID: ", $conversation->id;
        echo "\n folder: ", $conversation->folder;
        echo "\n chatbot_active: ", $conversation->chatbot_active;
        echo "\n platform: ", $conversation->platform;
        echo "\n created_at: ", $conversation->created_at;

        echo "\n contact -> id: ", $conversation->contact->id;
        echo "\n contact -> name: ", $conversation->contact->name;
        echo "\n contact -> phone: ", $conversation->contact->phone;

        echo "\n last_message -> direction: ", $conversation->last_message->direction;
        echo "\n last_message -> status: ", $conversation->last_message->status;
        echo "\n last_message -> inbound_sent_at: ", $conversation->last_message->inbound_sent_at;
        echo "\n last_message -> outbound_sent_at: ", $conversation->last_message->outbound_sent_at;

    }
} else {
    /**
     * @var $error \Sendbee\Api\Transport\ResponseError
     */
    $error = $response->getError();
    if ($error) {
        echo "\n error type: ", $error->type;
        echo "\n error details: ", $error->detail;
    }
}
```

### <a href='fetch-messages'>Fetch messages in a conversation</a>  

```php
// parameters
$params = [
    // Conversation UUID, MANDATORY
    'conversation_id' => '...',
    // Page number for pagination
    'page' => 1
];

try {
    $response = $sendbeeApi->getMessages($params);
} catch (\Sendbee\Api\Support\DataException $ex) {
    // handle missing data
    // this happens when required data was not provided
    echo "Missing required data. ", $ex->getMessage();
} catch (\Exception $ex) {
    // handle exception thrown by GuzzleHttp
    // this is most likely due to a network issue
    echo "Could not contact backend endpoint. ", $ex->getMessage();
}


if ($response->isSuccess()) {
    // everything is OK
    $data = $response->getData();

    foreach ($data as $message) {
        /**
         * @var $message \Sendbee\Api\Models\Message
         */
        echo "\n sid: ", $message->sid;
        echo "\n type: ", $message->type;
        echo "\n body: ", $message->body;
        echo "\n media_type: ", $message->media_type;
        echo "\n media_url: ", $message->media_url;
        echo "\n status: ", $message->status;
        echo "\n direction: ", $message->direction;
        echo "\n sent_at: ", $message->sent_at;

    }
} else {
    /**
     * @var $error \Sendbee\Api\Transport\ResponseError
     */
    $error = $response->getError();
    if ($error) {
        echo "\n error type: ", $error->type;
        echo "\n error details: ", $error->detail;
    }
}
```

## Sending messages

### <a href='fetch-message-templates'>Fetch message templates</a>  

```php
// optional parameters
$params = [
    'approved' => true | false, // Fetch approved or unapproved templates
    'search_query' => '', // Filter by query string
    'page' => 1 // Page number for pagination
];

try {
    $response = $sendbeeApi->getMessageTemplates($params);
} catch (\Exception $ex) {
    // handle exception thrown by GuzzleHttp
    // this is most likely due to a network issue
    echo "Could not contact backend endpoint. ", $ex->getMessage();
}

if ($response->isSuccess()) {
    // everything is OK

    $data = $response->getData();

    foreach ($data as $messageTemplate) {
        /**
         * @var $messageTemplate \Sendbee\Api\Models\MessageTemplate
         */
        echo "\n ID: ", $messageTemplate->id;
        echo "\n approved: ", $messageTemplate->approved;
        echo "\n keyword: ", $messageTemplate->keyword;
        echo "\n text: ", $messageTemplate->text;
        echo "\n language: ", $messageTemplate->language;

        foreach ($messageTemplate->tags as $tag) {
            /**
             * @var $tag \Sendbee\Api\Models\MessageTemplateTag
             */
            echo "\n tag -> name: ", $tag->name;
        }
    }
} else {
    /**
     * @var $error \Sendbee\Api\Transport\ResponseError
     */
    $error = $response->getError();
    if ($error) {
        echo "\n error type: ", $error->type;
        echo "\n error details: ", $error->detail;
    }
}
```

### <a href='send-template-message'>Send template message</a>  

```php
$data = [
    // phone number to send the message to, MANDATORY
    'phone' => '+...',
    
    // keyword of an existing template message you are using, MANDATORY
    'template_keyword' => '...',
    
    // language code of an existing template message you are using, MANDATORY
    'language' => 'en',
    
    // tags, key-value pairs of data that is injected in placeholders, MANDATORY
    // example:
    //   template message is 'Your order {{order}} has been dispatched. Please expect delivery by {{date}}'
    //   tags are ['order' => 55, 'date' => '2020-12-12']
    //   final message will be 'Your order 55 has been dispatched. Please expect delivery by 2020-12-12'
    'tags' => [],
    
    // Set to true to disable turning-off chatbot
    'prevent_bot_off' => true,
];

try {
    $response = $sendbeeApi->sendMessageTemplate($data);
} catch (\Sendbee\Api\Support\DataException $ex) {
    // handle missing data
    // this happens when required data was not provided
    echo "Missing required data. ", $ex->getMessage();
} catch (\Exception $ex) {
    // handle exception thrown by GuzzleHttp
    // this is most likely due to a network issue
    echo "Could not contact backend endpoint. ", $ex->getMessage();
}

if ($response->isSuccess()) {
    /**
     * @var $messageInfo \Sendbee\Api\Models\SentMessage
     */
    $messageInfo = $response->getData();
    // $messageInfo contains message information
    print_r($messageInfo);
} else {
    /**
     * @var $error \Sendbee\Api\Transport\ResponseError
     */
    $error = $response->getError();
    if ($error) {
        // handle error
        echo "\n error type: ", $error->type;
        echo "\n error details: ", $error->detail;
    }
}
```

### <a href='send-message'>Send message</a>  

You can send either text message or media message.  
For media message, following formats are supported:  
Audio: AAC, M4A, AMR, MP3, OGG OPUS  
video: MP4, 3GPP  
Image: JPG/JPEG, PNG  
Documents: PDF, DOC, DOCX, PPT, PPTX, XLS, XLSX  

```php
$data = [
    // phone number to send the message to, MANDATORY
    'phone' => '+...',
    // message text, MANDATORY
    'text' => '...',
    // Media URL for media message
    'media_url' => '',
    // Set to true to disable turning-off chatbot
    'prevent_bot_off' => true,
];

try {
    $response = $sendbeeApi->sendMessage($data);
} catch (\Sendbee\Api\Support\DataException $ex) {
    // handle missing data
    // this happens when required data was not provided
    echo "Missing required data. ", $ex->getMessage();
} catch (\Exception $ex) {
    // handle exception thrown by GuzzleHttp
    // this is most likely due to a network issue
    echo "Could not contact backend endpoint. ", $ex->getMessage();
}

if ($response->isSuccess()) {
    /**
     * @var $messageInfo \Sendbee\Api\Models\SentMessage
     */
    $messageInfo = $response->getData();
    // $messageInfo contains message information
    print_r($messageInfo);
} else {
    /**
     * @var $error \Sendbee\Api\Transport\ResponseError
     */
    $error = $response->getError();
    if ($error) {
        // handle error
        echo "\n error type: ", $error->type;
        echo "\n error details: ", $error->detail;
    }
}
```

## Automation

### <a href='toggle-bot-for-conversation-with-contact-on-off'>Toggle bot for conversation with contact on off</a>  

Every contact is linked with conversation with an agent.  
Conversation could be handled by an agent or a bot (automation).  
Every time a message has been sent to a contact by an agent or using the API, 
the bot is automatically turned off for that conversation - except when you set 
'prevent_bot_off' to true via API call (see [Send message](#send-message)).

Use the example below to change the chatbot status based on your use case.

```php
$data = [
    // conversation_id, MANDATORY
    'conversation_id' => '...',
    // boolean value, true to enable chatbot, false to disable, MANDATORY
    'active' => true | false
];

try {
    $response = $sendbeeApi->chatbotActivity($data);
} catch (\Sendbee\Api\Support\DataException $ex) {
    // handle missing data
    // this happens when required data was not provided
    echo "Missing required data. ", $ex->getMessage();
} catch (\Exception $ex) {
    // handle exception thrown by GuzzleHttp
    // this is most likely due to a network issue
    echo "Could not contact backend endpoint. ", $ex->getMessage();
}

if ($response->isSuccess()) {
    /**
     * @var $tag \Sendbee\Api\Models\ServerMessage
     */
    $message = $response->getData();
    // chatbot activity is now set
    // $message contains server info message
    print_r($message);

} else {
    /**
     * @var $error \Sendbee\Api\Transport\ResponseError
     */
    $error = $response->getError();
    if ($error) {
        // handle error
        echo "\n error type: ", $error->type;
        echo "\n error details: ", $error->detail;
    }
}
```

### <a href='#bot-status'>Get chatbot (automated responses) status</a>
You can also check if chatbot is turned on or off for a conversation.    

```php

$data = [
    // conversation_id, MANDATORY
    'conversation_id' => '...'
];

try {
    $response = $sendbeeApi->getChatbotActivity($data);
} catch (\Sendbee\Api\Support\DataException $ex) {
    // handle missing data
    // this happens when required data was not provided
    echo "Missing required data. ", $ex->getMessage();
} catch (\Exception $ex) {
    // handle exception thrown by GuzzleHttp
    // this is most likely due to a network issue
    echo "Could not contact backend endpoint. ", $ex->getMessage();
}

if ($response->isSuccess()) {
    /**
     * @var $status \Sendbee\Api\Models\ChatbotStatus
     */
    $status = $response->getData();
    
    echo "\n conversation_id: ", $status->text;
    echo "\n chatbot_active: ", $status->chatbot_active ? 'ON' : 'OFF';

} else {
    /**
     * @var $error \Sendbee\Api\Transport\ResponseError
     */
    $error = $response->getError();
    if ($error) {
        // handle error
        echo "\n error type: ", $error->type;
        echo "\n error details: ", $error->detail;
    }
}

```

## Misc

### <a href='pagination'>Response</a>

All API methods return a `Sendbee\Api\Transport\Response` object.
Only exception is when some required parameter is missing or there are network issues - in that case an exception is thrown.

The response object wraps the raw server response into corresponding objects and exposes methods to inspect received data.


```php
/**
 * @var $response \Sendbee\Api\Transport\Response
 */
$response = $sendbeeApi->getContacts();

// check if request was successful
$success = $response->isSuccess();

// get HTTP status code the server returned
$statusCode = $response->getHttpStatus();

// get data wrapped into appropriate object(s)
$data = $response->getData();

// get pagination data (when available)
$pagination = $response->getMeta();

// get error if API call failed
$error = $response->getError();

// get a warning message sent by API (when available)
$warning = $response->getWarning();

// if you prefer to deal with the raw server response, that is available as well
$rawResponseString = $response->getRawBody();
```


### <a href='pagination'>Pagination</a>

Pagination is available on all client methods that accept a `page` parameter. Those methods are:

- getContacts()
- getTags()
- getContactFields()
- getConversations()
- getMessages()
- getMessageTemplates()

To get the first page of results you can omit the `page` parameter or set it to `1`
```php
$sendbeeApi->getContacts(['page' => 1]);
$sendbeeApi->getTags(['page' => 1]);
$sendbeeApi->getContactFields(['page' => 1]);
$sendbeeApi->getConversations(['page' => 1]);
$sendbeeApi->getMessages(['page' => 1, 'conversation_id' => '...']);
$sendbeeApi->getMessageTemplates(['page' => 1]);
```

Calling API methods that get a list of resources will return a `Sendbee\Api\Transport\Response` object containing pagination. 
Calling `getMeta()` on it will return pagination information.

```php

/**
 * @var $response \Sendbee\Api\Transport\Response
 */
$response = $sendbeeApi->getContacts();

$pagination = $response->getMeta();

echo "\n Total records: ",              $pagination->total;
echo "\n Current records from: ",       $pagination->from;
echo "\n Current records to: ",         $pagination->to;
echo "\n Current page: ",               $pagination->current_page;
echo "\n Last page: ",                  $pagination->last_page;
echo "\n How many records per page: ",  $pagination->per_page;

```

### <a href='exception-handling'>Exception handling</a>  

Sendbee API client for PHP will throw an Exception is some required data is missing or it is unable to connect to Sendbee.
You should wrap API calls in a try-catch block and handle thrown exceptions.

You should only encounter 2 types of exceptions:
- `\Sendbee\Api\Support\DataException` - Thrown when required data is missing. Message contains more information.

- `\GuzzleHttp\Exception\GuzzleException` - Thrown by underlying GuzzleHttp library. Indicates Sendbee backend is unavailable/unreachable

```php
// example of exception checking when calling some API method
// in this example, we are trying to create a new tag

$data = [];

try {
    $response = $sendbeeApi->createTag($data);
} catch (\Sendbee\Api\Support\DataException $ex) {
    // handle missing data
    // this happens when required data was not provided
    echo "Missing required data. ", $ex->getMessage();
} catch (\Exception $ex) {
    // handle exception thrown by GuzzleHttp
    // this is most likely due to a network issue
    echo "Could not contact backend endpoint. ", $ex->getMessage();
}

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

$requestIsValid = \Sendbee\Api\Client::verifyToken($secret, $token);

```  
