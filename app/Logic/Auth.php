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
		$userId = $this->redis->hget('users', $userName);

		if (!$userId) {
			return false;
		}

		if (md5($password) != $this->redis->hget("user:$userId", 'password')) {
			return false;
		}

		return $this->redis->hget("user:$userId", 'auth');
	}

	public function getUserId($userName)
	{
		return $this->redis->hget('users', $userName);
	}

	public function register($userName, $password)
	{
		if (!empty($this->getUserId($userName))) {
			return false;
		}

		$userId     = $this->redis->incr('nextUserId');
		$authSecret = md5(time());

		$this->redis->hset('users', $userName, $userId);
		$this->redis->hmset(
			"user:$userId",
			[
				'username' => $userName,
				'password' => md5($password),
				'auth'     => $authSecret,
			]
		);
		$this->redis->hset('auths', $authSecret, $userId);

		return $authSecret;
	}
}