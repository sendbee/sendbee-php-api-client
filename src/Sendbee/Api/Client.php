<?php


namespace Sendbee\Api;

use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

use Sendbee\Api\Models\ChatbotStatus;
use Sendbee\Api\Models\Contact;
use Sendbee\Api\Models\ContactField;
use Sendbee\Api\Models\ContactTag;
use Sendbee\Api\Models\Conversation;
use Sendbee\Api\Models\Member;
use Sendbee\Api\Models\Message;
use Sendbee\Api\Models\MessageTemplate;
use Sendbee\Api\Models\SentMessage;
use Sendbee\Api\Models\ServerMessage;
use Sendbee\Api\Models\Team;
use Sendbee\Api\Support\DataException;

class Client extends BaseClient
{
    /**
     * Get a paginated list of contacts optionally filtered by tags, status and/or search_query
     *
     * @param array $data
     * @return ResponseInterface|Transport\Response|null
     * @throws Support\DataException
     */
    public function getContacts($data = [])
    {
        $validParams = [
            'tags', // Filter contacts by tags
            'status', // Filter contacts by status
            'search_query', // Filter contacts by query string
            'page' // Page number for pagination
        ];

        $query = $this->filterKeys($validParams, $data);
        return $this->makeRequest('/contacts', self::GET, $query, [], Contact::class);
    }

    /**
     * Subscribe (add) a contact
     *
     * @param $contactData
     * @return Sendbee\Api\Transport\Response|string
     * @throws Support\DataException
     */
    public function subscribeContact($contactData)
    {
        $requiredKeys = ['phone'];
        $this->requireKeys($requiredKeys, $contactData);

        return $this->makeRequest('/contacts/subscribe', self::POST, [], $contactData, Contact::class);
    }

    /**
     * Update contact information
     *
     * @param $contactData
     * @return ResponseInterface|Sendbee\Api\Transport\Response|null
     * @throws Support\DataException
     */
    public function updateContact($contactData)
    {
        $requiredKeys = ['id'];
        $this->requireKeys($requiredKeys, $contactData);

        return $this->makeRequest('contacts', self::PUT, [], $contactData, Contact::class);
    }

    /**
     * Get a list of tags
     *
     * @param array $params
     * @return Sendbee\Api\Transport\Response|string
     * @throws Support\DataException
     */
    public function getTags($params = [])
    {
        $validParams = [
            'name', // Name of the tag
            'page' // Page number for pagination
        ];

        $query = $this->filterKeys($validParams, $params);

        return $this->makeRequest('contacts/tags', self::GET, $query, [], ContactTag::class);
    }

    /**
     * Create a new tag
     *
     * @param $data
     * @return Sendbee\Api\Transport\Response|string
     * @throws GuzzleException
     * @throws Support\DataException
     */
    public function createTag($data)
    {
        $requiredKeys = ['name'];
        $this->requireKeys($requiredKeys, $data);

        return $this->makeRequest('/contacts/tags', self::POST, [], $data, ContactTag::class);
    }

    /**
     * Update an existing tag
     *
     * @param $data
     * @return Sendbee\Api\Transport\Response|string
     * @throws GuzzleException
     * @throws Support\DataException
     */
    public function updateTag($data)
    {
        $requiredKeys = ['id', 'name'];
        $this->requireKeys($requiredKeys, $data);

        return $this->makeRequest('/contacts/tags', self::PUT, [], $data, ContactTag::class);
    }

    /**
     * Delete an existing tag
     *
     * @param $data
     * @return Sendbee\Api\Transport\Response|string
     * @throws GuzzleException
     * @throws Support\DataException
     */
    public function deleteTag($data)
    {
        $requiredKeys = ['id'];
        $this->requireKeys($requiredKeys, $data);

        return $this->makeRequest('/contacts/tags', self::DELETE, [], $data, ServerMessage::class);
    }

    /**
     * Get contact fields
     *
     * @param array $params
     * @return Sendbee\Api\Transport\Response|string
     * @throws GuzzleException
     * @throws DataException
     */
    public function getContactFields($params = [])
    {
        $validParams = [
            'search_query', // Filter by query string
            'page' // Page number for pagination
        ];

        $query = $this->filterKeys($validParams, $params);
        return $this->makeRequest('contacts/fields', self::GET, $query, [], ContactField::class);
    }

    /**
     * Create a new contact field
     *
     * @param $data
     * @return Sendbee\Api\Transport\Response|string
     * @throws GuzzleException
     * @throws Support\DataException
     */
    public function createContactField($data)
    {
        $requiredKeys = ['name', 'type'];
        $this->requireKeys($requiredKeys, $data);

        return $this->makeRequest('/contacts/fields', self::POST, [], $data, ContactField::class);
    }

    /**
     * Update an existing contact field
     *
     * @param $data
     * @return Sendbee\Api\Transport\Response|string
     * @throws GuzzleException
     * @throws Support\DataException
     */
    public function updateContactField($data)
    {
        $requiredKeys = ['id', 'name', 'type'];
        $this->requireKeys($requiredKeys, $data);

        return $this->makeRequest('/contacts/fields', self::PUT, [], $data, ContactField::class);
    }

    /**
     * Delete an existing contact field
     *
     * @param $data
     * @return Sendbee\Api\Transport\Response|string
     * @throws GuzzleException
     * @throws Support\DataException
     */
    public function deleteContactField($data)
    {
        $requiredKeys = ['id'];
        $this->requireKeys($requiredKeys, $data);

        return $this->makeRequest('/contacts/fields', self::DELETE, [], $data, ServerMessage::class);
    }

