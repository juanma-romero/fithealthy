<?php
if (!class_exists('WP_Customize_Setting', false)) {
    require ABSPATH . 'wp-includes/class-wp-customize-setting.php';
}

/**
 * ZooCustomizeSetting
 */
class ZooCustomizeSetting extends WP_Customize_Setting
{
    /**
     * Do import
     */
    function import($value)
    {
        return $this->update($value);
    }
}
