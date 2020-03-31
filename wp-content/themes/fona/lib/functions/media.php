<?php
/**
 * Media functionality
 */

/**
 * Get closest adaptive image size.
 */
function ais_get_closest_size($size, $sizes)
{
	$closest = null;

	if (!empty($sizes)) {
		foreach ($sizes as &$item) {
			if (null === $closest || abs($size - $closest) > abs($item - $size)) {
				$closest = $item;
			}
		}
	}

	return $closest;
}

/**
 * Resize image for adative system
 *
 * @param  string  $url
 */
function ais_resize_image($media_id, $url, $path, $originalWidth, $originalHeight, $single_width, $single_height = null, $crop, $fixed_width = null, $async = false)
{
	$settings = get_option('zoo_theme_settings');

	$settings['adaptive_image_sizes'] = !empty($settings['adaptive_image_sizes']) ? $settings['adaptive_image_sizes'] : '258,516,720,1032,1440,2064,2880';
	$ais_break_points = explode(',', $settings['adaptive_image_sizes']);

	if ('1' === $settings['enable_adaptive_images'] || is_array($async)) {
		if (is_array($async)) {
			$ais_width = (int)$async['images'];
			$ais_screen = (int)$async['screen'];
		} else {
			$ais_width = min($ais_break_points);
			$ais_screen = min($ais_break_points);
		}
		if ('' === $single_width && null !== $single_height) {
			$single_height = $single_height * 1.25;
			$screen_ratio = $originalWidth / $originalHeight;
			$single_width = round(12 / ($ais_screen / ($screen_ratio * $single_height)));
		}
		if ($ais_screen < 781) {
			$closest_size = ais_get_closest_size($ais_width , $ais_break_points);
		} else {
			if (null === $fixed_width || '' === $fixed_width) {
				if ($crop) {
					$closest_size = ais_get_closest_size(($ais_width / (12 / max($single_width, $single_height))) , $ais_break_points);
				} else {
					$closest_size = ais_get_closest_size(($ais_width / (12 / $single_width)) , $ais_break_points);
				}
			} else {
				if ($crop) $closest_size = ais_get_closest_size(max($single_width, $single_height) , $ais_break_points);
				else {
					if ('width' === $fixed_width) {
						$get_new_height = ($ais_width * $single_width) / $ais_screen;
						$closest_size = ais_get_closest_size($get_new_height , $ais_break_points);
					} else if ('height' === $fixed_width) {
						$get_new_height = ais_get_closest_size($single_height , $ais_break_points);
						$get_new_width = round(($originalWidth * $get_new_height) / $originalHeight);
						$closest_size = ais_get_closest_size($get_new_width , $ais_break_points);
					} else $closest_size = 10000;
					$single_width = (12 * $closest_size) / $ais_width;
				}
			}
		}
	} else {
		$closest_size = 10000;
	}

	if ($crop) {
		if ($single_width > $single_height) {
			$dest_w = $closest_size;
			$dest_h = ($closest_size / $single_width) * $single_height;
		} else {
			$dest_h = $closest_size;
			$dest_w = $dest_h * ($single_width / $single_height);
		}

		if ($dest_h > $originalHeight) {
			$dest_h = $originalHeight;
			$dest_w = $dest_h * ($single_width / $single_height);
		}

		if ($dest_w > $originalWidth) {
			$dest_w = $originalWidth;
			$dest_h = ($dest_w / $single_width) * $single_height;
		}

		if ($dest_h > $originalHeight || $dest_w > $originalWidth) {
			$closest_size = min($originalWidth, $originalHeight);
			if ($single_width > $single_height) {
				$dest_w = $closest_size;
				$dest_h = ($closest_size / $single_width) * $single_height;
			} else {
				$dest_h = $closest_size;
				$dest_w = $dest_h * ($single_width / $single_height);
			}
		}

		$new_dimensions = image_resize_dimensions($originalWidth, $originalHeight, $dest_w, $dest_h, $crop);
	} else {
		if ($closest_size > $originalWidth && null === $fixed_width) $closest_size = $originalWidth;
		$new_dimensions = image_resize_dimensions($originalWidth, $originalHeight, $closest_size, $originalHeight, $crop);

	}

	$targetWidth = $new_dimensions[4];
	$targetHeight = $new_dimensions[5];

	// this is an attachment, so we have the ID
	$image_src = array();

	$remote = false;

	// Check if S3 is deleting local images
	global $as3cf;

	if (isset($as3cf)) {
		if ($as3cf->get_setting('serve-from-s3')) $remote = true;
	}

	if ($remote) {
		$remote_url = $as3cf->get_attachment_url($media_id);
		if (empty($remote_url)) {
			$remote = false;
		} else {
			$url = $remote_url;
		}
		$headers = ($url !== '' && !empty($url)) ? get_headers($url) : array('');
		$media_url = stripos($headers[0],"200 OK") ? $url : '';
		if ('' === $media_url) {
			add_filter('as3cf_get_attached_file_copy_back_to_local', '__return_true');
			$media_url = get_attached_file( $media_id );
		}
	}

	// If the file is relative, prepend upload dir
	if ($url && 0 === strpos($url, '/') && !preg_match('|^.:\\\|', $url) && (($uploads = wp_upload_dir()) && false === $uploads['error'])) $url = get_site_url() . $uploads['baseurl'] . "/$path";
	if ($path && 0 !== strpos($path, '/') && !preg_match('|^.:\\\|', $path) && (($uploads = wp_upload_dir()) && false === $uploads['error'])) $actual_file_path = $uploads['basedir'] . "/$path";

	$image_src[] = $url;
	$image_src[] = $originalWidth;
	$image_src[] = $originalHeight;


	if (!empty($actual_file_path)) {
		$file_info = pathinfo($actual_file_path);
		$extension = '.' . $file_info['extension'];

		// the image path without the extension
		$no_ext_path = $file_info['dirname'] . '/' . $file_info['filename'];

		$cropped_img_path = $no_ext_path . '-ais-' . $targetWidth . 'x' . $targetHeight . $extension;

		// checking if the file size is larger than the target size
		// if it is smaller or the same size, stop right here and return
		if ($originalWidth > $targetWidth || $originalHeight > $targetHeight)
		{
			// the file is larger, check if the resized version already exists (for $crop = true but will also work for $crop = false if the sizes match)
			if ($remote) {
				$cropped_img_url = str_replace(basename($url) , basename($cropped_img_path) , $url);
				$headers = ($cropped_img_url !== '' && !empty($cropped_img_url)) ? get_headers($cropped_img_url) : array('');
				$cropped_exists = stripos($headers[0],"200 OK") ? true : false;
				if ($cropped_exists) {
					$vt_image = array(
						'url' => $cropped_img_url,
						'width' => $targetWidth,
						'height' => $targetHeight,
						'single_width' => $single_width,
						'single_height' => $single_height,
					);
					return $vt_image;
				} else {
					$remote_actual_file_path = $actual_file_path;
					$actual_file_path = preg_replace('/\?.*/', '', $url);
				}
			} else {
				if (file_exists($cropped_img_path)) {
					$cropped_img_url = str_replace(basename($url) , basename($cropped_img_path) , $url);
					$vt_image = array(
						'url' => $cropped_img_url,
						'width' => $targetWidth,
						'height' => $targetHeight,
						'single_width' => $single_width,
						'single_height' => $single_height,
					);
					return $vt_image;
				}
			}

			// no cache files - let's finally resize it
			$img_editor = wp_get_image_editor($actual_file_path);

			if (is_wp_error($img_editor) || is_wp_error($img_editor->resize($targetWidth, $targetHeight, $crop))) {
				return array(
					'url' => '',
					'width' => '',
					'height' => ''
				);
			}

			$suffix = $img_editor->get_suffix();

			if ($remote) {
				$path = pathinfo($remote_actual_file_path);
				$remote_path = pathinfo($actual_file_path);
				$new_img_path = $img_editor->generate_filename('ais-' . $suffix, $path['dirname']);
				$remote_img_path = $img_editor->generate_filename('ais-' . $suffix, $remote_path['dirname']);
			} else {
				$new_img_path = $img_editor->generate_filename('ais-' . $suffix);
			}

			if (is_wp_error($img_editor->save($new_img_path))) {
				return array(
					'url' => '',
					'width' => '',
					'height' => ''
				);
			} else {
				if ($remote) {
					/** ADD CODE TO SAVE FINAL IMAGE TO S3 **/
					add_filter( 'as3cf_get_attached_file_copy_back_to_local', '__return_true' );
					get_attached_file( $media_id );
					$media_data = wp_get_attachment_metadata($media_id );
					$mime = get_post_mime_type($media_id);
					$media_data['sizes']['ais_' . $targetWidth . '_' . $targetHeight] = array(
						'file' => basename($remote_img_path),
						'width' => $targetWidth,
						'height' => $targetHeight,
						'mime-type' => $mime,
					);
					wp_update_attachment_metadata($media_id, $media_data);
				}
			}

			if (!is_string($new_img_path)) {
				return array(
					'url' => '',
					'width' => '',
					'height' => ''
				);
			}

			$new_img_size = getimagesize($new_img_path);
			$new_img = str_replace(basename($url) , basename($new_img_path) , $url);

			// resized output
			$vt_image = array(
				'url' => $new_img,
				'width' => $new_img_size[0],
				'height' => $new_img_size[1],
				'single_width' => $single_width,
				'single_height' => $single_height,
			);

			//If using Wp Smushit
			if (class_exists('WpSmush', false)) {
				global $WpSmush;
				if( filesize( $new_img_path ) < WP_SMUSH_MAX_BYTES ){
					$WpSmush->do_smushit($new_img_path, $new_img);
				}
			}

			return $vt_image;
		} else {
			if ($remote) {
				$url = wp_get_attachment_image_src( $media_id, 'full' );
				$url = $url[0];
				$headers = ($url !== '' && !empty($url)) ? get_headers($url) : array('');
				$media_url = stripos($headers[0],"200 OK") ? $url : '';
				if ($media_url === '') {
					$media_data = wp_get_attachment_metadata($media_id );
					$mime = get_post_mime_type($media_id);
					$media_data['sizes']['full'] = array(
						'file' => basename($url),
						'width' => $originalWidth,
						'height' => $originalHeight,
						'mime-type' => $mime,
					);
					wp_update_attachment_metadata($media_id, $media_data);
				}
			}
		}

		// default output - without resizing
		$vt_image = array(
			'url' => $url,
			'width' => $originalWidth,
			'height' => $originalHeight,
			'single_width' => $single_width,
			'single_height' => $single_height,
		);

		return $vt_image;
	}

	return false;
}

