<?php

namespace App\Http\GraphQL\Scalars;

use GraphQL\Language\AST\Node;
use GraphQL\Language\AST\StringValueNode;
use GraphQL\Type\Definition\ScalarType;
use GraphQL\Utils\Utils;

/**
 * Read more about scalars here http://webonyx.github.io/graphql-php/type-system/scalar-types/
 */
class Json extends ScalarType
{
    /**
     * Serializes an internal value to include in a response.
     *
     * @param string $value
     * @return string
     */
    public function serialize($value)
    {
        // Assuming the internal representation of the value is always correct
        return json_decode($value);
       
        // TODO validate if it might be incorrect
    }
    
    /**
     * Parses an externally provided value (query variable) to use as an input
     *
     * @param mixed $value
     * @return mixed
     */
    public function parseValue($value)
    {
	    try {
		    $object = json_decocde($value);
	    } catch(\Exception $e) {
		    throw new Error(Utils::printSafeJson($e->getMessage()));
	    }
	
	    return $object;
    }
    
    /**
     * Parses an externally provided literal value (hardcoded in GraphQL query) to use as an input.
     *
     * E.g.
     * {
     *   user(email: "user@example.com")
     * }
     *
     * @param Node $valueNode
     * @param array|null $variables
     *
     * @return mixed
     */
    public function parseLiteral($valueNode, array $variables = null)
    {
        if (! $valueNode instanceof  StringValueNode) {
	        throw new Error('Query error: Can only parse strings got: ' . $valueNode->kind, [$valueNode]);
        }
        
        try {
        	$object = json_encode($valueNode->value);
        } catch(\Exception $e) {
	        throw new Error(Utils::printSafeJson($e->getMessage()));
        }
        
        return $object;
    }
}
