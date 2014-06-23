<?php

namespace Microsite\Auth;

use LeanQuery\DomainQueryFactory;
use Nette\Security\AuthenticationException;
use Nette\Security\IAuthenticator;
use Nette\Security\Identity;
use Nette\Security\IIdentity;

/**
 * @author Vojtěch Kohout
 */
class Authenticator implements IAuthenticator
{

	/** @var DomainQueryFactory */
	private $domainQueryFactory;


	/**
	 * @param DomainQueryFactory $domainQueryFactory
	 */
	public function __construct(DomainQueryFactory $domainQueryFactory)
	{
		$this->domainQueryFactory = $domainQueryFactory;
	}

	/**
	 * @param array $credentials
	 * @return IIdentity
	 * @throws AuthenticationException
	 */
	public function authenticate(array $credentials)
	{
		list($username, $password) = $credentials;

		$user = $this->domainQueryFactory->createQuery()
			->select('u')
			->from(User::class, 'u')
			->where('u.username = %s', $username)
			->getEntity();

		if ($user === null or !$user->matchesPassword($password)) {
			throw new AuthenticationException('Invalid credentials.');
		}

		return new Identity($username);
	}

}
