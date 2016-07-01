<?php
namespace App\Logic;

class TweetManager
{
	/**
	 * @var \Predis\Client
	 */
	private $redis;

	public function __construct(\Predis\Client $redis)
	{
		$this->redis = $redis;
	}

	public static function create()
	{
		return new self(
			\Redis::connection()
		);
	}

	private function getNextPostId()
	{
		return $this->redis->incr('nextPostId');
	}

	public function saveTweet($userId, $body)
	{
		$tweetId = $this->getNextPostId();
		$tweet  = [
			'userId' => $userId,
			'body'   => $body,
			'time'   => time(),
		];

		$this->redis->hmset("tweet:$tweetId", $tweet);
		$this->redis->lpush('tweets', $tweetId);
	}

	public function getTweet($id)
	{
		$tweet             = $this->redis->hgetall("tweet:$id"); //, ['userId', 'body', 'time']);
		$tweet['username'] = $this->redis->hget('user:' . $tweet['userId'], 'username');

		return $tweet;
	}

	public function getAll()
	{
		$tweets = $this->redis->lrange('tweets', 0, -1);
		$ret    = [];
		foreach ($tweets as $tweetId)
		{
			$ret[] = $this->getTweet($tweetId);
		}
		return $ret;
	}
}