    /**
     * Get conversations
     *
     * @param array $params
     * @return Sendbee\Api\Transport\Response|string
     * @throws GuzzleException
     * @throws DataException
     */
    public function getConversations($params = [])
    {
        $validParams = [
            'folder', // open, done, spam or notified
            'search_query', // Any kind of string that will be used to perform filtering
            'page' // Page number for pagination
        ];

        $query = $this->filterKeys($validParams, $params);
        return $this->makeRequest('conversations', self::GET, $query, [], Conversation::class);
    }

    /**
     * Get conversations
     *
     * @param array $params
     * @return Sendbee\Api\Transport\Response|string
     * @throws GuzzleException
     * @throws DataException
     */
    public function getConversation($params = [])
    {
        $requiredKeys = ['conversation_id'];
        $this->requireKeys($requiredKeys, $params);

        $validParams = [
            'conversation_id', // Conversation UUID
        ];

        $query = $this->filterKeys($validParams, $params);

        return $this->makeRequest('conversation', self::GET, $query, [], Conversation::class);
    }

    /**
     * Get conversations
     *
     * @param array $params
     * @return Sendbee\Api\Transport\Response|string
     * @throws GuzzleException
     * @throws DataException
     */
    public function updateConversation($params = [])
    {
        $requiredKeys = ['conversation_id'];
        $this->requireKeys($requiredKeys, $params);

        $validParams = [
            'conversation_id', // Conversation UUID
            'folder', // Folder to assign conversation to - open|done
        ];

        $data = $this->filterKeys($validParams, $params);

        return $this->makeRequest('/conversation', self::POST, [], $data, Conversation::class);
    }

    /**
     * Get messages in a conversation
     *
     * @param array $params
     * @return Sendbee\Api\Transport\Response|string
     * @throws GuzzleException
     * @throws Support\DataException
     */
    public function getMessages($params = [])
    {
        $requiredKeys = ['conversation_id'];
        $this->requireKeys($requiredKeys, $params);

        $validParams = [
            'conversation_id', // Conversation UUID
            'page' // Page number for pagination
        ];

        $query = $this->filterKeys($validParams, $params);

        return $this->makeRequest('conversations/messages', self::GET, $query, [], Message::class);
    }

    /**
     * Send a message
     *
     * @param  $params
     * @return Sendbee\Api\Transport\Response|string
     * @throws GuzzleException
     * @throws Support\DataException
     */
    public function sendMessage($params)
    {
        $requiredKeys = ['phone', 'text'];
        $this->requireKeys($requiredKeys, $params);

        $validParams = [
            'phone', // Contact's phone number
            'text', // Message text
            'media_url', // Media URL for media message
            'prevent_bot_off', // set to true to prevent turning-off chatbot
            'agent_id', // assigned agent for the conversation
            'live_inbox', // trigger real-time events after sending
        ];

        $data = $this->filterKeys($validParams, $params);

        return $this->makeRequest('/conversations/messages/send', self::POST, [], $data, SentMessage::class);
    }

    /**
     * Get message templates
     *
     * @param array $params
     * @return Sendbee\Api\Transport\Response|string
     * @throws GuzzleException
     * @throws DataException
     */
    public function getMessageTemplates($params = [])
    {
        $validParams = [
            'status', // Fetch by status: "rejected", approved", "rejected"
            'search_query', // Any kind of string that will be used to perform filtering
            'page' // Page number for pagination
        ];

        $query = $this->filterKeys($validParams, $params);
        return $this->makeRequest('/conversations/messages/templates', self::GET, $query, [], MessageTemplate::class);
    }

    /**
     * Send a message template
     *
     * @param array $data
     * @return Sendbee\Api\Transport\Response|string
     * @throws GuzzleException
     * @throws Support\DataException
     */
    public function sendMessageTemplate($data = [])
    {
        $requiredKeys = ['phone', 'template_keyword', 'language'];
        $this->requireKeys($requiredKeys, $data);

        $validParams = [
            'tags', // template tags
            'button_tags', // template button tags
            'agent_id', // assigned agent for the conversation
            'live_inbox' // trigger real-time events after sending
        ];

        $query = $this->filterKeys($validParams, $data);

        return $this->makeRequest('/conversations/messages/templates/send', self::POST, [], $data, SentMessage::class);
    }

    /**
     * Get teams
     *
     * @param array $params
     * @return ResponseInterface|Transport\Response|null
     * @throws DataException
     */
    public function getTeams($params = [])
    {
        $validParams = [
            'member_id', // optional member ID
            'page' // Page number for pagination
        ];

        $query = $this->filterKeys($validParams, $params);
        return $this->makeRequest('/teams/teams', self::GET, $query, [], Team::class);
    }

    /**
     * Get members of a team or business
     *
     * @param array $params
     * @return ResponseInterface|Transport\Response|null
     * @throws DataException
     */
    public function getMembers($params = [])
    {
        $validParams = [
            'team_id', //
            'page' // Page number for pagination
        ];

        $query = $this->filterKeys($validParams, $params);
        return $this->makeRequest('/teams/members', self::GET, $query, [], Member::class);
    }




    /**
     * Enable or disable chatbot for a conversation
     *
     * @param $data
     * @return Sendbee\Api\Transport\Response|string
     * @throws GuzzleException
     * @throws Support\DataException
     */
    public function chatbotActivity($data)
    {
        $requiredKeys = ['conversation_id', 'active'];
        $this->requireKeys($requiredKeys, $data);

        return $this->makeRequest('/automation/chatbot/activity', self::PUT, [], $data, ServerMessage::class);
    }

    public function getChatbotActivity($data)
    {
        $requiredKeys = ['conversation_id'];
        $this->requireKeys($requiredKeys, $data);

        return $this->makeRequest('/automation/chatbot/activity/status', self::GET, $data, [], ChatbotStatus::class);
    }

}