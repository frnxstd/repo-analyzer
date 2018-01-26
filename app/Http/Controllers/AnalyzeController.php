<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

class AnalyzeController extends Controller
{
    /**
     * @var Request $request
     */
    public $request;

    /**
     * @var Client $client
     */
    private $client;

    /**
     * @var string $api
     */
    private $api  = 'https://api.github.com/repos/';

    /**
     * AnalyzeController constructor
     *
     * @param Request $request
     * @param Client $client
     */
    public function __construct(Request $request, Client $client)
    {
        $this->request = $request;
        $this->client  = $client;
    }

    /**
     * Parse URL
     *
     * @param string $url
     * @return string
     */
    private function parse_url($url)
    {
        $parse = parse_url($url);

        if(isset($parse['path']))
        {
            return $parse['path'];
        }

        return '';
    }

    /**
     * Make an API call
     * https://developer.github.com/v3/repos/#get
     *
     * @param string $endpoint
     * @return array
     */
    private function api_call($endpoint)
    {
        $options['timeout']         = 10;
        $options['connect_timeout'] = 10;
        $options['read_timeout']    = 10;
        $options['http_errors']     = false;

        $request  = $this->client->request('GET', "{$this->api}{$endpoint}", $options);
        $response = $request->getBody()->getContents();

        return json_decode($response, true);
    }

    /**
     * Calculate difference between two dates in chosen unit
     *
     * @param $seconds
     * @return int
     */
    private function date_diff($seconds)
    {
        $from = new \DateTime('now');
        $to   = new \DateTime("@$seconds");

        return (int) $from->diff($to)->format("%R%a");
    }

    /**
     * Fix the calculation between 0 and 1
     *
     * @param $ratio
     * @return float|int
     */
    private function ratio_fix($ratio)
    {
        if($ratio > 1)
            $ratio = 1;
        else if($ratio < 0)
            $ratio = 0;

        return $ratio;
    }

    /**
     * Analyze the repository
     *
     * @param $data
     * @return array
     */
    public function analyze($data)
    {
        /**
         * NO WAY! THE REPO IS NOT AVAILABLE
         */
        if(isset($data['message']) && $data['message'] == 'Not Found')
        {
            return false;
        }

        // Retrieve configuration
        $criteria   = config('project.criteria');
        $update     = config('project.update');

        $time_limit = strtotime("{$update['deadline']}{$update['unit']}");
        $difference = strtotime($data['pushed_at']) - strtotime("-{$update['deadline']}{$update['unit']}") + time();

        $commits    = 0;

        foreach ($data['contributor_list'] as $contibutior)
        {
            $commits += $contibutior['contributions'];
        }

        // Grab target values
        $repo       = [
            'subscribers' => $data['subscribers_count'],
            'star'        => $data['watchers_count'],
            'fork'        => $data['forks_count'],
            'commit'      => $commits,
            'contributor' => count($data['contributor_list']),
            'update'      => round($this->date_diff($difference) / $this->date_diff($time_limit), 1)
        ];

        foreach ($criteria as $key => $value)
        {
            if (is_array($value))
            {
                unset($value['weight']);

                $rates = array_values($value);
                $found = 0;
                foreach ($rates as $rate)
                {
                    if ($repo[$key] >= $rate)
                    {
                        $found++;
                    } else {
                        break;
                    }
                }

                $repo[$key] = $found / 5;
            }
        }

        // Make sure there is no absolute value grater than 1 in the calculation
        foreach ($repo as $key => $value)
        {
            $repo[$key] = $this->ratio_fix($value);
        }

        return $repo;
    }

    /**
     * Analyze to score
     *
     * @param $analyze
     * @return float
     */
    private function score($analyze)
    {
        $score      = 0;
        // Retrieve configuration
        $criteria   = config('project.criteria');
        foreach ($criteria as $key => $value)
        {
            $weight = (int) (is_array($value)) ? $value['weight'] : $value;
            $score += $weight * $analyze[$key];
        }

        return round($score, 2);
    }

    /**
     * Display result
     *
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $repo  = $this->request->input('repo');
        $cahce = 'Repository_' . md5($repo);

        if(Cache::has($cahce))
        {
            $get = Cache::get($cahce);
        } else {
            $path                    = $this->parse_url($repo);
            $get                     = $this->api_call($path);
            $get['contributor_list'] = $this->api_call("$path/contributors");
            //https://api.github.com/repos/frnxstd/sudoxu/commits

            Cache::put($cahce, $get, 30);
        }

        if(isset($get['message']) && $get['message'] == 'Not Found')
        {
            return back()->withInput();
        }

        $analyze = $this->analyze($get);
        $score   = $this->score($analyze);

        if($score <= 20)
            $color = 'danger';
        else if($score <= 40)
            $color = 'warning';
        else if($score <= 60)
            $color = 'primary';
        else if($score <= 80)
            $color = 'info';
        else
            $color = 'success';


        return view('pages.result', [
            'score'  => $score,
            'color'  => $color,
            'result' => $get,
        ]);

    }
}
