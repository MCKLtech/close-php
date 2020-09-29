<?php

namespace Close;

use Http\Client\Common\Plugin\ErrorPlugin;
use Http\Client\Common\PluginClient;
use Http\Client\HttpClient;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\MessageFactoryDiscovery;
use Http\Discovery\UriFactoryDiscovery;
use Http\Message\Authentication;
use Http\Message\Authentication\BasicAuth;
use Http\Message\Authentication\Bearer;
use Http\Message\RequestFactory;
use Http\Message\UriFactory;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;
use stdClass;

class CloseClient
{
    const SDK_VERSION = '1.0.0';

    /**
     * @var HttpClient $httpClient
     */
    private $httpClient;

    /**
     * @var RequestFactory $requestFactory
     */
    private $requestFactory;

    /**
     * @var UriFactory $uriFactory
     */
    private $uriFactory;

    /**
     * @var string API user authentication
     */
    private $appIdOrToken;

    /**
     * @var array $extraRequestHeaders
     */
    private $extraRequestHeaders;

    /**
     * @var CloseUsers $users
     */
    public $users;

    /**
     * @var CloseContacts $contacts
     */
    public $contacts;

    /**
     * @var CloseLeads $leads
     */
    public $leads;

    /**
     * @var CloseOpportunities $opportunities
     */
    public $opportunities;

    /**
     * @var CloseActivities $activities
     */
    public $activities;

    /**
     * @var ClosePipelines $pipelines
     */
    public $pipelines;

    /**
     * @var CloseTasks $tasks
     */
    public $tasks;

    /**
     * @var array $rateLimitDetails
     */
    protected $rateLimitDetails = [];

    /**
     * CloseClient constructor.
     *
     * @param string $appIdOrToken Close API Key / Token
     * @param array $extraRequestHeaders Extra request headers to be sent in every api request
     */
    public function __construct(string $appIdOrToken, array $extraRequestHeaders = [])
    {
        $this->users = new CloseUsers($this);
        $this->leads = new CloseLeads($this);
        $this->contacts = new CloseContacts($this);
        $this->opportunities = new CloseOpportunities($this);
        $this->activities = new CloseActivities($this);
        $this->pipelines = new ClosePipelines($this);
        $this->tasks = new CloseTasks($this);

        $this->appIdOrToken = $appIdOrToken;
        $this->extraRequestHeaders = $extraRequestHeaders;

        $this->httpClient = $this->getDefaultHttpClient();
        $this->requestFactory = MessageFactoryDiscovery::find();
        $this->uriFactory = UriFactoryDiscovery::find();
    }

