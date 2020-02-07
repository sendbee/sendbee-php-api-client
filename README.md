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

```bash

```

## Usage  

### <a href='initialization'>Initialization</a>  

```php

```

### <a href='fetch-contacts'>Fetch contacts</a>  

```php

```

### <a href='subscribe-contact'>Subscribe contact</a>  

```php

```

### <a href='update-contact'>Update contact</a>  

```php

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
