<?php

/**
 * Run a WP Cron task to trash expired jobs offer
 */

add_action('wp', 'prefix_setup_trashoffers');
function prefix_setup_trashoffers() {
	if (!wp_next_scheduled('trashoffers')) {
		wp_schedule_event(current_time('timestamp'), 'hourly', 'trashoffers');
	}
}

add_action('trashoffers', 'trash_this_offers');
function trash_this_offers() {
	$args = array(
		'post_type'      => 'jobs',
		'post_status'    => 'publish',
		'numberposts' => -1
	);
	$offers = get_posts($args);
	if($offers) {
		$trashed = array();
		foreach($offers as $offer) {
			$temp_meta = get_post_meta($offer->ID);
			$expiration_date = strtotime($temp_meta["expiration"][0]);
			$current_date = time();
			if($current_date > $expiration_date) {
				wp_trash_post($offer->ID);
				$trashed[] = $offer;
			}
		}
		if(!empty($trashed)) {
			$message = 'Current date: '.date('m/d/Y H:i:s', $current_date).'<br/>';
			$message .= 'Jobs trashed:<br/><ul>';
			foreach($trashed as $date => $tr) {
				$temp_meta = get_post_meta($tr->ID);
				$message .= '<li>';
				$message .= 'Offer expiration date: '.$temp_meta["expiration"][0].'<br/>';
				$message .= 'Job ID: '.$tr->ID.'<br/>';
				$message .= 'Job name: '.$tr->post_title.'<br/><br/>';
				$message .= '</li>';
			}
			$message .= '</ul>';
			$headers = array('Content-Type: text/html; charset=UTF-8');
			wp_mail(get_option('admin_email'), 'Some job offers were trashed', $message, $headers);
		}
	}
}
