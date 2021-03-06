<?php

namespace Busybee\Core\SecurityBundle\Model;

use Busybee\Core\CalendarBundle\Entity\Year;
use Busybee\Core\SecurityBundle\Entity\User;
use Busybee\Core\SecurityBundle\Util\CanonicaliserInterface;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface as SecurityUserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 * Abstract User Manager implementation which can be used as base class for your
 * concrete manager.
 *
 * @author Johannes M. Schmitt <schmittjoh@gmail.com>
 */
abstract class UserManager implements UserManagerInterface, UserProviderInterface
{
	/**
	 * @var EncoderFactoryInterface
	 */
	protected $encoderFactory;

	/**
	 * @var CanonicaliserInterface
	 */
	protected $usernameCanonicaliser;

	/**
	 * @var CanonicaliserInterface
	 */
	protected $emailCanonicaliser;

	/**
	 * Constructor.
	 *
	 * @param EncoderFactoryInterface $encoderFactory
	 * @param CanonicaliserInterface  $usernameCanonicaliser
	 * @param CanonicaliserInterface  $emailCanonicaliser
	 */
	public function __construct(EncoderFactoryInterface $encoderFactory, CanonicaliserInterface $usernameCanonicaliser, CanonicaliserInterface $emailCanonicaliser)
	{
		$this->encoderFactory        = $encoderFactory;
		$this->usernameCanonicaliser = $usernameCanonicaliser;
		$this->emailCanonicaliser    = $emailCanonicaliser;
	}

	/**
	 * Returns an empty user instance
	 *
	 * @return UserInterface
	 */
	public function createUser()
	{
		$class = $this->getClass();
		$user  = new $class;

		return $user;
	}

	/**
	 * Finds a user either by email, or username
	 *
	 * @param string $usernameOrEmail
	 *
	 * @return UserInterface
	 */
	public function findUserByUsernameOrEmail($usernameOrEmail)
	{
		if (filter_var($usernameOrEmail, FILTER_VALIDATE_EMAIL))
		{
			return $this->findUserByEmail($usernameOrEmail);
		}

		return $this->findUserByUsername($usernameOrEmail);
	}

	/**
	 * Finds a user by email
	 *
	 * @param string $email
	 *
	 * @return UserInterface
	 */
	public function findUserByEmail($email)
	{
		return $this->findUserBy(['emailCanonical' => $this->canonicaliseEmail($email)]);
	}

	/**
	 * Canonicalises an email
	 *
	 * @param string $email
	 *
	 * @return string
	 */
	protected function canonicaliseEmail($email)
	{
		return $this->emailCanonicaliser->canonicalise($email);
	}

	/**
	 * Finds a user by username
	 *
	 * @param string $username
	 *
	 * @return UserInterface
	 */
	public function findUserByUsername($username)
	{
		return $this->findUserBy(array('usernameCanonical' => $this->canonicaliseUsername($username)));
	}

	/**
	 * Canonicalises a username
	 *
	 * @param string $username
	 *
	 * @return string
	 */
	protected function canonicaliseUsername($username)
	{
		return $this->usernameCanonicaliser->canonicalise($username);
	}

	/**
	 * Finds a user either by confirmation token
	 *
	 * @param string $token
	 *
	 * @return UserInterface
	 */
	public function findUserByConfirmationToken($token)
	{
		return $this->findUserBy(array('confirmationToken' => $token));
	}

	/**
	 * Refreshed a user by User Instance
	 *
	 * Throws UnsupportedUserException if a User Instance is given which is not
	 * managed by this UserManager (so another Manager could try managing it)
	 *
	 * It is strongly discouraged to use this method manually as it bypasses
	 * all ACL checks.
	 *
	 * @deprecated Use Busybee\Core\SecurityBundle\Security\UserProvider instead
	 *
	 * @param SecurityUserInterface $user
	 *
	 * @return UserInterface
	 */
	public function refreshUser(SecurityUserInterface $user)
	{
		trigger_error('Using the UserManager as user provider is deprecated. Use Busybee\Core\SecurityBundle\Security\UserProvider instead.', E_USER_DEPRECATED);

		$class = $this->getClass();
		if (!$user instanceof $class)
		{
			throw new UnsupportedUserException('Account is not supported.');
		}
		if (!$user instanceof User)
		{
			throw new UnsupportedUserException(sprintf('Expected an instance of Busybee\Core\SecurityBundle\Model\User, but got "%s".', get_class($user)));
		}

		$refreshedUser = $this->findUserBy(array('id' => $user->getId()));
		if (null === $refreshedUser)
		{
			throw new UsernameNotFoundException(sprintf('User with ID "%d" could not be reloaded.', $user->getId()));
		}

		return $refreshedUser;
	}

