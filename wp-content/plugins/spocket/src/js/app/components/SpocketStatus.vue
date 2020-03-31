<script>
import $ from 'jquery';
import queryString from 'query-string';
import SpocketStatusConnected from './SpocketStatusConnected.vue';
import SpocketStatusDisconnected from './SpocketStatusDisconnected.vue';

export default {
  components: {
    SpocketStatusConnected,
    SpocketStatusDisconnected,
  },
  props: {
    nonces: {
      type: Object,
      default () {
        return {};
      },
    },
    ajaxUrl: {
      type: String,
      default: '',
    },
    storeUrl: {
      type: String,
      default: '',
    },
    spocketAdminUrl: {
      type: String,
      default: '',
    },
    spocketAuthToken: {
      type: String,
      default: '',
    },
    spocketUserId: {
      type: String,
      default: '',
    },
    spocketShopUrl: {
      type: String,
      default: '',
    },
    l10n: {
      type: Object,
      default () {
        return {};
      },
    },
  },
  data () {
    return {
      getSpocketStatusInProgress: false,
      spocketStatus: null,
    };
  },
  mounted () {
    this.getSpocketStatus ();
  },
  methods: {
    getSpocketStatus () {
      if (this.getSpocketStatusInProgress) {
        return;
      }

      this.getSpocketStatusInProgress = true;

      const queryArgs = {
        action: 'spocket_status',
        nonce: this.nonces.getSpocketStatus,
      };
      const getSpocketStatusUrl = `${this.ajaxUrl}?${queryString.stringify (queryArgs)}`;

      $.ajax ({
        url: getSpocketStatusUrl,
        success: ({
          data: {
            spocketStatus = {},
          } = {},
        } = {}) => {
          this.spocketStatus = spocketStatus;
        },
        error: () => {
          setTimeout (this.getSpocketStatus, 1000);
        },
        complete: () => {
          this.getSpocketStatusInProgress = false;
        },
      });
    },
    refreshSpocketStatus () {
      this.spocketStatus = null;
      this.getSpocketStatus ();
    },
    setErrorMessage ({ message }) {
      this.$emit ('setErrorMessage', {
        message,
      });
    },
  },
};
</script>

<template>
  <div class="Spocket-Status">
    <p v-if="!spocketStatus">
      Please wait, checking status...
    </p>
    <SpocketStatusDisconnected
    v-else-if="!spocketStatus.connected"
    :ajax-url="ajaxUrl"
    :nonces="nonces"
    :store-url="storeUrl"
    :spocket-admin-url="spocketAdminUrl"
    :spocket-user-id="spocketUserId"
    @refreshSpocketStatus="refreshSpocketStatus"
    @setErrorMessage="setErrorMessage"
    />
    <SpocketStatusConnected
    v-else
    :ajax-url="ajaxUrl"
    :nonces="nonces"
    :spocket-auth-token="spocketAuthToken"
    :spocket-shop-url="spocketShopUrl"
    @refreshSpocketStatus="refreshSpocketStatus"
    @setErrorMessage="setErrorMessage"
    />
  </div>
</template>
