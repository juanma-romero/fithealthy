<script>
import $ from 'jquery';
import queryString from 'query-string';
import Swal from 'sweetalert2/dist/sweetalert2.js';
import 'sweetalert2/src/sweetalert2.scss';

export default {
  props: {
    nonces: {
      type: Object,
      default () {
        return {};
      },
    },
    showDirectSignupModal: {
      type: Boolean,
      default: false,
    },
    ajaxUrl: {
      type: String,
      default: '',
    },
    connectUrl: {
      type: String,
      default: '',
    },
  },
  data () {
    return {
      storeAuthorizationKey: '',
      hasError: false,
      messageError: '',
    };
  },
  methods: {
    finishDirectSignup () {
      if (!this.isKeySizeValid ()) {
        this.hasError = true;
        this.messageError = 'Auth key is invalid';
      } else {
        this.hasError = false;
        this.messageError = '';

        const queryArgs = {
          action: 'spocket_direct_signup',
          nonce: this.nonces.directSignup,
        };

        const finishDirectSignupUrl = `${this.ajaxUrl}?${queryString.stringify (queryArgs)}`;

        $.ajax ({
          type: 'POST',
          url: finishDirectSignupUrl,
          data: {
            storeAuthorizationKey: this.storeAuthorizationKey,
          },
          success: (response) => {
            if (response.data.direct_signup_status === 'created') {
              window.location = this.connectUrl;
            } else {
              Swal.fire ({
                type: 'warning',
                title: 'Something went wrong',
                text: response.data.message,
              });
            }
          },
        });

        this.$emit ('closeModal');
      }
    },

    isKeySizeValid () {
      return this.storeAuthorizationKey.length === 32;
    },

    clearMessageError () {
      if (this.isKeySizeValid ()) {
        this.hasError = false;
        this.messageError = '';
      }
    },

    closeModal () {
      this.hasError = false;
      this.messageError = '';
      this.$emit ('closeModal');
    },
  },
};
</script>

<template>
  <div>
    <div class="modal-mask">
      <div class="modal-wrapper">
        <div class="modal-container">
          <div class="modal-header">
            <slot name="header">
              <h3>Connect with Auth Key</h3>
            </slot>
          </div>

          <div class="modal-body">
            <slot name="body">
              <input
              v-model="storeAuthorizationKey"
              :class="{ 'error' : hasError }"
              placeholder="Enter Auth Key provided in your Spocket account"
              type="text"
              @focusout="clearMessageError">
              <span class="message-error">{{ messageError }}</span>
            </slot>
          </div>

          <div class="modal-footer">
            <slot name="footer">
              <button
              class="button button-close button-large pull-right"
              @click="closeModal">
                Close
              </button>
            </slot>

            <slot name="footer">
              <button
              class="button button-primary button-large pull-right"
              @click="finishDirectSignup">
                Connect
              </button>
            </slot>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style lang="scss">
.modal-mask {
  position: fixed;
  z-index: 9998;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, .5);
  display: table;
  transition: opacity .3s ease;
}

.modal-wrapper {
  display: table-cell;
  vertical-align: middle;
}

.modal-container {
  width: 500px;
  height: 150px;
  margin: 0px auto;
  padding: 20px 30px;
  background-color: #fff;
  border-radius: 2px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, .33);
  transition: all .3s ease;
  font-family: Helvetica, Arial, sans-serif;
}

.modal-header h3 {
  margin-top: 0;
  color: #333;
  text-align: center;
}

.modal-body {
  margin: 20px 0;
  input { width: 100%;
    height: 40px;
    font-size: 1.3em;
  }
}

.pull-right {
  float: right !important;
}

.button-close {
  margin-left: 5px !important;
}

.modal-enter {
  opacity: 0;
}

.modal-leave-active {
  opacity: 0;
}

.error {
  border: 1px solid coral !important;
}

.message-error {
  font-size: 10px;
  font-style: italic;
  color: coral;
}

.modal-enter .modal-container,
.modal-leave-active .modal-container {
  -webkit-transform: scale(1.1);
  transform: scale(1.1);
}
</style>
