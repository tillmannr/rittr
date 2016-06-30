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
		$postId = $this->getNextPostId();
		$tweet  = [
			'userId' => $userId,
			'body'   => $body,
			'time'   => time(),
		];

		$this->redis->hmset("post:$postId", $tweet);
	}

	private function setDummyTweets()
	{
		$this->redis->lpush('tweets', 'first tweet');
		$this->redis->lpush('tweets', 'second tweet');
		$this->redis->lpush('tweets', 'third tweet');
	}

	public function getAll()
	{
//		$this->setDummyTweets();
//		return $this->redis->hmget('tweets', 0, -1);
//		return $this->redis->lrange('tweets', 0, -1);
	}
}