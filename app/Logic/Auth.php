<?php
namespace App\Logic;

class Auth
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

	public function auth($userName, $password)
	{
		$userId = $this->redis->hGet('users', $userName);

		if (!$userId) {
			return false;
		}

		if ($password != $this->redis->hGet("user:$userId", 'password')) {
			return false;
		}

		return $this->redis->hGet("user:$userId", 'auth');
	}
}