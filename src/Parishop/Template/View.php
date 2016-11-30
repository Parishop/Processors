<?php
namespace Parishop\Template;

/**
 * Class View
 * @see     \PHPixie\Template\Renderer\Runtime
 * @method string resolve($template)
 * @method string render($template, $data = array())
 * @method string startBlock($name, $onlyIfNotExists = false, $prepend = false)
 * @method string endBlock()
 * @method string layout($name)
 * @method string childContent()
 * @method string blockExists($name)
 * @method string block($name)
 * @method mixed get($path, $default = null)
 * @method void set($path, $data)
 * @method \PHPixie\Slice\Type\ArrayData data()
 * @method void remove($path)
 * *********************************************************************************************************************
 * @see     \PHPixie\Framework\Extensions\Template\Extension\RouteTranslator
 * @method string httpPath($resolverPath, $attributes = array());
 * @method string httpUri($resolverPath, $attributes = array(), $withHost = true);
 * *********************************************************************************************************************
 * @see     \PHPixie\Template\Extensions\Extension\HTML
 * @method string htmlEscape();
 * @method string htmlOutput();
 * *********************************************************************************************************************
 * @see     \Parishop\Document
 * @method string title()
 * @method array getMeta()
 * @method array getLinks()
 * @method array getScripts()
 * *********************************************************************************************************************
 * @see     \Parishop\Images
 * @method string imageRender($imageName = null, $width = null, $height = null, $title = null, $attributes = [], $format = null, $quality = 90)
 * @method string imageResize($imageName, $width, $height, $format = null, $quality = 90)
 * @method string imageResizeThumb($imageName, $format = null, $quality = 90)
 * @method string imageResizeMiddle($imageName, $format = null, $quality = 90)
 * @method string imageResizeFull($imageName, $format = null, $quality = 90)
 * @method string imagePath($imageName = null, $width = null, $height = null)
 * @method string imagePathThumb($imageName)
 * @method string imagePathMiddle($imageName)
 * @method string imagePathFull($imageName)
 * *********************************************************************************************************************
 * @see     \Parishop\Messages
 * @method \Parishop\Messages\Message[] messages()
 * @package Parishop\Template
 * @since 1.0.3
 */
class View extends \PHPixie\Template\Renderer\Runtime
{

}
