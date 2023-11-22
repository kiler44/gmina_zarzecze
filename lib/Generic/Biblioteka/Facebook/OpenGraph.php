<?php
namespace Generic\Biblioteka\Facebook;


/**
 * Description of OpenGraph
 *
 * @author Adrian Sieracki
 */
class OpenGraph
{
	protected $properties;

	public function __construct($properties = array())
	{
		$this->properties = $properties;
	}

	public function getMetaTags()
	{
		$meta = "";

		if(is_array($this->properties) && count($this->properties) > 0)
		{
			foreach($this->properties as $property => $value)
			{
				$meta .= "<meta property=\"$property\" content=\"$value\"/> ";
			}
		}

		return $meta;
	}
}

class OpenGraphException extends \Exception
{
	public function __construct($message) {
		parent::__construct($message);
	}
}
?>
