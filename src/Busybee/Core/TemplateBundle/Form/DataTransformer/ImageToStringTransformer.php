<?php

namespace Busybee\Core\TemplateBundle\Form\DataTransformer;

use Busybee\People\PersonBundle\Entity\Person;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\HttpFoundation\File\File;
use Busybee\Core\TemplateBundle\Model\ImageUploader;

class ImageToStringTransformer implements DataTransformerInterface
{
	/**
	 * @var ImageUploader
	 */
	private $uploader;

	/**
	 * ImageToStringTransformer constructor.
	 *
	 * @param ImageUploader $uploader
	 */
	public function __construct(ImageUploader $uploader)
	{
		$this->uploader = $uploader;
	}

	/**
	 * Transforms an string to File
	 *
	 * @param  File|null $data
	 *
	 * @return string
	 */
	public function transform($data)
	{
		$file = file_exists($data) ? $data : null;
		$file = is_null($file) ? new File(null, false) : new File($file, true);

		return $file;
	}

	/**
	 * Transforms a File into a string.
	 *
	 * @param mixed $data
	 *
	 * @return null|string
	 * @internal param $ null|File
	 */
	public function reverseTransform($data)
	{
		if ($data instanceof File)
		{
			$data = $this->uploader->upload($data);
		}

		return $data;
	}

	private function uploadFile(Person $entity)
	{
		// upload only works for Person entities
		if ($entity instanceof Person)
		{
			$fileName = $this->uploader->upload($entity);
			$entity->setPhoto($fileName);
		}
	}
}