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

	public function auth(string $userName, string $password)
	{
		$userId = $this->redis->hget('users', $userName);

		if (!$userId) {
			return false;
		}

		if (!password_verify($password, $this->redis->hget("user:$userId", 'password'))) {
			return false;
		}

		return $this->redis->hget("user:$userId", 'auth');
	}

	public function getUserId(string $userName)
	{
		return $this->redis->hget('users', $userName);
	}

	public function register(string $userName, string $password)
	{
		if (!empty($this->getUserId($userName))) {
			return false;
		}

		$userId  = $this->redis->incr('nextUserId');
		$authKey = md5(time());

		$this->redis->hset('users', $userName, $userId);
		$this->redis->hmset(
			"user:$userId",
			[
				'username' => $userName,
				'password' => password_hash($password, PASSWORD_BCRYPT),
				'auth'     => $authKey,
			]
		);
		$this->redis->hset('auths', $authKey, $userId);

		return $authKey;
	}

	public function getUserIdByAuthKey(string $authKey)
	{
		return $this->redis->hget('auths', $authKey);
	}

}