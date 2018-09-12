<?php

	return [
		'posts' => [
			'date' => [
				/**
				 * The date format that will be used to display posts dates
				 */
				'format' => 'd/m/Y'
			],
			/**
			 * Posts per page
			 */
			'per_page' => [
				'frontend' => 15,
				'backend' => 15
			],
		],
		'feed' => [
			/**
			 * The number of items that should appear in the feed
			 */
			'items' => 25
		]
	];