    /**
     * Sets the HTTP client.
     *
     * @param HttpClient $httpClient
     */
    public function setHttpClient(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * Sets the request factory.
     *
     * @param RequestFactory $requestFactory
     */
    public function setRequestFactory(RequestFactory $requestFactory)
    {
        $this->requestFactory = $requestFactory;
    }

    /**
     * Sets the URI factory.
     *
     * @param UriFactory $uriFactory
     */
    public function setUriFactory(UriFactory $uriFactory)
    {
        $this->uriFactory = $uriFactory;
    }

    /**
     * Sends POST request to Close API.
     *
     * @param  string $endpoint
     * @param  array $json
     * @return stdClass
     */
    public function post($endpoint, $json)
    {
        $response = $this->sendRequest('POST', "https://api.close.com/api/v1/$endpoint/", $json);
        return $this->handleResponse($response);
    }

    /**
     * Sends PUT request to Close API.
     *
     * @param  string $endpoint
     * @param  array $json
     * @return stdClass
     */
    public function put($endpoint, $json)
    {
        $response = $this->sendRequest('PUT', "https://api.close.com/api/v1/$endpoint/", $json);
        return $this->handleResponse($response);
    }

    /**
     * Sends DELETE request to Close API.
     *
     * @param  string $endpoint
     * @param  array $json
     * @return stdClass
     */
    public function delete($endpoint, $json)
    {
        $response = $this->sendRequest('DELETE', "https://api.close.com/api/v1/$endpoint/", $json);
        return $this->handleResponse($response);
    }

    /**
     * Sends GET request to Close API.
     *
     * @param string $endpoint
     * @param array  $queryParams
     * @return stdClass
     */
    public function get($endpoint, $queryParams = [])
    {
        $uri = $this->uriFactory->createUri("https://api.close.com/api/v1/$endpoint/");
        if (!empty($queryParams)) {
            $uri = $uri->withQuery(http_build_query($queryParams));
        }

        $response = $this->sendRequest('GET', $uri);

        return $this->handleResponse($response);
    }

    /**
     * Returns the next page of the result.
     *
     * @param  stdClass $pages
     * @return stdClass
     */
    public function nextPage($pages)
    {
        $response = $this->sendRequest('GET', $pages->next);
        return $this->handleResponse($response);
    }

    /**
     * Returns the next page of the result for a search query.
     *
     * @param  string $path
     * @param  array $query
     * @param  stdClass $pages
     * @return stdClass
     */
    public function nextSearchPage(string $path, array $query, $pages)
    {
        $options = [
            "query" => $query,
            "pagination" => [
                "per_page" => $pages->per_page,
                "starting_after" => $pages->next->starting_after,
            ]
        ];
        return $this->post($path, $options);
    }

    /**
     * Returns the next page of the result for a cursor based search.
     *
     * @param string $path
     * @param string $startingAfter
     * @return stdClass
     */
    public function nextCursorPage(string $path, string $startingAfter)
    {
        $response = $this->get($path . "?starting_after=" . $startingAfter);
        return $this->handleResponse($response);
    }

    /**
     * Gets the rate limit details.
     *
     * @return array
     */
    public function getRateLimitDetails()
    {
        return $this->rateLimitDetails;
    }

    /**
     * @return HttpClient
     */
    private function getDefaultHttpClient()
    {
        return new PluginClient(
            HttpClientDiscovery::find(),
            [new ErrorPlugin()]
        );
    }

    /**
     * @return array
     */
    private function getRequestHeaders()
    {
        return array_merge(
            [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'User-Agent' => 'Close-PHP-SDK/' . self::SDK_VERSION,
            ],
            $this->extraRequestHeaders
        );
    }

    /**
     * Returns authentication parameters
     *
     * @return Authentication
     */
    private function getAuth()
    {
        if (!empty($this->appIdOrToken)) {
            return new BasicAuth($this->appIdOrToken, '');
        }
        return null;
    }

    /**
     * Authenticates a request object
     * @param RequestInterface $request
     *
     * @return RequestInterface
     */
    private function authenticateRequest(RequestInterface $request)
    {
        $auth = $this->getAuth();
        return $auth ? $auth->authenticate($request) : $request;
    }

    /**
     * @param string              $method
     * @param string|UriInterface $uri
     * @param array|string|null   $body
     *
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     */
    private function sendRequest($method, $uri, $body = null)
    {
        $headers = $this->getRequestHeaders();
        $body = is_array($body) ? json_encode($body) : $body;
        $request = $this->authenticateRequest(
            $this->requestFactory->createRequest($method, $uri, $headers, $body)
        );

        return $this->httpClient->sendRequest($request);
    }

    /**
     * @param ResponseInterface $response
     *
     * @return stdClass
     */
    private function handleResponse(ResponseInterface $response)
    {
        $this->setRateLimitDetails($response);

        $stream = $response->getBody()->getContents();

        return json_decode($stream);
    }

    /**
     * @param ResponseInterface $response
     */
    private function setRateLimitDetails(ResponseInterface $response)
    {
        $this->rateLimitDetails = [
            'limit' => $response->hasHeader('x-rate-limit-limit')
                ? (int)$response->getHeader('x-rate-limit-limit')[0]
                : null,
            'remaining' => $response->hasHeader('x-rate-limit-remaining')
                ? (int)$response->getHeader('x-rate-limit-remaining')[0]
                : null,
            'reset_at' => $response->hasHeader('x-rate-limit-reset')
                ? (new \DateTimeImmutable())->setTimestamp((int)$response->getHeader('x-rate-limit-reset')[0])
                : null,
        ];
    }
}
