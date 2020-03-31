#!/bin/bash

# Download and Copy woocommerce
WOOCOMMERCE_VERSION=3.6.4
WOOCOMMERCE_FILE=woocommerce.$WOOCOMMERCE_VERSION.zip

wget https://downloads.wordpress.org/plugin/$WOOCOMMERCE_FILE \
&& unzip $WOOCOMMERCE_FILE \
&& rm $WOOCOMMERCE_FILE

wget https://downloads.wordpress.org/plugin/test-gateway-for-woocommerce.zip \
&& unzip test-gateway-for-woocommerce.zip \
&& rm test-gateway-for-woocommerce.zip
