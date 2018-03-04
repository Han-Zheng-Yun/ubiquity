<?php

namespace Ubiquity\utils\http;

/**
 * Http Response utilities
 * @author jc
 * @version 1.0.0.0
 *
 */
class Response {

	/**
	 * Send a raw HTTP header
	 * @param string $headerField the header field
	 * @param string $value the header value
	 * @param boolean $replace The optional replace parameter indicates whether the header should replace a previous similar header
	 * @param int $responseCode Forces the HTTP response code to the specified value
	 */
	public static function header($headerField, $value, $replace=null, $responseCode=null) {
		\header(trim($headerField) . ": " . trim($value), $replace);
	}

	/**
	 *
	 * @param string $headerField
	 * @param mixed $values
	 */
	private static function _headerArray($headerField, $values) {
		if (\is_array($values)) {
			$values=\implode(", ", $values);
		}
		self::header($headerField, $values);
	}

	public static function setContentType($contentType, $encoding=null) {
		$value=$contentType;
		if (isset($encoding))
			$value.=' ;' . $encoding;
		self::header('content-type', $value);
	}

	/**
	 * Forces the disabling of the browser cache
	 */
	public static function noCache() {
		self::header('Cache-Control', 'no-cache, must-revalidate');
		self::header('Expires', 'Sat, 26 Jul 1997 05:00:00 GMT');
	}

	/**
	 * Checks if or where headers have been sent
	 * @return boolean
	 */
	public static function isSent() {
		return \headers_sent();
	}

	/**
	 * Sets the response content-type to application/json
	 */
	public static function asJSON() {
		self::header('Content-Type', 'application/json');
	}

	/**
	 * Sets the response content-type to text/html
	 * @param string $encoding default: utf-8
	 */
	public static function asHtml($encoding='utf-8') {
		self::setContentType('text/html', $encoding);
	}

	/**
	 * Sets the response content-type to plain/text
	 * @param string $encoding default: utf-8
	 */
	public static function asText($encoding='utf-8') {
		self::setContentType('plain/text', $encoding);
	}

	/**
	 * Sets the Accept header
	 * @param string $value one of Http accept values
	 * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Content_negotiation/List_of_default_Accept_values
	 */
	public static function setAccept($value) {
		self::header('Accept', $value);
	}

	/**
	 * Sets the Access-Control-Allow-Origin field value
	 * @param string $origin
	 */
	public static function setAccessControlOrigin($origin) {
		self::header('Access-Control-Allow-Origin', $origin);
	}

	/**
	 * Sets the Access-Control-Allow-Methods field value
	 * @param string|array $origin
	 */
	public static function setAccessControlMethods($methods) {
		self::_headerArray('Access-Control-Allow-Methods', $origin);
	}

	/**
	 * Sets the Access-Control-Allow-Headers field value
	 * @param string|array $headers
	 */
	public static function setAccessControlHeaders($headers) {
		self::_headerArray('Access-Control-Allow-Headers', $headers);
	}

	/**
	 * Sets the response code
	 * @param int $value
	 */
	public static function setResponseCode($value) {
		\http_response_code($value);
	}

	/**
	 * Get the response code
	 * @return int
	 */
	public static function getResponseCode() {
		return \http_response_code();
	}
}