/**
 * delete all the AI images version when an attachment is erased
 */
function ais_delete_images($postId)
{
	global $wpdb;

	$filename = get_attached_file($postId);

	if ($filename !== '') {
		$extension_pos = strrpos($filename, '.');
		$filename_wildcard = substr($filename, 0, $extension_pos) . '*' . substr($filename, $extension_pos);
		$image_block = glob($filename_wildcard);
		foreach ($image_block as $key => $image) {
			if (false !== strpos($image_block[$key],'-ais-')) {
				unlink($image_block[$key]);
			}
		}
	}
}
add_action( 'delete_attachment', 'ais_delete_images' );

/**
 * Async adaptive images
 */
function ais_async_adaptive_images()
{
  	$data = json_decode(stripslashes($_POST['images']));
  	$images = array();

  	foreach ($data as &$d) {
  		$media_id = explode('-', $d->uid);
		$media_id = $media_id[0];
  		$resized = ais_resize_image($media_id, $d->url, $d->path, $d->origwidth, $d->origheight, $d->singlew, $d->singleh, $d->crop, $d->fixed, array('images' => $d->physicalWidth, 'screen' => $d->logicalWidth));
  		$resized['uid'] = $d->uid;
  		$images[] = $resized;
  	}

  	exit(json_encode($images));
}
add_action( 'zoo_ajax_async_adaptive_images', 'ais_async_adaptive_images' );
add_action( 'zoo_ajax_nopriv_async_adaptive_images', 'ais_async_adaptive_images' );
