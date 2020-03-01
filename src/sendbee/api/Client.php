<?php


namespace Sendbee\Api;

class Client extends Transport
{
    /**
     * Get a paginated list of contacts optionally filtered by tags, status and/or search_query
     *
     * @param array $params
     * @return array
     */
    public function getContacts($params = [])
    {
        $validParams = [
            'tags', // Filter contacts by tags
            'status', // Filter contacts by status
            'search_query', // Filter contacts by query string
            'page' // Page number for pagination
        ];

        $query = $this->extractParams($validParams, $params);
        return $this->doRequest('contacts', self::GET, $query);
    }

    /**
     * Subscribe (add) a contact
     *
     * @param $contactData
     * @return array
     * @throws \Exception
     */
    public function subscribeContact($contactData)
    {
        $requiredKeys = ['phone'];
        $this->requireKeys($requiredKeys, $contactData);

        return $this->doRequest('/contacts/subscribe', self::POST, [], $contactData);
    }

    /**
     * Update contact information
     *
     * @param $contactData
     * @return array
     * @throws \Exception
     */
    public function updateContact($contactData)
    {
        $requiredKeys = ['id'];
        $this->requireKeys($requiredKeys, $contactData);

        return $this->doRequest('contacts', self::PUT, [], $contactData);
    }

    /**
     * Get a list of tags
     *
     * @param array $params
     * @return array
     */
    public function getTags($params = [])
    {
        $validParams = [
            'name', // Name of the tag
            'page' // Page number for pagination
        ];

        $query = $this->extractParams($validParams, $params);

        return $this->doRequest('contacts/tags', self::GET, $query);
    }

    /**
     * Create a new tag
     *
     * @param $data
     * @return array
     * @throws \Exception
     */
    public function createTag($data)
    {
        $requiredKeys = ['name'];
        $this->requireKeys($requiredKeys, $data);

        return $this->doRequest('/contacts/tags', self::POST, [], $data);
    }

    /**
     * Update an existing tag
     *
     * @param $data
     * @return array
     * @throws \Exception
     */
    public function updateTag($data)
    {
        $requiredKeys = ['id'];
        $this->requireKeys($requiredKeys, $data);

        return $this->doRequest('/contacts/tags', self::PUT, [], $data);
    }

    /**
     * Delete an existing tag
     *
     * @param $data
     * @return array
     * @throws \Exception
     */
    public function deleteTag($data)
    {
        $requiredKeys = ['id'];
        $this->requireKeys($requiredKeys, $data);

        return $this->doRequest('/contacts/tags', self::DELETE, [], $data);
    }

    /**
     * Get contact fields
     *
     * @param array $params
     * @return array
     */
    public function getContactFields($params = [])
    {
        $validParams = [
            'search_query', // Filter by query string
            'page' // Page number for pagination
        ];

        $query = $this->extractParams($validParams, $params);
        return $this->doRequest('contacts/fields', self::GET, $query);
    }

    /**
     * Create a new contact field
     *
     * @param $data
     * @return array
     * @throws \Exception
     */
    public function createContactField($data)
    {
        $requiredKeys = ['name', 'type'];
        $this->requireKeys($requiredKeys, $data);

        return $this->doRequest('/contacts/fields', self::POST, [], $data);
    }

    /**
     * Update an existing contact field
     *
     * @param $data
     * @return array
     * @throws \Exception
     */
    public function updateContactField($data)
    {
        $requiredKeys = ['id'];
        $this->requireKeys($requiredKeys, $data);

        return $this->doRequest('/contacts/fields', self::PUT, [], $data);
    }

    /**
     * Delete an existing contact field
     *
     * @param $data
     * @return array
     * @throws \Exception
     */
    public function deleteContactField($data)
    {
        $requiredKeys = ['id'];
        $this->requireKeys($requiredKeys, $data);

        return $this->doRequest('/contacts/fields', self::DELETE, [], $data);
    }

    /**
     * Get conversations
     *
     * @param array $params
     * @return array
     */
    public function getConversations($params = [])
    {
        $validParams = [
            'folder', // open, done, spam or notified
            'search_query', // Any kind of string that will be used to perform filtering
            'page' // Page number for pagination
        ];

        $query = $this->extractParams($validParams, $params);
        return $this->doRequest('conversations', self::GET, $query);
    }

    /**
     * Get messages in a conversation
     *
     * @param array $params
     * @return array
     * @throws \Exception
     */
    public function getMessages($params = [])
    {
        $requiredKeys = ['conversation_id'];
        $this->requireKeys($requiredKeys, $params);

        $validParams = [
            'conversation_id', // Conversation UUID
            'page' // Page number for pagination
        ];

        $query = $this->extractParams($validParams, $params);

        return $this->doRequest('conversations/messages', self::GET, $query);
    }

    /**
     * Send a message
     *
     * @param $data
     * @return array
     * @throws \Exception
     */
    public function sendMessage($data)
    {
        $requiredKeys = ['phone'];
        $this->requireKeys($requiredKeys, $data);

        return $this->doRequest('/conversations/messages/send', self::POST, [], $data);
    }

    /**
     * Get message templates
     *
     * @param array $params
     * @return array
     */
    public function getMessageTemplates($params = [])
    {
        $validParams = [
            'approved', // Fetch approved or unapproved templates
            'search_query', // Any kind of string that will be used to perform filtering
            'page' // Page number for pagination
        ];

        $query = $this->extractParams($validParams, $params);
        return $this->doRequest('/conversations/messages/templates', self::GET, $query);
    }

    /**
     * Send a message template
     *
     * @param $data
     * @return array
     * @throws \Exception
     */
    public function sendMessageTemplate($data)
    {
        $requiredKeys = ['phone', 'template_keyword', 'language', 'tags'];
        $this->requireKeys($requiredKeys, $data);

        return $this->doRequest('/conversations/messages/templates/send', self::POST, [], $data);
    }

    /**
     * Enable or disable chatbot for a conversation
     *
     * @param $data
     * @return array
     * @throws \Exception
     */
    public function chatbotActivity($data)
    {
        $requiredKeys = ['conversation_id', 'active'];
        $this->requireKeys($requiredKeys, $data);

        return $this->doRequest('/automation/chatbot/activity', self::PUT, [], $data);
    }

}