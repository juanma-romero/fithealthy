<script>
import $ from 'jquery';
import queryString from 'query-string';

export default {
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
    spocketAuthToken: {
      type: String,
      default: '',
    },
    spocketShopUrl: {
      type: String,
      default: '',
    },
  },
  data () {
    return {
      disconnectSpocketInProgress: false,
      appUrl: process.env.NODE_ENV === 'development' ? 'http://localhost:3000' : 'https://app.spocket.co',
    };
  },
  methods: {
    refreshSpocketStatus () {
      this.$emit ('refreshSpocketStatus');
    },
    disconnectSpocket () {
      if (this.disconnectSpocketInProgress) {
        return;
      }

      this.disconnectSpocketInProgress = true;

      const queryArgs = {
        action: 'spocket_disconnect',
        nonce: this.nonces.disconnectSpocketNonce,
      };

      const disconnectSpocketUrl = `${this.ajaxUrl}?${queryString.stringify (queryArgs)}`;

      $.ajax ({
        url: disconnectSpocketUrl,
        success: ({
          data: {
            disconnected = false,
          } = {},
        } = {}) => {
          if (!disconnected) {
            this.$emit ('setErrorMessage', {
              message: 'Disconnecting from the Spocket failed, please try again or contact support.',
            });
          }

          window.location.reload (true);

          this.refreshSpocketStatus ();
        },
        error: () => {
          setTimeout (this.disconnectSpocket, 1000);
        },
        complete: () => {
          this.disconnectSpocketInProgress = false;
        },
      });
    },
  },
};
</script>

<template>
  <div class="Spocket-Status-Connected">
    <p>Your store has been successfully connected to your Spocket account.</p>
    <div class="Spocket-Status-Connected-actions">
      <div
      class="Spocket-Status-Connected-actionsAction
      Spocket-Status-Connected-actionsAction--fullWidth"
      >
        <a
        :href="`${appUrl}/search?auth_token=${spocketAuthToken}`"
        target="_blank"
        class="button button-primary">Go to Spocket</a>
      </div>
      <div class="Spocket-Status-Connected-actionsAction">
        <a
        class="button"
        href="#"
        @click.prevent="disconnectSpocket"
        v-html="disconnectSpocketInProgress ? 'Disconnecting' : 'Disconnect from Spocket'"
        />
      </div>
      or
      <div class="Spocket-Status-Connected-actionsAction">
        <a
        class="button"
        href="#"
        @click.prevent="refreshSpocketStatus"
        >Refresh</a>
      </div>
    </div>
  </div>
</template>

<style lang="scss">
.Spocket-Status-Connected-actions {
  align-items: center;
  display: flex;
  flex-flow: row wrap;
}

.Spocket-Status-Connected-actionsAction {
  margin-bottom: 5px;
  margin-right: 10px;
  margin-top: 5px;
}

.Spocket-Status-Connected-actionsAction:last-child {
  margin-left: 10px;
}

.Spocket-Status-Connected-actionsAction--fullWidth {
  flex: 0 0 100%;
}
</style>
