/* eslint-disable no-prototype-builtins */
/* global wp_mail_smtp_pro, ajaxurl */
'use strict';

var WPMailSMTP = window.WPMailSMTP || {};
WPMailSMTP.Admin = WPMailSMTP.Admin || {};
WPMailSMTP.Admin.Settings = WPMailSMTP.Admin.Settings || {};

/**
 * WP Mail SMTP Admin area module.
 *
 * @since 1.5.0
 */
WPMailSMTP.Admin.Settings.Pro = WPMailSMTP.Admin.Settings.Pro || ( function( document, window, $ ) {

	/**
	 * Private functions and properties.
	 *
	 * @since 1.5.0
	 *
	 * @type {object}
	 */
	var __private = {

		/**
		 * Whether the email is valid.
		 *
		 * @since 1.5.0
		 *
		 * @param {string} email Email address.
		 *
		 * @returns {boolean} Whether email is valid or not.
		 */
		isEmailValid: function( email ) {
			var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
			return re.test( String( email ).toLowerCase() );
		},
	};

	/**
	 * Public functions and properties.
	 *
	 * @since 1.5.0
	 *
	 * @type {object}
	 */
	var app = {

		/**
		 * Start the engine. DOM is not ready yet, use only to init something.
		 *
		 * @since 1.5.0
		 */
		init: function() {

			// Do that when DOM is ready.
			$( document ).ready( app.ready );
		},

		/**
		 * DOM is fully loaded.
		 *
		 * @since 1.5.0
		 */
		ready: function() {

			app.pageHolder = $( '.wp-mail-smtp-tab-settings' );

			app.bindActions();
		},

		/**
		 * Process all generic actions/events, mostly custom that were fired by our API.
		 *
		 * @since 1.5.0
		 */
		bindActions: function() {

			app.license.bindActions();
			app.amazonses.bindActions();
		},

		/**
		 * License management.
		 *
		 * @since 1.5.0
		 *
		 * @type {object}
		 */
		license: {

			/**
			 * Generate a notice about performed action.
			 *
			 * @since 1.5.0
			 *
			 * @param {string} noticeType CSS class that represents the notice type.
			 * @param {string} message    Message to display to a user.
			 *
			 * @returns {string} Process HTML ready to be inserted into DOM.
			 */
			getNoticeHtml: function( noticeType, message ) {
				return '<div class="notice ' + noticeType + ' wp-mail-smtp-license-notice is-dismissible"><p>' + message + '</p>';
			},

			/**
			 * Process all license-related actions/events.
			 *
			 * @since 1.5.0
			 */
			bindActions: function() {

				app.pageHolder.on( 'click', '#wp-mail-smtp-setting-license-key-verify', this.verify );
				app.pageHolder.on( 'click', '#wp-mail-smtp-setting-license-key-deactivate', this.deactivate );
				app.pageHolder.on( 'click', '#wp-mail-smtp-setting-license-key-refresh', this.refresh );
			},

			/**
			 * Verify a license key. Ajaxified.
			 *
			 * @since 1.5.0
			 *
			 * @param {object} event jQuery event.
			 */
			verify: function( event ) {

				var $btn = jQuery( event.target ),
					$row = $btn.closest( '.wp-mail-smtp-setting-row' ),
					$licenseKey = $( '#wp-mail-smtp-setting-license-key', $row ),
					data = {
						action: 'wp_mail_smtp_pro_license_ajax',
						task: 'license_verify',
						nonce: $( '#wp-mail-smtp-setting-license-nonce', $row ).val(),
						license: $licenseKey.val()
					};

				$btn.prop( 'disabled', true );

				$.post( ajaxurl, data, function( response ) {

					var message,
						icon,
						type;

					if ( response.success ) {
						message = response.data.message;
						icon    = 'check-circle-solid-green';
						type    = 'green';

						$row.find( '.type, .desc, #wp-mail-smtp-setting-license-key-deactivate' ).show();
						$row.find( '.type strong' ).text( response.data.type );
						$licenseKey.prop( 'disabled', true );
					} else {
						message = response.data;
						icon    = 'exclamation-circle-regular-red';
						type    = 'red';

						$row.find( '.type, .desc, #wp-mail-smtp-setting-license-key-deactivate' ).hide();
						$licenseKey.prop( 'disabled', false );
					}

					app.license.displayModal( message, icon, type );

					$btn.prop( 'disabled', false );

				} ).fail( function( xhr ) {
					console.log( xhr.responseText );
				} );
			},

			/**
			 * Deactivate a license key. Ajaxified.
			 *
			 * @since 1.5.0
			 *
			 * @param {object} event jQuery event.
			 */
			deactivate: function( event ) {

				var $btn = jQuery( event.target ),
					$row = $btn.closest( '.wp-mail-smtp-setting-row' ),
					data = {
						action: 'wp_mail_smtp_pro_license_ajax',
						task: 'license_deactivate',
						nonce: $( '#wp-mail-smtp-setting-license-nonce', $row ).val()
					};

				$btn.prop( 'disabled', true );

				$.post( ajaxurl, data, function( response ) {

					var message = response.data,
						icon,
						type;

					if ( response.success ) {
						icon = 'check-circle-solid-green';
						type = 'green';

						$row.find( '#wp-mail-smtp-setting-license-key' ).val( '' );
						$row.find( '.type strong' ).text( 'lite' );
						$row.find( '.desc, #wp-mail-smtp-setting-license-key-deactivate' ).hide();
					} else {
						icon = 'exclamation-circle-regular-red';
						type = 'red';
					}

					$( '#wp-mail-smtp-setting-license-key', $row ).prop( 'disabled', false );

					app.license.displayModal( message, icon, type );

					$btn.prop( 'disabled', false );

				} ).fail( function( xhr ) {
					console.log( xhr.responseText );
				} );
			},

			/**
			 * Refresh a license key (get its type/status). Ajaxified.
			 *
			 * @since 1.5.0
			 *
			 * @param {object} event jQuery event.
			 */
			refresh: function( event ) {

				event.preventDefault();

				var $btn = jQuery( event.target ),
					$row = $btn.closest( '.wp-mail-smtp-setting-row' ),
					data = {
						action: 'wp_mail_smtp_pro_license_ajax',
						task: 'license_refresh',
						nonce: $( '#wp-mail-smtp-setting-license-nonce', $row ).val()
					};

				$btn.prop( 'disabled', true );

				$.post( ajaxurl, data, function( response ) {

					var message,
						icon,
						type;

					if ( response.success ) {
						message = response.data.message;
						icon    = 'check-circle-solid-green';
						type    = 'green';

						$row.find( '.type strong' ).text( response.data.type );
					} else {
						message = response.data;
						icon    = 'exclamation-circle-regular-red';
						type    = 'red';

						$row.find( '.desc, #wp-mail-smtp-setting-license-key-deactivate' ).hide();
						$( '#wp-mail-smtp-setting-license-key', $row ).prop( 'disabled', false );
					}

					app.license.displayModal( message, icon, type );

					$btn.prop( 'disabled', false );

				} ).fail( function( xhr ) {
					console.log( xhr.responseText );
				} );
			},

			/**
			 * Display the modal with provided text and icon.
			 *
			 * @since 2.1.0
			 *
			 * @param {string} message The message to be displayed in the modal.
			 * @param {string} icon    The icon name from /assets/images/font-awesome/ to be used in modal.
			 * @param {string} type    The type of the message (red, green, orange, blue, purple, dark).
			 */
			displayModal: function( message, icon, type ) {

				$.alert( {
					backgroundDismiss: true,
					escapeKey: true,
					animationBounce: 1,
					theme: 'modern',
					type: type,
					animateFromElement: false,
					draggable: false,
					closeIcon: true,
					useBootstrap: false,
					title: false,
					icon: '"></i><img src="' + wp_mail_smtp_pro.plugin_url + '/assets/images/font-awesome/' + icon + '.svg" style="width: 40px; height: 40px;" alt=""><i class="',
					content: message,
					boxWidth: '350px',
					buttons: {
						confirm: {
							text: wp_mail_smtp_pro.ok,
							btnClass: 'btn-confirm',
							keys: [ 'enter' ]
						}
					}
				} );
			}
		},

		/**
		 * AmazonSES specific methods.
		 *
		 * @since 1.5.0
		 *
		 * @type {object}
		 */
		amazonses: {

			/**
			 * Process all AmazonSES actions/events.
			 *
			 * @since 1.5.0
			 */
			bindActions: function() {
				jQuery( '.js-wp-mail-smtp-providers-amazonses-email-add' ).on( 'click', this.processEmailAdd );
				app.pageHolder.on( 'click', '.js-wp-mail-smtp-providers-amazonses-email-delete', this.processEmailDelete );
				app.pageHolder.on( 'click', '.js-wp-mail-smtp-providers-amazonses-email-resend', this.processEmailResend );
				app.pageHolder.on( 'click', '.js-wp-mail-smtp-providers-amazonses-email-resend-delete', this.processEmailResendDelete );
			},

			/**
			 * Process the click on an Add Email button.
			 *
			 * @since 1.5.0
			 *
			 * @param {object} event jQuery event.
			 *
			 * @returns {boolean} Whether email addition processed or not.
			 */
			processEmailAdd: function( event ) {
				event.preventDefault();

				var $btn = jQuery( event.target );
				var $email = $btn.siblings( 'input[type="email"]' );
				var email = $email.val();
				var nonce = $btn.siblings( 'input[name="wp_mail_smtp_pro_amazonses_email_add"]' ).val();
				var $holder = jQuery( '#wp-mail-smtp-providers-amazonses-email-enter' );

				if ( $btn.hasClass( 'disabled' ) ) {
					return false;
				}

				if ( ! __private.isEmailValid( email ) ) {
					$holder.find( 'p.response' ).remove();
					$holder.append( '<p class="response error">' + wp_mail_smtp_pro.ses_text_email_invalid + '</p>' );
					return false;
				}

				if ( email.length && nonce.length ) {

					// Send ajax request.
					jQuery.ajax( {
						url: ajaxurl,
						type: 'POST',
						dataType: 'json',
						data: {
							action: 'wp_mail_smtp_pro_providers_ajax',
							task: 'email_add',
							mailer: 'amazonses',
							email: email,
							nonce: nonce
						},
						beforeSend: function() {
							$holder.find( 'p.response' ).remove();
							$btn.addClass( 'disabled' );
						}
					} )
						.done( function( response ) {
							var p_class = 'response';
							p_class += response.hasOwnProperty( 'success' ) && response.success ? ' success' : ' error';

							if ( response.hasOwnProperty( 'success' ) && response.success ) {
								$email.val( '' );
							}

							$holder.append( '<p class="' + p_class + '">' + response.data + '</p>' );
						} )
						.fail( function() {
							$holder.append( '<p class="response error">' + wp_mail_smtp_pro.ses_text_smth_wrong + '</p>' );
						} )
						.complete( function() {
							$btn.removeClass( 'disabled' );
						} );
				}
			},

			/**
			 * Process the click on an Delete link for verified emails.
			 *
			 * @since 1.5.0
			 *
			 * @param {object} event jQuery event.
			 *
			 * @returns {boolean} Whether email was deleted.
			 */
			processEmailDelete: function( event ) {
				event.preventDefault();

				// Ask the user whether s\he insists.
				if ( ! confirm( wp_mail_smtp_pro.ses_text_email_delete ) ) {
					return false;
				}

				var $link = jQuery( event.target ).closest( 'a' );
				var email = $link.data( 'email' );
				var nonce = $link.data( 'nonce' ).toString();

				if ( $link.hasClass( 'disabled' ) ) {
					return false;
				}

				if ( ! __private.isEmailValid( email ) ) {
					alert( wp_mail_smtp_pro.ses_text_smth_wrong );
					return false;
				}

				if ( email.length && nonce.length ) {

					// Send ajax request.
					jQuery.ajax( {
						url: ajaxurl,
						type: 'POST',
						dataType: 'json',
						data: {
							action: 'wp_mail_smtp_pro_providers_ajax',
							task: 'email_delete',
							mailer: 'amazonses',
							email: email,
							nonce: nonce,
						},
						beforeSend: function() {
							$link.addClass( 'disabled' );
						},
					} )
						.done( function( response ) {
							if ( response.hasOwnProperty( 'success' ) && response.success ) {
								$link.closest( 'tr' ).fadeOut( 'fast', function() {
									this.remove();
								} );
							} else {
								alert( response.data );
							}
						} )
						.fail( function() {
							alert( wp_mail_smtp_pro.ses_text_smth_wrong );
						} )
						.complete( function() {
							$link.removeClass( 'disabled' );
						} );
				}
			},

			/**
			 * Process the click on an Resend link.
			 *
			 * @since 1.5.0
			 *
			 * @param {object} event jQuery event.
			 *
			 * @returns {boolean} Whether email was resent.
			 */
			processEmailResend: function( event ) {
				event.preventDefault();

				var $link = jQuery( event.target ).closest( 'a' );
				var email = $link.data( 'email' );
				var nonce = $link.data( 'nonce' ).toString();

				if ( $link.hasClass( 'disabled' ) ) {
					return false;
				}

				if ( ! __private.isEmailValid( email ) ) {
					alert( wp_mail_smtp_pro.ses_text_smth_wrong );
					return false;
				}

				if ( email.length && nonce.length ) {

					// Send ajax request.
					jQuery.ajax( {
						url: ajaxurl,
						type: 'POST',
						dataType: 'json',
						data: {
							action: 'wp_mail_smtp_pro_providers_ajax',
							task: 'email_add',
							mailer: 'amazonses',
							email: email,
							nonce: nonce
						},
						beforeSend: function() {
							$link.addClass( 'disabled' );
							$link.text( wp_mail_smtp_pro.ses_text_sending );
						}
					} )
						.done( function( response ) {
							if ( response.hasOwnProperty( 'success' ) && response.success ) {
								$link
									.html( '<span class="dashicons dashicons-yes"></span> ' + wp_mail_smtp_pro.ses_text_sent )
									.fadeOut( 1000, function() {
										jQuery( this ).text( wp_mail_smtp_pro.ses_text_resend );
										jQuery( this ).fadeIn( 'fast' );
									} );
							}
						} )
						.fail( function() {
							alert( wp_mail_smtp_pro.ses_text_smth_wrong );
						} )
						.complete( function() {
							$link.removeClass( 'disabled' );
						} );
				}
			},

			/**
			 * Process the click on an Delete link for pending emails.
			 *
			 * @since 1.5.0
			 *
			 * @param {object} event jQuery event.
			 *
			 * @returns {boolean} Whether email was processed.
			 */
			processEmailResendDelete: function( event ) {
				event.preventDefault();

				// Ask the user whether s\he insists.
				if ( ! confirm( wp_mail_smtp_pro.ses_text_email_delete ) ) {
					return false;
				}

				var $link = jQuery( event.target ).closest( 'a' );
				var email = $link.data( 'email' );
				var nonce = $link.data( 'nonce' ).toString();

				if ( $link.hasClass( 'disabled' ) ) {
					return false;
				}

				if ( ! __private.isEmailValid( email ) ) {
					alert( wp_mail_smtp_pro.ses_text_smth_wrong );
					return false;
				}

				if ( email.length && nonce.length ) {

					// Send ajax request.
					jQuery.ajax( {
						url: ajaxurl,
						type: 'POST',
						dataType: 'json',
						data: {
							action: 'wp_mail_smtp_pro_providers_ajax',
							task: 'email_resend_delete',
							mailer: 'amazonses',
							email: email,
							nonce: nonce
						},
						beforeSend: function() {
							$link.addClass( 'disabled' );
						}
					} )
						.done( function( response ) {
							if ( response.hasOwnProperty( 'success' ) && response.success ) {
								$link.closest( 'tr' ).fadeOut( 'fast', function() {
									this.remove();
								} );
							} else {
								alert( response.data );
							}
						} )
						.fail( function() {
							alert( wp_mail_smtp_pro.ses_text_smth_wrong );
						} )
						.complete( function() {
							$link.removeClass( 'disabled' );
						} );
				}
			},

			/**
			 * Close the popup to send a verification email.
			 *
			 * @since 1.5.0
			 */
			closeEmailAddPopup: function() {
				jQuery( '#TB_closeWindowButton' ).click();
			}
		}

	};

	// Provide access to public functions/properties.
	return app;
}( document, window, jQuery ) );

// Initialize.
WPMailSMTP.Admin.Settings.Pro.init();
