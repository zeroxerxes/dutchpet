<?php
// THIS IS A TEMPORARY DEBUG FILE. DO NOT LEAVE THIS FILE ON YOUR SERVER.

if ( ! isset( $_GET['debug'] ) ) {
    die( 'Please use this file with ?debug in the URL.' );
}

define('WP_USE_THEMES', false);
require_once('../../../wp-load.php');

error_log('*** Otroli Debug Test File is running! ***');

$record = null; // Mocking a record for demonstration
$handler = null; // Mocking a handler

// The function we are testing
function otroli_add_sender_to_recipients_debug( $record, $handler ) {
    $email_field_name = 'Pickup_Email';
    $sender_email = 'test@example.com'; // Using a test email for demonstration

    error_log('--- otroli_add_sender_to_recipients_debug function triggered. ---');
    error_log("Attempting to find field with ID: " . $email_field_name);

    // Simulate the data from the form
    $fields = [
        ['id' => 'Pickup_Full_Name', 'value' => 'Test User'],
        ['id' => 'Pickup_Email', 'value' => 'test@example.com'], // The field we are looking for
        ['id' => 'Pickup_Phone_Number', 'value' => '1234567890'],
    ];

    if ( is_array( $fields ) ) {
        foreach ( $fields as $field_data ) {
            if ( is_array( $field_data ) && isset( $field_data['id'] ) && $field_data['id'] === $email_field_name ) {
                $sender_email = sanitize_email( $field_data['value'] );
                error_log("Found sender email: " . $sender_email);
                break;
            }
        }
    }

    if ( is_email( $sender_email ) ) {
        error_log("Sender email is valid: " . $sender_email);
        // Simulate getting and setting recipients
        $recipients = 'admin@otroli.com';
        error_log("Original recipients: " . $recipients);

        if ( ! empty( $recipients ) && is_string( $recipients ) ) {
            if ( false === strpos( $recipients, $sender_email ) ) {
                $recipients .= ',' . $sender_email;
                error_log("Updated recipients to: " . $recipients);
            }
        }
    }
}

otroli_add_sender_to_recipients_debug( $record, $handler );

error_log('*** Otroli Debug Test File has finished. ***');