<?php

include dirname(__FILE__)."/../phpJson.class.php";

class phpJsonTest extends PHPUnit_Framework_TestCase
{
 	public static function provider()
    {
    	$result = array(
    	    array('null'),
    	    array('true'),
    	    array('false'),
    	    
    	    array(array()),
    	    array(""),
    	    
    	    array(null),
    	    array(true),
    	    array(false),
    	    
    	    array(1),
    	    array(-1),
    	    array(1.000000),
    	    array(1.100000),
    	    array(1.2e-2),
    	    array('1.2e-2'),
    	    array("1.2e-2"),
    	    
            array(array(null, true, array(1, 2, 3), "hello\"],[world!")),
            array('hello world'),
            array('"hello world"'),
            array("'hello world'"),

            array("hello\t\"world\""),
            array('"hello\\t\\"world\\""'),

            array("\\\r\n\t\"/"),
            array('"\\\\\\r\\n\\t\\"\\/"'),

            array('héllö wørłd'),
            array('"h\u00e9ll\u00f6 w\u00f8r\u0142d"'),
            array('"héllö wørłd"'),
            
            array(array('this' => 'that')),
            array(array('this' => array('that'))),
            array(array('params' => array(array('foo' => array('1'), 'bar' => '1')))),
            array(array('0' => array('foo' => 'bar', 'baz' => 'winkle'))),
            array(array (
              'params' => array (
                0 => array (
                  'options' =>
                  array (
                    'old' => array(),
                    'new' => array (
                      0 => array (
                        'elements' => array (
                          'old' => array(),
                          'new' => array (
                            0 => array (
                              'elementName' => 'aa',
                              'isDefault' => false,
                              'elementRank' => '0',
                              'priceAdjust' => '0',
                              'partNumber' => '',
                            ),
                          ),
                        ),
                        'optionName' => 'aa',
                        'isRequired' => false,
                        'optionDesc' => NULL,
                      ),
                    ),
                  ),
                ),
              ),
            ))            
    	);
    	
    	$obj = new stdClass();
        $obj->a_string = '"he":llo}:{world';
        $obj->an_array = array(1, 2, 3);
        $obj->obj = new stdClass();
        $obj->obj->a_number = 123;    	
		$result[] = array($obj);
		return $result;
	}
	
 	/**
     * @dataProvider provider
     */		
	public function test($value)
	{
		$this->assertEquals(json_encode($value), phpJson::encode($value));
		$value = json_encode($value);
		$this->assertEquals(json_decode($value), phpJson::decode($value));
	}
}