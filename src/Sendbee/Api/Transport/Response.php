<?php


namespace Sendbee\Api\Transport;


use Sendbee\Api\Support\DataException;
use Sendbee\Api\Support\FieldText;

class Response
{
    /**
     * @var bool is a 2xx HTTP response
     */
    protected $success = false;
    /**
     * @var int HTTP status
     */
    protected $httpStatus = 0;
    /**
     * @var string Raw response body
     */
    protected $rawBody = '';

    protected $data;
    protected $meta;
    protected $links;
    protected $warning;
    protected $error;

    public function __construct($httpStatus, $responseBody = '', $dataModelClass = null)
    {
        $this->httpStatus = $httpStatus;
        $this->success = ($httpStatus >= 200) && ($httpStatus < 300);
        $this->rawBody = $responseBody;

        try
        {
            // decode with creating objects out of assoc arrays
            $parsed = json_decode($responseBody);

            $mapping = [
                'meta' => ResponseMeta::class,
                'warning' => FieldText::class,
                'error' => ResponseError::class
            ];

            foreach ($mapping as $key => $classname)
            {
                if(property_exists($parsed, $key))
                {
                    $this->$key = new $classname($parsed->$key);
                }
            }

            if(property_exists($parsed, 'data'))
            {
                $data = $parsed->data;

                // creates models if a class is specified and it exists
                if($dataModelClass && class_exists($dataModelClass))
                {
                    // determine if this is an array of objects or object
                    $isCollection = is_array($data);



                    if($isCollection)
                    {
                        // if we have pagination data, assume we received a collection of models back
                        $this->data = [];

                        foreach($data as $d)
                        {
                            $this->data[] = new $dataModelClass($d);
                        }
                    }
                    else
                    {
                        $this->data = new $dataModelClass($data);
                    }
                }
                else
                {
                    $this->data = $data;
                }
            }
        }
        catch (DataException $ex)
        {
            throw $ex;
        }

    }

    /**
     * @return bool
     */
    public function isSuccess()
    {
        return $this->success;
    }

    /**
     * @return int
     */
    public function getHttpStatus()
    {
        return $this->httpStatus;
    }

    /**
     * @return string
     */
    public function getRawBody()
    {
        return $this->rawBody;
    }


    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return null|ResponseMeta
     */
    public function getMeta()
    {
        return $this->meta;
    }

    /**
     * @return null|ResponseLinks
     */
    public function getLinks()
    {
        return $this->links;
    }

    /**
     * @return null|FieldText
     */
    public function getWarning()
    {
        return $this->warning;
    }

    /**
     * @return null|ResponseError
     */
    public function getError()
    {
        return $this->error;
    }


}