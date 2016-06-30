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
		return $this->redis->hmget("tweet:$id", ['userId', 'body', 'time']);
	}

	public function getAll()
	{
		$tweets = $this->redis->lrange('tweets', 0, -1);
		foreach ($tweets as $tweetId)
		{
			var_dump($this->getTweet($tweetId));
		}
	}
}