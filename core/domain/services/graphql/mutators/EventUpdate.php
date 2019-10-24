<?php
namespace EventEspresso\core\domain\services\graphql\mutators;

use EEM_Event;
use EE_Event;
use WP_Post_Type;
use EventEspresso\core\domain\services\graphql\types\Event;
use EventEspresso\core\domain\services\graphql\data\mutations\EventMutation;
use GraphQL\Type\Definition\ResolveInfo;
use WPGraphQL\AppContext;
use GraphQL\Error\UserError;

class EventUpdate {

	/**
	 * Defines the mutation data modification closure.
	 *
     * @param EEM_Event $model
     * @param Event $type
	 * @return callable
	 */
	public static function mutateFields(EEM_Event $model, Event $type)
	{
		/**
		 * Update additional data related to the entity.
		 *
		 * @param int           $id                   The ID of the postObject being mutated
		 * @param array         $input                The input for the mutation
		 * @param WP_Post_Type  $post_type_object     The Post Type Object for the type of post being mutated
		 * @param string        $mutation_name        The name of the mutation (ex: create, update, delete)
		 * @param AppContext    $context              The AppContext passed down to all resolvers
		 * @param ResolveInfo   $info                 The ResolveInfo passed down to all resolvers
		 */
		return static function (
			$id,
			array $input,
			WP_Post_Type $post_type_object,
			$mutation_name,
			AppContext $context,
			ResolveInfo $info
		) use ($model, $type)
		{
			// Make sure we are dealing with the right entity.
			if ($post_type_object->graphql_single_name !== $type->name()) {
				return;
			}

			$entity = $model->get_one_by_ID($id);

			if ($entity instanceof EE_Event) {
				$args = EventMutation::prepare_fields($input, $mutation_name);
	
				// Update the entity
				$entity->save($args);
			}
		};
	}
}