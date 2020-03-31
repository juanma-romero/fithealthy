<script>
import $ from 'jquery';
import queryString from 'query-string';
import DirectSignupModal from './DirectSignupModal.vue';

export default {
  components: {
    DirectSignupModal,
  },
  props: {
    nonces: {
      type: Object,
      default () {
        return {};
      },
    },
    storeUrl: {
      type: String,
      default: '',
    },
    spocketAdminUrl: {
      type: String,
      default: '',
    },
    spocketUserId: {
      type: String,
      default: '',
    },
    ajaxUrl: {
      type: String,
      default: '',
    },
  },
  data () {
    return {
      showDirectSignupModal: false,
    };
  },
  computed: {
    connectUrl () {
      const spocketUrl = () => {
        const env = process.env.NODE_ENV;
        const apiDev = `${process.env.API_URL}/woocommerce/integration`;

        return env === 'development' ? apiDev : 'https://newapi.spocket.co/woocommerce/integration';
      };

      const queryArgs = {
        store_url: this.storeUrl,
        return_url: this.spocketAdminUrl,
      };

      if (this.spocketUserId) {
        queryArgs.user_id = this.spocketUserId;
      }

      return `${spocketUrl ()}?${queryString.stringify (queryArgs)}`;
    },

  },
  methods: {
    removeStoreAuthorizationKeyFromRequest (event) {
      const connectUrl = event.target.getAttribute ('href');

      const queryArgs = {
        action: 'spocket_remove_store_authorization_key_from_request',
        nonce: this.nonces.removeStoreAuthorizationKeyFromRequest,
      };

      const removeAuthorizationKeyUrl = `${this.ajaxUrl}?${queryString.stringify (queryArgs)}`;
      $.ajax ({
        type: 'GET',
        url: removeAuthorizationKeyUrl,
        success: (response) => {
          if (response.data.status === 'removed') {
            window.location = connectUrl;
          }
        },
      });
    },

    refreshSpocketStatus () {
      this.$emit ('refreshSpocketStatus');
    },

    openDirectSignupModal () {
      this.showDirectSignupModal = true;
    },

    closeModal () {
      this.showDirectSignupModal = false;
    },
  },
};
</script>

<template>
  <div class="Spocket-Status-Disconnected">
    <p>You are currently not connected to your Spocket account.</p>
    <div class="Spocket-Status-Disconnected-actions">
      <div class="Spocket-Status-Disconnected-actionsAction">
        <a
        :href="connectUrl"
        class="button button-primary"
        @click.prevent="removeStoreAuthorizationKeyFromRequest"
        >Connect to Spocket</a>
      </div>

      <div class="Spocket-Status-Disconnected-actionsAction">
        <a
        class="button button-primary"
        href="#"
        @click="openDirectSignupModal"
        >Connect with Auth key</a>
      </div>

      or
      <div class="Spocket-Status-Disconnected-actionsAction">
        <a
        class="button"
        href="#"
        @click.prevent="refreshSpocketStatus"
        >Refresh</a>
      </div>
    </div>

    <DirectSignupModal
    v-show="showDirectSignupModal"
    :ajax-url="ajaxUrl"
    :connect-url="connectUrl"
    :nonces="nonces"
    @closeModal="closeModal"/>
  </div>
</template>

<style lang="scss">
.Spocket-Status-Disconnected-actions {
  align-items: center;
  display: flex;
  flex-flow: row wrap;
}

.Spocket-Status-Disconnected-actionsAction {
  margin-bottom: 5px;
  margin-right: 10px;
  margin-top: 5px;
}

.Spocket-Status-Disconnected-actionsAction:last-child {
  margin-left: 10px;
}
</style>