	/**
	 * Loads a user by username
	 *
	 * It is strongly discouraged to call this method manually as it bypasses
	 * all ACL checks.
	 *
	 * @deprecated Use Busybee\Core\SecurityBundle\Security\UserProvider instead
	 *
	 * @param string $username
	 *
	 * @return UserInterface
	 */
	public function loadUserByUsername($username)
	{
		trigger_error('Using the UserManager as user provider is deprecated. Use Busybee\Core\SecurityBundle\Security\UserProvider instead.', E_USER_DEPRECATED);

		$user = $this->findUserByUsername($username);

		if (!$user)
		{
			throw new UsernameNotFoundException(sprintf('No user with name "%s" was found.', $username));
		}

		return $user;
	}

	/**
	 * {@inheritDoc}
	 */
	public function updateCanonicalFields(UserInterface $user)
	{
		$user->setUsernameCanonical($this->canonicaliseUsername($user->getUsername()));
		$user->setEmailCanonical($this->canonicaliseEmail($user->getEmail()));
	}

	/**
	 * {@inheritDoc}
	 */
	public function updatePassword(UserInterface $user)
	{
		if (0 !== strlen($password = $user->getPlainPassword()))
		{
			$encoder = $this->getEncoder($user);
			$user->setPassword($encoder->encodePassword($password, $user->getSalt()));
			$user->eraseCredentials();
		}
	}

	protected function getEncoder(UserInterface $user)
	{
		return $this->encoderFactory->getEncoder($user);
	}

	/**
	 * {@inheritDoc}
	 * @deprecated UseBusybee\Core\SecurityBundle\Security\UserProvider instead
	 */
	public function supportsClass($class)
	{
		trigger_error('Using the UserManager as user provider is deprecated. Use Busybee\Core\SecurityBundle\Security\UserProvider instead.', E_USER_DEPRECATED);

		return $class === $this->getClass();
	}

	/**
	 * @param   UserInterface $user
	 *
	 * @return  Year
	 */
	public function getSystemYear(UserInterface $user)
	{
		if ($this->getSession()->has('currentYear') && $this->getSession()->get('currentYearCache', new \DateTime('-15 minutes') > new \DateTime('-10 Minutes')))
		{
			return $this->getSession()->get('currentYear');
		}
		if (!is_null($user->getYear()) && $user->getYear() instanceof Year)
		{
			$user->setYear($this->objectManager->getRepository(Year::class)->find($user->getYear()->getId()));
			$this->getSession()->set('currentYear', $user->getYear());
			$this->getSession()->set('currentYearCache', new \DateTime());

			return $user->getYear();
		}
		$year = $this->objectManager->getRepository(Year::class)->findCurrentYear();

		if (!empty($year->getId()))
		{
			$this->getSession()->set('currentYear', $year);
			$this->getSession()->set('currentYearCache', new \DateTime());
		}

		return $year;
	}

	/**
	 * @param $id
	 *
	 * @return mixed
	 */
	public function find($id)
	{
		return $this->objectManager->getRepository(User::class)->find($id);
	}


	/**
	 * @param User $person
	 *
	 * @return bool
	 */
	public function canDeleteUser(User $user = null): bool
	{

		if (is_null($user))
			return false;

		//Place rules here to stop delete .
		if (!$user instanceof User)
			return false;

		if (in_array('ROLE_SYSTEM_ADMIN', $user->getRoles()))
			return false;


		return $user->canDelete();
	}

	/**
	 * Format User Name
	 *
	 * @param User $user
	 *
	 * @return string
	 */
	public function formatUserName(User $user)
	{
		if ($this->personExists($user))
			return $this->getPerson()->formatName();

		return $user->formatName();
	}
}
